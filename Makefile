help: ## Show this message
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

phpcs: ## Run PHP CS Fixer
	./vendor/bin/php-cs-fixer fix src

test: ## Run code tests
	./vendor/bin/phpunit --testdox

phpstan: ## Run phpstan level 8
	./vendor/bin/phpstan analyse src --level=5

test-phpcs: ## Run coding standard tests
	./vendor/bin/php-cs-fixer --diff --dry-run --using-cache=no -v fix src


.PHONY: clean-code test test-code test-qa test-phpcs test-psalm test-phpmd
