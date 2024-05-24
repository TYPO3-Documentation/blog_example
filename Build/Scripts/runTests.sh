#!/usr/bin/env bash

#
# TYPO3 core test runner based on docker and docker-compose.
#

# Function to write a .env file in Build/testing-docker
# This is read by docker-compose and vars defined here are
# used in Build/testing-docker/docker-compose.yml
setUpDockerComposeDotEnv() {
    # Delete possibly existing local .env file if exists
    [ -e .env ] && rm .env
    # Set up a new .env file for docker-compose
    {
        echo "COMPOSE_PROJECT_NAME=local"
        # To prevent access rights of files created by the testing, the docker image later
        # runs with the same user that is currently executing the script. docker-compose can't
        # use $UID directly itself since it is a shell variable and not an env variable, so
        # we have to set it explicitly here.
        echo "HOST_UID=`id -u`"
        # Your local user
        echo "ROOT_DIR=${ROOT_DIR}"
        echo "HOST_USER=${USER}"
        echo "TEST_FILE=${TEST_FILE}"
        echo "TYPO3_VERSION=${TYPO3_VERSION}"
        echo "PHP_XDEBUG_ON=${PHP_XDEBUG_ON}"
        echo "PHP_XDEBUG_PORT=${PHP_XDEBUG_PORT}"
        echo "DOCKER_PHP_IMAGE=${DOCKER_PHP_IMAGE}"
        echo "EXTRA_TEST_OPTIONS=${EXTRA_TEST_OPTIONS}"
        echo "SCRIPT_VERBOSE=${SCRIPT_VERBOSE}"
        echo "CGLCHECK_DRY_RUN=${CGLCHECK_DRY_RUN}"
        echo "DATABASE_DRIVER=${DATABASE_DRIVER}"
    } > .env
}

# Options -a and -d depend on each other. The function
# validates input combinations and sets defaults.
handleDbmsAndDriverOptions() {
    case ${DBMS} in
        mysql|mariadb)
            [ -z "${DATABASE_DRIVER}" ] && DATABASE_DRIVER="mysqli"
            if [ "${DATABASE_DRIVER}" != "mysqli" ] && [ "${DATABASE_DRIVER}" != "pdo_mysql" ]; then
                echo "Invalid option -a ${DATABASE_DRIVER} with -d ${DBMS}" >&2
                echo >&2
                echo "call \"./Build/Scripts/runTests.sh -h\" to display help and valid options" >&2
                exit 1
            fi
            ;;
        postgres|sqlite)
            if [ -n "${DATABASE_DRIVER}" ]; then
                echo "Invalid option -a ${DATABASE_DRIVER} with -d ${DBMS}" >&2
                echo >&2
                echo "call \"./Build/Scripts/runTests.sh -h\" to display help and valid options" >&2
                exit 1
            fi
            ;;
    esac
}

# Load help text into $HELP
read -r -d '' HELP <<EOF
t3docs/blog-example test runner. Execute unit test suite and some other details.
Also used by github for test execution.

Recommended docker version is >=20.10 for xdebug break pointing to work reliably, and
a recent docker-compose (tested >=1.21.2) is needed.

Usage: $0 [options] [file]

No arguments: Run all unit tests with PHP 8.2

