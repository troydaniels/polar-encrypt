<?php
//A simple example, illustrating the use of Polar Encryption
//Troy Daniels
//21/06/2015

require 'PolarEncrypt.php';

function main()
{
    $polarEncrypt = new PolarEncrypt;

    $testString = "A quick brown fox jumped over the lazy dog";

    $polarEncrypt->setBase(10);
    $testMapping = array(1,3,5,7,11,13,17,19,23,27);
    $polarEncrypt->setMapping($testMapping);
    $testDisplacement = array(1,3,5,7,11,13,17,19,23,27,29,31,37,41);
    $polarEncrypt->setDisplacement($testDisplacement);

    $encrypted = $polarEncrypt->encrypt($testString);

    //Reset internal counter ready for decryption
    $polarEncrypt->setMapCount(0);

    if(($decrypted=$polarEncrypt->decrypt($encrypted)) == $testString)
    {
        echo "Decryption successful!\n";
    }
}

main();
