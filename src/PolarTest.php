<?php
//A simple example, illustrating the use of Polar Encryption
//Troy Daniels
//21/06/2015

require 'PolarEncrypt.php';

function main()
{
    $polarEncrypt = new PolarEncrypt;

    $testString = "A";

    $encrypted_1 = $polarEncrypt->encrypt($testString);
    $encrypted_2 = $polarEncrypt->encrypt($testString);
    $encrypted_3 = $polarEncrypt->encrypt($testString);

    echo "First encryption of " . $testString . ":  " . $encrypted_1 . "\n";
    echo "Second encryption of " . $testString . ": " . $encrypted_2 . "\n";
    echo "Third encryption of " . $testString . ":  " . $encrypted_3 . "\n";

    //Reset internal counter ready for decryption
    $polarEncrypt->setMapCount(0);

    $decrypted_1 = $polarEncrypt->decrypt($encrypted_1);
    $decrypted_2 = $polarEncrypt->decrypt($encrypted_1);
    $decrypted_3 = $polarEncrypt->decrypt($encrypted_1);

    if(($decrypted_1 && $decrypted_2 && $decrypted_3) == $testString)
    {
        echo "Decryption successful!\n";
    }
}

main();
