#!/bin/bash

grep -riL "^declare(strict_types=1)" src fakes tests;
grep -riL "^declare(strict_types=1)" src fakes tests | wc -l | xargs test 0 -eq;
