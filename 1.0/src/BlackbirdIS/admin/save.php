<?php
    /*
     Copyright (c) 2012, Silvercore Dev. (www.silvercoredev.com)
     Todos os direitos reservados.
     Ver o arquivo licenca.txt na raiz do BlackbirdIS para mais detalhes.
     */
    
    // Verifica se o usuário está logado
    include("vsession.php");
    
    // Carrega as configurações
    include("settings.php");
    
    // Verifica se a senha está correta
    $post_password = sha1($_POST['password']);
    if ($post_password != $password) {
        header("Location: admin.php?pag=" .$_GET['p'] . "&s=2");
        die();
    }
    
    // Salva os dados da página "Principal" no arquivo data.bdf e altera o update.txt
    if ($_GET['p'] == "principal") {
        $station_name = htmlentities($_POST['station_name']);
        $message = $_POST['message'];
        file_put_contents("../data.bdf", "BLACKBIRD DATA FILE 1.0\nstation_name {\n\x02" . $station_name . "\x02\n}\nmessage {\n\x02" . $message . "\x02\n}");
        $update = file_get_contents("../update.txt");
        if ($update == "1") {
            file_put_contents("../update.txt", "0");
        }
        else {
            file_put_contents("../update.txt", "1");
        }
    }
    
    // Salva os dados da página "Segurança" no arquivo settings.php
    if ($_GET['p'] == "seguranca") {
        $password_new = $_POST['password_new'];
        $dof_new = $_POST['dof'];
        if (!$dof_new && $dof != "off") {
            $settings = file_get_contents("settings.php");
            $settings = str_replace("\$dof = \"on\"", "\$dof = \"off\"", $settings);
            file_put_contents("settings.php", $settings);
        }
        if ($dof_new == "on" && $dof != "on") {
            $settings = file_get_contents("settings.php");
            $settings = str_replace("\$dof = \"off\"", "\$dof = \"on\"", $settings);
            file_put_contents("settings.php", $settings);
        }
        if ($password_new) {
            $settings = file_get_contents("settings.php");
            $settings = str_replace("\$password = \"" . $password . "\"", "\$password = \"" . sha1($password_new) . "\"", $settings);
            file_put_contents("settings.php", $settings);
        }
    }
    
    header("Location: admin.php?pag=" . $_GET['p'] . "&s=1");
?>