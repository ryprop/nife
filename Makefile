default: run-unit-tests

.PHONY: \
	clean \
	default \
	run-unit-tests \
	test-dependencies \
	vendor

clean:
	rm -rf vendor

vendor: composer.json
	composer install
	touch "$@"

test-dependencies: vendor

run-unit-tests: test-dependencies
	vendor/bin/phpsimplertest --bootstrap vendor/autoload.php test
