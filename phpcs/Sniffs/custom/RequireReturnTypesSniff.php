<?php
/**
 * This sniff prohibits the use of Perl style hash comments.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Your Name <you@domain.net>
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

namespace PHP_CodeSniffer\Standards\MyStandard\Sniffs\Commenting;

use Exception;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class RequireReturnTypesSniff implements Sniff
{


    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return array(T_FUNCTION);

    }//end register()


    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The current file being checked.
     * @param int                         $stackPtr  The position of the current token in the
     *                                               stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
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


        // var_dump($stackPtr, $pointer, $tokens[$pointer + 6]);
        // die();


        // $parenthesisOpen = $phpcsFile->getTokens()[$stackPtr + 3];

        // if ($parenthesisOpen['type'] !== "T_OPEN_PARENTHESIS") {
        //     return;
        // }

        // $count = stackPtr + 3;
        // $hasReturn = false;

        // do {

        // }

        // $return = $tokens[$parenthesisOpen['parenthesis_closer'] + 3];

        // var_dump($return);

        // die();

        // if ($return['type'] === 'T_OPEN_CURLY_BRACKET') {
        //     $phpcsFile->addError('Return types are required', $stackPtr, 'Not found');
        // }


        // var_dump($phpcsFile->getTokens()[$parenthesisOpen['parenthesis_closer'] + 3]);

        // die();
        // return;
        // $tokens = $phpcsFile->getTokens();
        // if ($tokens[$stackPtr]['content']{0} === '#') {
        //     $error = 'Hash comments are prohibited; found %s';
        //     $data  = array(trim($tokens[$stackPtr]['content']));
        //     $phpcsFile->addError($error, $stackPtr, 'Found', $data);
        // }

    }//end process()


}//end class

?>
