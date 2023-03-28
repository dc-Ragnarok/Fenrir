#!/bin/bash

grep -riL "^declare(strict_types=1)" src fakes tests phpcs;
grep -riL "^declare(strict_types=1)" src fakes tests phpcs | wc -l | xargs test 0 -eq;
