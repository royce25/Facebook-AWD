#!/bin/sh

mkdir -p ../../facebook-awd
rm -R ../../facebook-awd-docs/html
php phpDocumentor.phar -c phpdoc.xml
rm -R ../../facebook-awd-docs/cache