Options:
    -s <...>
        Specifies which test suite to run
            - cgl: cgl test and fix all php files
            - clean: clean up build and testing related files
            - composerUpdate: "composer update", handy if host has no PHP
            - composerUpdateRector: "composer update", for rector subdirectory
            - functional: functional tests
            - lint: PHP linting
            - phpstan: phpstan analyze
            - phpstanGenerateBaseline: regenerate phpstan baseline, handy after phpstan updates
            - rector: Apply Rector rules
            - renderDocumentation
            - testRenderDocumentation
            - unit (default): PHP unit tests

    -a <mysqli|pdo_mysql>
        Only with -s functional
        Specifies to use another driver, following combinations are available:
            - mysql
                - mysqli (default)
                - pdo_mysql
            - mariadb
                - mysqli (default)
                - pdo_mysql

    -d <sqlite|mariadb|mysql|postgres>
        Only with -s functional
        Specifies on which DBMS tests are performed
            - sqlite: (default) use sqlite
            - mariadb: use mariadb
            - mysql: use mysql
            - postgres: use postgres


    -p <8.2|8.3>
        Specifies the PHP minor version to be used
            - 8.2: use PHP 8.2
            - 8.3: use PHP 8.3

    -t <12|13>
        Only with -s composerUpdate
        Specifies the TYPO3 core major version to be used
            - 12 (default): use TYPO3 core v12
            - 13: Use TYPO3 core v13

    -e "<phpunit options>"
        Only with -s acceptance|functional|unit
        Additional options to send to phpunit (unit & functional tests). For phpunit, options starting with
        "--" must be added after options starting with "-".
        Example -e "--debug --filter canRetrieveValueWithGP" to enable verbose/debug output AND filter tests
        named "canRetrieveValueWithGP"

    -x
        Only with -s functional|unit
        Send information to host instance for test or system under test break points. This is especially
        useful if a local PhpStorm instance is listening on default xdebug port 9003. A different port
        can be selected with -y

    -n
        Only with -s cgl
        Activate dry-run in CGL check that does not actively change files and only prints broken ones.

    -u
        Update existing typo3/core-testing-*:latest docker images. Maintenance call to docker pull latest
        versions of the main php images. The images are updated once in a while and only the youngest
        ones are supported by core testing. Use this if weird test errors occur. Also removes obsolete
        image versions of typo3/core-testing-*.

    -v
        Enable verbose script output. Shows variables and docker commands.

    -h
        Show this help.

Examples:
    # Run unit tests using PHP 7.4
    ./Build/Scripts/runTests.sh
EOF

# Test if docker-compose exists, else exit out with error
if ! type "docker-compose" > /dev/null; then
  echo "This script relies on docker and docker-compose. Please install" >&2
  exit 1
fi

# Go to the directory this script is located, so everything else is relative
# to this dir, no matter from where this script is called.
THIS_SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd )"
cd "$THIS_SCRIPT_DIR" || exit 1

# Go to directory that contains the local docker-compose.yml file
cd ../testing-docker || exit 1

# Option defaults
if ! command -v realpath &> /dev/null; then
  echo "This script works best with realpath installed" >&2
  ROOT_DIR="${PWD}/../../"
else
  ROOT_DIR=`realpath ${PWD}/../../`
fi
TEST_SUITE="unit"
DBMS="sqlite"
PHP_VERSION="8.2"
TYPO3_VERSION="12"
PHP_XDEBUG_ON=0
PHP_XDEBUG_PORT=9003
EXTRA_TEST_OPTIONS=""
SCRIPT_VERBOSE=0
CGLCHECK_DRY_RUN=0
DATABASE_DRIVER=""
CONTAINER_BIN=""
CONTAINER_HOST="host.docker.internal"

# Option parsing
# Reset in case getopts has been used previously in the shell
OPTIND=1
# Array for invalid options
INVALID_OPTIONS=();
# Simple option parsing based on getopts (! not getopt)
while getopts ":s:a:d:p:t:e:xnhuv" OPT; do
    case ${OPT} in
        s)
            TEST_SUITE=${OPTARG}
            ;;
        a)
            DATABASE_DRIVER=${OPTARG}
            ;;
        b)
            if ! [[ ${OPTARG} =~ ^(docker|podman)$ ]]; then
                INVALID_OPTIONS+=("${OPTARG}")
            fi
            CONTAINER_BIN=${OPTARG}
            ;;
        d)
            DBMS=${OPTARG}
            ;;
        p)
            PHP_VERSION=${OPTARG}
            if ! [[ ${PHP_VERSION} =~ ^(8.2|8.3)$ ]]; then
                INVALID_OPTIONS+=("p ${OPTARG}")
            fi
            ;;
        t)
            TYPO3_VERSION=${OPTARG}
            if ! [[ ${TYPO3_VERSION} =~ ^(12|13)$ ]]; then
                INVALID_OPTIONS+=("p ${OPTARG}")
            fi
            ;;
        e)
            EXTRA_TEST_OPTIONS=${OPTARG}
            ;;
        x)
            PHP_XDEBUG_ON=1
            ;;
        y)
            PHP_XDEBUG_PORT=${OPTARG}
            ;;
        h)
            echo "${HELP}"
            exit 0
            ;;
        n)
            CGLCHECK_DRY_RUN=1
            ;;
        u)
            TEST_SUITE=update
            ;;
        v)
            SCRIPT_VERBOSE=1
            ;;
        \?)
            INVALID_OPTIONS+=(${OPTARG})
            ;;
        :)
            INVALID_OPTIONS+=(${OPTARG})
            ;;
    esac
