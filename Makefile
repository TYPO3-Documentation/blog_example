.PHONY: help
help: ## Displays this list of targets with descriptions
    @echo "The following commands are available:\n"
    @grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: rector
rector: ## Run rector
	.Build/bin/rector

.PHONY: fix-cs
fix-cs: ## Fix PHP coding styles
	.Build/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
