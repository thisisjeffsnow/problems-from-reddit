<?php

/**
 * Function to find all permutations of a string.
 * https://stackoverflow.com/questions/2617055/how-to-generate-all-permutations-of-a-string-in-php
 */

function permute($str, $i, $n)
{
    if ($i == $n) {
        /* This is where the function would normally print out the permutation. */
        /* Additional testing for a valid equation, albeit really slowly.*/

        /* We can't have operators or equal signs at the edges of the string. */
        $first_char = $str[0];
        if ($first_char == "+" || $first_char == "-" || $first_char == "/" || $first_char == "*" || $first_char == "=") {
            return;
        }
        $last_char = $str[$n - 1];
        if ($last_char == "+" || $last_char == "-" || $last_char == "/" || $last_char == "*" || $last_char == "=") {
            return;
        }

        /* Two operators can't be next to each other. */
        if (preg_match("#.*[\+\-\*\/\=]{2,}.*#", $str)) {
            return;
        }

        /* 0 can't be the first digit of a number */
        if (preg_match("#.*0[1-9].*#", $str)) {
            return;
        }

        /* Division by 0 is not allowed. */
        if (preg_match("#.*\/0.*#", $str)) {
            return;
        }

        /* Skip trivial examples where multipication by 0, addition by 0, subtraction to/from 0, or 0 as a numerator are used. */
        if ($first_char == "0") return;
        if (preg_match("#.*[^1-9]0[^1-9].*#", $str)) return;
        if (preg_match("#.*[^1-9\=]0$#", $str)) return;

        /* String is now able to be evaluated. */
        /* Change = to == and evaluate it. */
        $str = str_replace("=", "==", $str);
        $strvalue = eval("return $str;");
        if ($strvalue) {
            echo "Solution: $str\n";
        }
    } else {
        for ($j = $i; $j < $n; $j++) {
            swap($str, $i, $j);
            permute($str, $i + 1, $n);
            swap($str, $i, $j); // backtrack.
        }
    }
}

// function to swap the char at pos $i and $j of $str.
function swap(&$str, $i, $j)
{
    $temp = $str[$i];
    $str[$i] = $str[$j];
    $str[$j] = $temp;
}

$str = "124-3/6*80=79+5";

permute($str, 0, strlen($str)); // call the function.
