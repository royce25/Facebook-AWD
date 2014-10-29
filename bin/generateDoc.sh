#!/bin/sh

rm -R ../docs
phpdoc -d ../ -t ../docs/  --ignore "*/vendor/facebook/*,*/vendor/composer/*,*/Resources/*"  --title="Facebook AWD API"