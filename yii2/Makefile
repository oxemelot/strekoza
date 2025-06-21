.PHONY: lint fix check fix-phpdoc fix-use

PHP_CS=vendor/bin/phpcs
PHP_CS_FIXER=vendor/bin/php-cs-fixer
BIN_FIX_PHPDOC=bin/fix_phpdoc.php
BIN_FIX_USE=bin/fix_use.php

lint:
	$(PHP_CS) -d memory_limit=512M

fix:
	$(PHP_CS_FIXER) fix

fix-phpdoc:
	php $(BIN_FIX_PHPDOC)

fix-use:
	php $(BIN_FIX_USE)

check:
	$(PHP_CS_FIXER) fix --dry-run --diff

check-phpdoc:
	php $(BIN_FIX_PHPDOC) . --dry-run

check-use:
	php $(BIN_FIX_USE) . --dry-run
