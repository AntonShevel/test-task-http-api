<?php
/**
 * Date: 10/16/14
 * Time: 2:09 PM
 */




array_shift($argv);

$ch = curl_init();

$curlOptions = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_URL => $argv[1],
    CURLOPT_CUSTOMREQUEST => $argv[0]
);

if (!empty($argv[2])) {
    $curlOptions[CURLOPT_POSTFIELDS] = $argv[2];
}

curl_setopt_array($ch, $curlOptions);

print_r('response:');
print_r("\n");
print_r(curl_exec($ch));
print_r("\n");

curl_close($ch);