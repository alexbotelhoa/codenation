<?php

$json_file = file_get_contents("https://api.codenation.dev/v1/challenge/dev-ps/generate-data?token=2c02760f25a76e9de8ca8f2451735afcd0e8ce32");

$fp = fopen("anwser.json", "w+");

$escreve = fwrite($fp, $json_file);

fclose($fp);