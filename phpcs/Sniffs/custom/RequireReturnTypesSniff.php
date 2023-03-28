<?php

declare(strict_types=1);

namespace Phpcs\Ragnarok\Fenrir;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class RequireReturnTypesSniff implements Sniff
{
    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $pointer = $stackPtr + 2;

        $tokens = $phpcsFile->getTokens();
        $functionName = $tokens[$pointer];

        if (isset($functionName['content']) && $functionName['content'] === '__construct') {
            return;
        }

        do {
            $pointer++;
            $parenthesisClose = $tokens[$pointer];
        } while ($parenthesisClose['type'] !== "T_CLOSE_PARENTHESIS");


        do {
            $pointer++;
            $returnTypeIndicator = $tokens[$pointer];
        } while (!in_array($returnTypeIndicator['type'], ['T_OPEN_CURLY_BRACKET', "T_COLON"]));

        if ($returnTypeIndicator['type'] === 'T_OPEN_CURLY_BRACKET') {
            $phpcsFile->addError('Return type is require', $stackPtr, 'Not found');
        }
    }
}
