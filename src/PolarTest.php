<?php
//A simple example, illustrating the use of Polar Encryption
//Troy Daniels
//21/06/2015

require 'PolarEncrypt.php'; 

function main()
{
    $filename = 'WikipediaPageEncrypted.txt';
    $polarEncrypt = new PolarEncrypt;

    $polarEncrypt->setBase(10);
    $testMapping = array(1,3,5,7,11,13,17,19,23,27);
    $polarEncrypt->setMapping($testMapping);

    $unencrypted = file_get_contents('https://en.wikipedia.org/wiki/Encryption');
    $encrypted = $polarEncrypt->encrypt($unencrypted);

    file_put_contents($filename, $encrypted);

    //Reset internal counter ready for decryption
    $polarEncrypt->setMapCount(0);

    if($polarEncrypt->decrypt($encrypted) == $unencrypted)
    {
        echo "Decryption successful!\n";
    }
}

main();
