conman
======

A configuration management utility. Intended to operate on a CI/build server, designed to output configuration for different applications (`role`s) across different environments (`realm`s).

Install
-------

Clone the repository and intialise the dependencies with composer:

```bash
$ git clone https://github.com/pricemaker/conman conman
$ cd conman
$ composer install
```

Usage
-----

There are several different configuration types that conman can generate. Most commonly, the config type:

```bash
$ cd conman
$ bin/conman config --role=test --realm=realm1
{"key1":"realm1 value1","key2":{"subkey1":"subvalue1","nullable":null,"callable":"callable result","callable2":"callable result 2"},"globals":{"test_key":"test_value in realm1"},"defaults":{"test_key":"subvalue1"},"child_only":"realm1 child value"}
```

The above shows the configuration for the test role in realm1. Simply, each role has defaults, and a series of rules that evaluate overrides per realm. The overrides are applied over the top of the defaults to create the final configuration. This allows for a different configuration per realm without needing to repeat configuration in several places.

As well as configs, conman can also manage plain text files (for example, a robots.txt or certificates). 

```bash
$ cd conman
$ bin/conman file test-file.txt --role=test --realm=realm1
This is a test file served by conman
```

The general intention is to pipe the output of the above commands into a file that the target application can read. 

Building phar
-------------

For distribution onto the build environment, conman can build itself into a phar archive. Once any changes have been commited, run

```bash
$ cd conman
$ bin/build
```

A file called  `dist/conman.phar` will be generated. This is a standalone package that can be placed anywhere on a build server. 
