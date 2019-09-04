<?php
/**Trabalho de Segurança em informação: Criptografia e descriptografia com base na Cifra de César
Disciplina lecionada pelo Professor Doutor Fabiano Cavalcanti
Aluna e autora do código: Lauany Reis da Silva - 151057600071**/
/*Definindo o fator de deslocamento para criptografia*/
$n_deslocamento = 5; 
/*Frase de teste*/
$frase_criptografar = "The quick brown fox jumps over the lazy dog"; 
/*Variáveis*/
$frase_criptografada = ''; 
$frase_descriptografada ='';
function Cripto_this($frase_criptografar,$n_deslocamento)
{
    /*Definindo o tamanho do alfabeto ultilizado*/
    $tam_alfabeto = 256; 
    /*Definindo o carctere limite para exclusão na análise*/
    $excluso = 32;
    $frase_criptografada = ''; 
    
    for ($i = 0; $i < strlen($frase_criptografar); $i++)
    {
        /*Obtém o código correspondente do caractere atual*/
        $chave = ord($frase_criptografar[$i]);
        /*Incrementa o código obtido com base no fator de deslocamento*/
        $novo_caractere = $chave + $n_deslocamento;
        /*Ajusta o código ao tamanho do alfabeto*/
        $novo_caractere = $novo_caractere % $tam_alfabeto;
        /*Se o novo caractere estiver fora do alfabeto de letras...*/
        if($novo_caractere >=0 && $novo_caractere < $excluso) 
        {
            /*... ele será deslocado para fora do tamanho do alfabeto*/
            $novo_caractere += $excluso;
        }
        /*Concatena a frase criptografada*/
        $frase_criptografada .= chr($novo_caractere);
    }
    return $frase_criptografada;
}
function Descripto_this($frase_criptografada,$n_deslocamento)
{
     /*Definindo o tamanho do alfabeto ultilizado*/
    $tam_alfabeto = 256; 
    /*Definindo o carctere limite para exclusão na análise*/
    $excluso = 32;
    $frase_descriptografada ='';
    
    for ($i = 0; $i < strlen($frase_criptografada); $i++)
    {
        /*Obtém o código correspondente do caractere atual*/
         $chave = ord($frase_criptografada[$i]);
        /*Decrementa o código obtido com base no fator de deslocamento*/
         $novo_caractere = $chave - $n_deslocamento;
          /*Se o novo caractere estiver fora do alfabeto de letras...*/
         if($novo_caractere >= 0 && $novo_caractere < $excluso) 
        {
            /*... ele será deslocado para dentro do tamanho do alfabeto novamente*/
            $novo_caractere -= $excluso;
        }
        /*Se o caractere for negativo...*/
        if($novo_caractere < 0) 
        { 
            /*... ele será reintegrado ao alfabeto original*/
            $novo_caractere = $tam_alfabeto +  $novo_caractere; 
        }
         /*Concatena a frase criptografada*/
        $frase_descriptografada .= chr($novo_caractere); 
    }
    return $frase_descriptografada;
}
function countOcur($string, $stringCheck)
{
   $count = 0;
   /*Separa as palavras*/
   $words = explode(" ", $stringCheck );
   $x = 0;
   
    foreach ($words as $word)
    {
        /*Converte a string analisada em array*/
        $a[$x]= str_split($word, strlen($string));
        /*Incrementa o índice do vetor de contadores*/
        $x++;
    }
    /*Percorre o array da string (palavras)*/
    foreach ($a as $key => $array)
    {
        /*Percorre o array da string (letras)*/
        for($i=0; $i<sizeof($array);$i++)
        {
            /*Se o caractere analisado for igual ao do alfabeto...*/
            if($array[$i] == $string)
            {
                /*... incrementa o contador*/
                $count++;
            }
        }
    }
    return $count;
}
function Descripto_this_helper($frase_criptografada)
{
    /*Descapitaliza o texto para padronizar*/
    $text=strtolower($frase_criptografada);
    /*Define o alfabeto para analize*/
    $alfabeto = range('a','z'); 
    /*Cria vetor e contador*/
    $occur = array();
    foreach ($alfabeto as $caracter)
     {
         /*Realiza a contagem do caracter com a função auxiliar de contagem*/
         array_push ($occur, (int)countOcur(strtolower($caracter), $text));
     }
     /*combina o alfabeto analisado com a contagem dos caracteres*/
     $result = array_combine ($alfabeto, $occur);
     /*Busca o caractere mais frequente na frase*/
     $max = array_search(max($result) , $result);
     /*Lista dos caracteresmais frequentes na lingua inglesa*/
     $more_frequently = array('e','t','a','o','i','n','s','h','r','d','l','c','u','m','w','f','g','y','p','b','v','k','j','x','q','z');
     foreach ($more_frequently as $test)
     {
         /*Testa o deslocamento relativo com base no caractere mais frequente da lista dos mais frequentes*/
         $desloc = abs(ord($max) - ord($test));
         /*Tenta descriptografar com o deslocamento obtido*/
         $frase_descriptografada = Descripto_this($frase_criptografada, $desloc);
         /*Imprime a tentativa*/
         echo '<br/> Tentativa de descriptografia com deslocamento '.$desloc.': ' .$frase_descriptografada.'<br/>';
     }
}
$frase_criptografada = Cripto_this($frase_criptografar,$n_deslocamento);
echo 'Frase original: ' .$frase_criptografar.'<br/>';
echo '<br/> Frase criptografada: ' .$frase_criptografada.'<br/>';
Descripto_this_helper($frase_criptografada); 
?>
