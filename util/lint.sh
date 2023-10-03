#!/bin/bash

# Initialize a variable to track whether any errors were found
ERROR_FOUND=0

# Find all PHP files in the src directory and its subdirectories
# and lint them using php -l
find src/ -type f -name "*.php" -print0 | while IFS= read -r -d $'\0' file; do
    php -l "$file" >/dev/null 2>&1

    # Check the exit code of php -l
    if [ $? -ne 0 ]; then
        echo "Found error in file: $file"
        exit 1;
    fi
done
