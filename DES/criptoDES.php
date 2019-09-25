<?php
    
    /* A chave deve ser binária e aleatória, podendo usar a funçõesscrypt, bcrypt ou PBKDF2 para
    converter uma string em uma chave, sendo especificada usando hexadecimal*/ 
    $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
    
    /* O tamanho da chave chaves pode ser 16, 24 ou 32 bytes respectivamente*/
    $key_size =  strlen($key);
    echo "Key size: " . $key_size . "\n";
    
    $plaintext = "Essa é uma frase DES codificada.";

    /* Codificação utilizando a função mcrypt_get_iv_size */
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    
    /*  Cria um texto cifrado compatível com DES (tamanho do bloco Rijndael = 128) para manter  o texto confidencial adequado apenas para entrada codificada que nunca termina com o valor 00h
    (devido ao preenchimento zero padrão) */
    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);

    /* Precede o $iv para que ele esteja disponível para descriptografia */
    $ciphertext = $iv . $ciphertext;
    
    /* Codifica o texto cifrado resultante para que ele possa ser representado por uma sequência */
    $ciphertext_base64 = base64_encode($ciphertext);

    echo  $ciphertext_base64 . "\n";
    
    /* --- Decodificação --- */
    
    $ciphertext_dec = base64_decode($ciphertext_base64);
    
    /* Recupera o $iv, $iv_size deve ser criado usando mcrypt_get_iv_size () */
    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
    
    /* Recupera o texto cifrado (tudo, exceto o $iv_size na frente) */
    $ciphertext_dec = substr($ciphertext_dec, $iv_size);

    /* Remove caracteres com valor de 00h do final do texto sem formatação*/
    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
    
    echo  $plaintext_dec . "\n";
?>
