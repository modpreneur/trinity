#!/bin/bash sh

composer update

phpunit

phpstan analyse FrameworkBundle --level=4

#tail -f /dev/null