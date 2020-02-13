<?php

// BUSCA JSON COM AS INFORMAÇÕES
$json_file = file_get_contents("https://api.codenation.dev/v1/challenge/dev-ps/generate-data?token=2c02760f25a76e9de8ca8f2451735afcd0e8ce32");


// CRIA O ARQUIVO E GRAVA AS INFORMAÇÕES NO ARQUIVO
$fp = fopen("anwser.json", "w+");
fwrite($fp, $json_file);
fclose($fp);

// FAZ A LEITURA DO ARQUIVO JSON LOCAL
$file = file_get_contents("anwser.json");
$json = json_decode($file, true);

// PREPARA AS VARIÁVEIS PARA ALTERAÇÕES
$cifrado = $json['cifrado'];
$decifrado = "";


for ($c = 0; $c < strlen($cifrado); $c++) {

    // MINÚSCULAS -> [97...122]
    if (123 > ord($cifrado[$c]) && ord($cifrado[$c]) > 96) {

        // FAZ A SUBSTITUIÇÃO
        if ((ord($cifrado[$c]) - $json['numero_casas']) < 96) {
            $decifrado .= chr(ord($cifrado[$c]) - $json['numero_casas'] + 26);
        } else {
            $decifrado .= chr(ord($cifrado[$c]) - $json['numero_casas']);
        }

    } else {

        // MAIÚSCULAS -> [65...90]
        if (91 > ord($cifrado[$c]) && ord($cifrado[$c]) > 64) {

            // FAZ A SUBSTITUIÇÃO
            if ((ord($cifrado[$c]) - $json['numero_casas']) < 64) {
                $decifrado .= chr(ord($cifrado[$c]) - $json['numero_casas'] + 26);
            } else {
                $decifrado .= chr(ord($cifrado[$c]) - $json['numero_casas']);
            }
        } else {

            // CASO NÃO SEJA LETRA PASSA NORMAL
            $decifrado .= $cifrado[$c];
        }

    }

}

// JOGA O RESULTADO NO CAMPO DECIFRADO
$json['decifrado'] = $decifrado;
$json['resumo_criptografico'] = sha1($decifrado);

// CONVERTE EM JSON
$json_decifrado = json_encode($json);

// ATUALIZA O ARQUIVO DE JSON LOCAL
$fp = fopen("anwser.json", "w+");
fwrite($fp, $json_decifrado);
fclose($fp);