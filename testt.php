<?php

/**
 * @param ListNode $l1
 * @param ListNode $l2
 * @return ListNode
 */
function numbers($l1, $l2){
    $rl1 = array_reverse(array($l1));
    $rl2 = array_reverse(array($l2));
    $num1 = ''; $num2 = '';
    for($i=0; $i<count($rl1[0]); $i++){
        $num1 = $num1 . $rl1[0][$i];
    }
    for($i=0; $i<count($rl2[0]); $i++){
        $num2 = $num2 . $rl2[0][$i];
    }
    $sum = (int)$num1 + (int) $num2;
    $revSum = strrev($sum);
    $ans = explode(",",$revSum);
    return $ans;
}
$l1 =
[2,4,3];
$l2 =
[5,6,4];
echo numbers($l1, $l2);
