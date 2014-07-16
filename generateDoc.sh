#!/bin/sh

rm -R ./docs
phpdoc -d ./ -t ./docs/  --ignore "vendors/AHWEBDEV/Framework/src/AHWEBDEV/Framework/apc.php,vendors/Facebook/,vendors/autoload/,Resources/"