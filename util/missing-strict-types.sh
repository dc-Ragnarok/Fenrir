#!/bin/bash

grep -riL "^declare(strict_types=1)" src fakes tests phpcs/Sniffs;
grep -riL "^declare(strict_types=1)" src fakes tests phpcs/Sniffs | wc -l | xargs test 0 -eq;
