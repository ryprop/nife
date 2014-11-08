default: run-tests

.PHONY: default vendor run-tests

vendor: composer.json
	composer install
	touch "$@"

run-tests: vendor
	phpunit --bootstrap vendor/autoload.php test
