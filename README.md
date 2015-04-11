# Power Ecommerce

[![Build Status](https://travis-ci.org/powerecommerce/powerecommerce.svg?branch=master)](https://travis-ci.org/powerecommerce/powerecommerce)

## Atom Architecture

![Atom Architecture](/atom.png)

## Install

```
$ composer install
```

## Tests

### Run:

```
$ ./vendor/bin/phpunit [--group <name> [--exclude-group <name>]] tests/
```

### Generate:

```
$ ./vendor/bin/phpunit-skelgen generate-test "<\name\space\class>" \
 src/<filename> "<\name\space\classTest>" tests/<filenameTest>
```

### Coverage:

```
$ ./vendor/bin/phpunit --colors --coverage-html var/coverage/ tests/
```