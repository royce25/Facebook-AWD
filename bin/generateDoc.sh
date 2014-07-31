#!/bin/sh

rm -R ../docs
phpdoc -d ../ -t ../docs/  --ignore "../vendor/facebook/,../vendor/composer/,autoload.php,../Resources/" --template="responsive" --title="Facebook AWD API"