<?php
//A simple example, illustrating the use of Polar Encryption
//Troy Daniels
//21/06/2015

require 'PolarEncrypt.php';

function main()
{
    $polarEncrypt = new PolarEncrypt;

    $testString = "A";
    $time_init = $time_1 = $time_2 = $time_3;

    $encrypted_1 = $polarEncrypt->encrypt($testString);
    $encrypted_2 = $polarEncrypt->encrypt($testString);
    $encrypted_3 = $polarEncrypt->encrypt($testString);

    $time_init = microtime(true);
    echo " First encryption of '" . $testString . "' :  " . $encrypted_1;
    $time_1 = microtime(true);
    echo "Second encryption of '" . $testString . "':  " . $encrypted_2;
    $time_2 = microtime(true);
    echo "Third encryption of '" . $testString . "' :  " . $encrypted_3 . "\n";
    $time_3 = microtime(true);

    assert($encrypted_1 != $encrypted_2 && $encrypted_2 != $encrypted_3 && $encrypted_3 != $encrypted_1);
    echo "Passed: Encrypted values unique\n";

    assert(($time_init - $time_1) != ($time_1 - $time_2) && ($time_1 - $time_2) != ($time_2 - $time_3) && ($time_2 - $time_3) != ($time_init - $time_1));
    echo "Passed: Encryption times unique\n";

    //Reset internal counter ready for decryption
    $polarEncrypt->setMapCount(0);

    $decrypted_1 = $polarEncrypt->decrypt($encrypted_1);
    $decrypted_2 = $polarEncrypt->decrypt($encrypted_1);
    $decrypted_3 = $polarEncrypt->decrypt($encrypted_1);

    if(($decrypted_1 && $decrypted_2 && $decrypted_3) == $testString)
    {
        echo "Passed: Decryption successful!\n";
    }
}

main();
