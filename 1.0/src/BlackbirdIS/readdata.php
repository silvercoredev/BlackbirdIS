<?php
    /*
     Copyright (c) 2012, Silvercore Dev. (www.silvercoredev.com)
     Todos os direitos reservados.
     Ver o arquivo licenca.txt na raiz do BlackbirdIS para mais detalhes.
     */
    
    // Lê os dados de um arquivo no formato Blackbird Data File 1.0
    $file = file_get_contents($path_to_datafile);
    if ($file) {
        // Coloca o nome da estação e mensagem nas variáveis $station_name e $message
        preg_match("/BLACKBIRD DATA FILE 1.0\nstation_name {\n\x02(.*)\x02\n}\nmessage {\n\x02(.*)\x02\n}/s", $file, $data);
        $station_name = $data[1];
        $message = $data[2];
        unset($data);
    }
?>