done

# Exit on invalid options
if [ ${#INVALID_OPTIONS[@]} -ne 0 ]; then
    echo "Invalid option(s):" >&2
    for I in "${INVALID_OPTIONS[@]}"; do
        echo "-"${I} >&2
    done
    echo >&2
    echo "${HELP}" >&2
    exit 1
fi

# Move "7.4" to "php74", the latter is the docker container name
DOCKER_PHP_IMAGE=`echo "php${PHP_VERSION}" | sed -e 's/\.//'`

# Set $1 to first mass argument, this is the optional test file or test directory to execute
shift $((OPTIND - 1))
TEST_FILE=${1}

if [ ${SCRIPT_VERBOSE} -eq 1 ]; then
    set -x
fi

# Create .cache dir: composer need this.
mkdir -p .Build/.cache
mkdir -p .Build/web/typo3temp/var/tests

IMAGE_PREFIX="docker.io/"
# Non-CI fetches TYPO3 images (php and nodejs) from ghcr.io
TYPO3_IMAGE_PREFIX="ghcr.io/typo3/"
CONTAINER_INTERACTIVE="-it --init"

IS_CORE_CI=0
# ENV var "CI" is set by gitlab-ci. We use it here to distinct 'local' and 'CI' environment.
if [ "${CI}" == "true" ]; then
    IS_CORE_CI=1
    IMAGE_PREFIX=""
    CONTAINER_INTERACTIVE=""
fi

# determine default container binary to use: 1. podman 2. docker
if [[ -z "${CONTAINER_BIN}" ]]; then
    if type "podman" >/dev/null 2>&1; then
        CONTAINER_BIN="podman"
    elif type "docker" >/dev/null 2>&1; then
        CONTAINER_BIN="docker"
    fi
fi

IMAGE_PHP="${TYPO3_IMAGE_PREFIX}core-testing-$(echo "php${PHP_VERSION}" | sed -e 's/\.//'):latest"
IMAGE_ALPINE="${IMAGE_PREFIX}alpine:3.8"
IMAGE_DOCS="ghcr.io/typo3-documentation/render-guides:latest"

# Set $1 to first mass argument, this is the optional test file or test directory to execute
shift $((OPTIND - 1))

SUFFIX=$(echo $RANDOM)
NETWORK="t3docsexamples-${SUFFIX}"
${CONTAINER_BIN} network create ${NETWORK} >/dev/null

if [ ${CONTAINER_BIN} = "docker" ]; then
    # docker needs the add-host for xdebug remote debugging. podman has host.container.internal built in
    CONTAINER_COMMON_PARAMS="${CONTAINER_INTERACTIVE} --rm --network ${NETWORK} --add-host "${CONTAINER_HOST}:host-gateway" ${USERSET} -v ${ROOT_DIR}:${ROOT_DIR} -w ${ROOT_DIR}"
    CONTAINER_DOCS_PARAMS="${CONTAINER_INTERACTIVE} ${DOCS_PARAMS} --rm --network ${NETWORK} --add-host "${CONTAINER_HOST}:host-gateway" ${USERSET} -v ${ROOT_DIR}:/project"
else
    # podman
    CONTAINER_HOST="host.containers.internal"
    CONTAINER_COMMON_PARAMS="${CONTAINER_INTERACTIVE} ${CI_PARAMS} --rm --network ${NETWORK} -v ${ROOT_DIR}:${ROOT_DIR} -w ${ROOT_DIR}"
    CONTAINER_DOCS_PARAMS="${CONTAINER_INTERACTIVE} ${DOCS_PARAMS} --rm --network ${NETWORK} -v ${ROOT_DIR}:/project"
fi

if [ ${PHP_XDEBUG_ON} -eq 0 ]; then
    XDEBUG_MODE="-e XDEBUG_MODE=off"
    XDEBUG_CONFIG=" "
else
    XDEBUG_MODE="-e XDEBUG_MODE=debug -e XDEBUG_TRIGGER=foo"
    XDEBUG_CONFIG="client_port=${PHP_XDEBUG_PORT} client_host=host.docker.internal"
fi

# Suite execution
case ${TEST_SUITE} in
    cgl)
        if [ "${CGLCHECK_DRY_RUN}" -eq 1 ]; then
            COMMAND="php -dxdebug.mode=off .Build/bin/php-cs-fixer fix -v --dry-run --diff --config=./Build/php-cs-fixer/config.php --using-cache=no ."
        else
            COMMAND="php -dxdebug.mode=off .Build/bin/php-cs-fixer fix -v --config=./Build/php-cs-fixer/config.php --using-cache=no ."
        fi
        setUpDockerComposeDotEnv
        ${CONTAINER_BIN} run ${CONTAINER_COMMON_PARAMS} --name cgl-${SUFFIX} -e COMPOSER_CACHE_DIR=.Build/.cache/composer -e COMPOSER_ROOT_VERSION=${COMPOSER_ROOT_VERSION} ${IMAGE_PHP} /bin/sh -c "${COMMAND}"
        SUITE_EXIT_CODE=$?
        ;;
    clean)
        rm -rf ../../composer.lock ../../.Build/ ../../composer.json.testing
        ;;
    composerUpdate)
        setUpDockerComposeDotEnv
        cp ../../composer.json ../../composer.json.orig
        if [ -f "../../composer.json.testing" ]; then
            cp ../../composer.json ../../composer.json.orig
        fi
        docker-compose run composer_update
        cp ../../composer.json ../../composer.json.testing
        mv ../../composer.json.orig ../../composer.json
        SUITE_EXIT_CODE=$?
        docker-compose down
        ;;
    composerUpdateRector)
        setUpDockerComposeDotEnv
        rm -rf Build/rector/.Build/bin/ Build/rector/.Build/vendor Build/rector/composer.lock
        cp ${ROOT_DIR}/Build/rector/composer.json ${ROOT_DIR}/Build/rector/composer.json.orig
        if [ -f "${ROOT_DIR}/Build/rector/composer.json.testing" ]; then
            cp ${ROOT_DIR}/Build/rector/composer.json ${ROOT_DIR}/Build/rector/composer.json.orig
        fi
        COMMAND=(composer require --working-dir=${ROOT_DIR}/Build/rector --no-ansi --no-interaction --no-progress)
        ${CONTAINER_BIN} run ${CONTAINER_COMMON_PARAMS} --name composer-install-${SUFFIX} -e COMPOSER_CACHE_DIR=.Build/.cache/composer -e COMPOSER_ROOT_VERSION=${COMPOSER_ROOT_VERSION} ${IMAGE_PHP} "${COMMAND[@]}"
        SUITE_EXIT_CODE=$?
        cp ${ROOT_DIR}/Build/rector/composer.json ${ROOT_DIR}/Build/rector/composer.json.testing
        mv ${ROOT_DIR}/Build/rector/composer.json.orig ${ROOT_DIR}/Build/rector/composer.json
        ;;
    functional)
        handleDbmsAndDriverOptions
        setUpDockerComposeDotEnv
        case ${DBMS} in
            mariadb)
                echo "Using driver: ${DATABASE_DRIVER}"
                docker-compose run functional_mariadb10
                SUITE_EXIT_CODE=$?
                ;;
            mysql)
                echo "Using driver: ${DATABASE_DRIVER}"
                docker-compose run functional_mysql80
                SUITE_EXIT_CODE=$?
                ;;
            postgres)
                docker-compose run functional_postgres10
                SUITE_EXIT_CODE=$?
                ;;
            sqlite)
                # sqlite has a tmpfs as Web/typo3temp/var/tests/functional-sqlite-dbs/
                # Since docker is executed as root (yay!), the path to this dir is owned by
                # root if docker creates it. Thank you, docker. We create the path beforehand
                # to avoid permission issues.
                mkdir -p ${ROOT_DIR}/Web/typo3temp/var/tests/functional-sqlite-dbs/
                docker-compose run functional_sqlite
                SUITE_EXIT_CODE=$?
                ;;
            *)
                echo "Invalid -d option argument ${DBMS}" >&2
                echo >&2
                echo "${HELP}" >&2
                exit 1
        esac
        docker-compose down
        ;;
    lint)
        setUpDockerComposeDotEnv
        docker-compose run lint
        SUITE_EXIT_CODE=$?
        docker-compose down
        ;;
    phpstan)
        setUpDockerComposeDotEnv
        COMMAND="php -dxdebug.mode=off .Build/bin/phpstan --configuration=Build/phpstan/phpstan.neon"
        ${CONTAINER_BIN} run ${CONTAINER_COMMON_PARAMS} --name phpstan-${SUFFIX} -e COMPOSER_CACHE_DIR=.Build/.cache/composer -e COMPOSER_ROOT_VERSION=${COMPOSER_ROOT_VERSION} ${IMAGE_PHP} /bin/sh -c "${COMMAND}"
        SUITE_EXIT_CODE=$?
        ;;
    phpstanBaseline)
        setUpDockerComposeDotEnv
        COMMAND="php -dxdebug.mode=off .Build/bin/phpstan --configuration=Build/phpstan/phpstan.neon --generate-baseline=Build/phpstan/phpstan-baseline.neon -v"
        ${CONTAINER_BIN} run ${CONTAINER_COMMON_PARAMS} --name phpstan-${SUFFIX} -e COMPOSER_CACHE_DIR=.Build/.cache/composer -e COMPOSER_ROOT_VERSION=${COMPOSER_ROOT_VERSION} ${IMAGE_PHP} /bin/sh -c "${COMMAND}"
        SUITE_EXIT_CODE=$?
        ;;
    rector)
        if [ "${CGLCHECK_DRY_RUN}" -eq 1 ]; then
            COMMAND=(php -dxdebug.mode=off Build/rector/.Build/bin/rector -n --config=Build/rector/rector.php --clear-cache "$@")
        else
            COMMAND=(php -dxdebug.mode=off Build/rector/.Build/bin/rector --config=Build/rector/rector.php --clear-cache "$@")
        fi
        setUpDockerComposeDotEnv
        ${CONTAINER_BIN} run ${CONTAINER_COMMON_PARAMS} --name rector-${SUFFIX} -e COMPOSER_CACHE_DIR=.Build/.cache/composer -e COMPOSER_ROOT_VERSION=${COMPOSER_ROOT_VERSION} ${IMAGE_PHP} "${COMMAND[@]}"
        SUITE_EXIT_CODE=$?
        ;;
    renderDocumentation)
        setUpDockerComposeDotEnv
        COMMAND=(--config=Documentation "$@")
        mkdir -p Documentation-GENERATED-temp
        ${CONTAINER_BIN} run ${CONTAINER_INTERACTIVE} ${CONTAINER_DOCS_PARAMS} --name render-documentation-${SUFFIX} ${IMAGE_DOCS} "${COMMAND[@]}"
        SUITE_EXIT_CODE=$?
        ;;
    testRenderDocumentation)
        setUpDockerComposeDotEnv
        COMMAND=(--config=Documentation --no-progress --fail-on-log "$@")
        mkdir -p Documentation-GENERATED-temp
        ${CONTAINER_BIN} run ${CONTAINER_INTERACTIVE} ${CONTAINER_DOCS_PARAMS} --name render-documentation-test-${SUFFIX} ${IMAGE_DOCS} "${COMMAND[@]}"
        SUITE_EXIT_CODE=$?
        ;;
    unit)
        setUpDockerComposeDotEnv
        docker-compose run unit
        SUITE_EXIT_CODE=$?
        docker-compose down
        ;;
    update)
        # pull typo3/core-testing-* versions of those ones that exist locally
        echo "> pull ${TYPO3_IMAGE_PREFIX}core-testing-* versions of those ones that exist locally"
        ${CONTAINER_BIN} images "${TYPO3_IMAGE_PREFIX}core-testing-*" --format "{{.Repository}}:{{.Tag}}" | xargs -I {} ${CONTAINER_BIN} pull {}
        echo ""
        # remove "dangling" typo3/core-testing-* images (those tagged as <none>)
        echo "> remove \"dangling\" ${TYPO3_IMAGE_PREFIX}/core-testing-* images (those tagged as <none>)"
        ${CONTAINER_BIN} images --filter "reference=${TYPO3_IMAGE_PREFIX}/core-testing-*" --filter "dangling=true" --format "{{.ID}}" | xargs -I {} ${CONTAINER_BIN} rmi -f {}
        echo ""
        ;;
    *)
        echo "Invalid -s option argument ${TEST_SUITE}" >&2
        echo >&2
        echo "${HELP}" >&2
        exit 1
esac

exit $SUITE_EXIT_CODE
