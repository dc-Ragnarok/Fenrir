#!/bin/bash

composer dump-autoload -o;
composer dump-autoload -o 2> >(grep -i Skipping) | wc -l | xargs test 2 -eq;
