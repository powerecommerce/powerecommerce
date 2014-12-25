# Power Ecommerce System Namespace

[![Build Status](https://travis-ci.org/powerecommerce/system.svg?branch=master)](https://travis-ci.org/powerecommerce/system)

This is the fundamental part of the system.

## Tests

### Run:

```
$ ./vendor/bin/phpunit [--group <name> [--exclude-group <name>]] tests/
```

### Generate:

```
$ ./vendor/bin/phpunit-skelgen generate-test "<\name\space\class>" src/<filename> "<\name\space\classTest>" tests/<filenameTest>    
```

### Coverage:

```
$ ./vendor/bin/phpunit --colors --coverage-html var/coverage/  tests/    
```