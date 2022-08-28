[![Latest Stable Version](https://poser.pugx.org/friendsoftypo3/blog-example/v/stable.svg)](https://extensions.typo3.org/extension/blog_example/)
[![TYPO3 11](https://img.shields.io/badge/TYPO3-11-orange.svg?style=flat-square)](https://get.typo3.org/version/11)
[![Total Downloads](https://poser.pugx.org/friendsoftypo3/blog-example/d/total.svg)](https://packagist.org/packages/friendsoftypo3/blog-example)
[![Monthly Downloads](https://poser.pugx.org/friendsoftypo3/blog-example/d/monthly)](https://packagist.org/packages/friendsoftypo3/blog-example)

# TYPO3 extension ``blog_example``

This example provides the code examples for [Extbase reference] (https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ExtensionArchitecture/Extbase/Reference/Index.html#extbase-reference)
of the TYPO3 project.

The Code examples are automatically extracted with the TYPO3 documentation
code-snippet tool (https://github.com/TYPO3-Documentation/t3docs-codesnippets)

After changes to the code the snippets in the TYPO3-Reference-CoreApi
have to be regenerated.

```
ddev exec vendor/bin/typo3  restructured_api_tools:php_domain public/fileadmin/TYPO3CMS-Reference-CoreApi/Documentation/CodeSnippets/
```

It was originally written by Sebastian Kurfuerst and Jochen Rau (Thanks!) and
adjusted over time to reflect current development in the TYPO3 project.

|                  | URL                                                  |
|------------------|------------------------------------------------------|
| **Repository:**  | https://github.com/FriendsOfTYPO3/blog_example       |
| **TER:**         | https://extensions.typo3.org/extension/blog_example/ |

# Running tests

The blog-example comes with a simple demo set of tests. It relies
on the runTests.sh script which is a simplified version of a similar script from the TYPO3 core.
Find detailed usage examples by executing `Build/Scripts/runTests.sh -h` and have a look at
`.github/workflows/tests.yml` to see how this is used in CI.

Example usage:

```
Build/Scripts/runTests.sh -s composerUpdate
Build/Scripts/runTests.sh -s unit
```

Running some tests locally can fix errors that are just displayed in actions on github.  
The following command can fix things like linebreaks or indentations:

```
Build/Scripts/runTests.sh -s cgl
```

# Normalize composer.json

```
Build/Scripts/runTests.sh -s composerNormalize -n
```

