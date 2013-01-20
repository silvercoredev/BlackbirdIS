<?php
    /*
     Copyright (c) 2012, Silvercore Dev. (www.silvercoredev.com)
     Todos os direitos reservados.
     Ver o arquivo licenca.txt na raiz do BlackbirdIS para mais detalhes.
     */
?>
<!DOCTYPE html>
<html>
<head>
<title>BlackbirdIS - Setup</title>
<meta charset="utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="bar">
<?php
if (isset($_GET['step'])) {
    $step = $_GET['step'];
    if ($step == 1) {
        echo("Bem-vindo");
    }
    if ($step == 2) {
        echo("Permissões");
    }
    if ($step == 3) {
        echo("Configuração");
    }
    if ($step == 4) {
        if (!$_POST['station_name'] || !$_POST['user'] || !$_POST['password']) {
            echo("Erro");
        }
        else {
            $station_name = $_POST['station_name'];
            $user = $_POST['user'];
            $password = $_POST['password'];
            echo("Concluído");
        }
    }
}
else {
    echo("Bem-vindo");
}
?>
</div>
<div id="main" style="width:900px">
<?php
if (!isset($step) || $step == 1) {
    echo("<div style=\"text-align:center;\">");
    echo("Este assistente irá lhe ajudar a configurar o BlackbirdIS 1.0.<br />");
    echo("A licença do BlackbirdIS pode ser encontrada no arquivo \"licenca.txt\", localizado no diretório raiz do sistema, ou na página <a href=\"http://www.silvercoredev.com/documentacao/blackbird/licenca/\">http://www.silvercoredev.com/documentacao/blackbird/licenca/</a>.<br />");
    echo("Para prosseguir, clique em continuar.<br /><br />");
    echo("<a href=\"?step=2\" class=\"b1\">Continuar</a></div>");
}
elseif ($step == 2) {
    echo("<div style=\"text-align:center;\">");
    echo("Para funcionar corretamente, o BlackbirdIS precisa das permissões para os arquivos abaixo. <br /><br />");
    echo("<table class=\"permissions\">");
    echo("<tr><td><b>Arquivo</b></td><td><b>Leitura</b></td><td><b>Escrita</b></td></tr>");

    echo("<tr>");
    echo("<td>update.txt</td>");
    if (is_readable("../update.txt")) {
        echo("<td>OK</td>");
    }
    else {
        echo("<td>Erro</td>");
        $error = 1;
    }
    if (is_writeable("../update.txt")) {
        echo("<td>OK</td>");
    }
    else {
        echo("<td>Erro</td>");
        $error = 1;
    }
    echo("</tr>");
    
    echo("<tr>");
    echo("<td>data.bdf</td>");
    if (is_readable("../data.bdf")) {
        echo("<td>OK</td>");
    }
    else {
        echo("<td>Erro</td>");
        $error = 1;
    }
    if (is_writeable("../data.bdf")) {
        echo("<td>OK</td>");
    }
    else {
        echo("<td>Erro</td>");
        $error = 1;
    }
    echo("</tr>");
    
    echo("<tr>");
    echo("<td>admin/settings.php</td>");
    if (is_readable("settings.php")) {
        echo("<td>OK</td>");
    }
    else {
        echo("<td>Erro</td>");
        $error = 1;
    }
    if (is_writeable("settings.php")) {
        echo("<td>OK</td>");
    }
    else {
        echo("<td>Erro</td>");
        $error = 1;
    }
    echo("</tr>");
    
    
    echo("</table><br />");
    
    
    if (!isset($error)) {
        echo("<br />Verificação concluída.<br /><br />");
        echo("<a href=\"?step=3\" class=\"b1\">Continuar</a></div>");
    }
    else {
        echo("<br />Erro: verifique as permissões dos arquivos para continuar.<br /><br />");
        echo("<a href=\"?step=2\" class=\"b1\">Tentar novamente</a></div>");
    }
    
    echo("</div>");
}

elseif ($step == 3) {
    echo("<div style=\"text-align:center;\">");
    echo("O login e senha serão usados para realizar alterações através do painel de administração do sistema.<br />Todos os dados podem ser alterados mais tarde.<br /><br />");
    echo("<form method=\"post\" action=\"?step=4\">");
    echo("Nome da Estação BlackbirdIS<br /><input type=\"text\" class=\"seinput\" name=\"station_name\" /><br /><br />");
    echo("Login<br /><input type=\"text\" class=\"seinput\" name=\"user\" /><br /><br />");
    echo("Senha<br /><input type=\"password\" class=\"seinput\" name=\"password\" /><br /><br />");
    echo("<input type=\"submit\" value=\"Continuar\" class=\"b1\" /></form></div>");
}

elseif ($step == 4) {
    if (!$station_name || !$user || !$password) {
        echo("<div style=\"text-align:center;\">");
        echo("Erro: é obrigatório preencher os campos.<br /><br />");
        echo("<a href=\"?step=3\" class=\"b1\">Voltar</a></div>");
    }
    else {
        $user = sha1($user);
        $password = sha1($password);
        file_put_contents("../data.bdf", "BLACKBIRD DATA FILE 1.0\nstation_name {\n\x02" . $station_name . "\x02\n}\nmessage {\n\x02O BlackbirdIS 1.0 foi instalado corretamente.<br /><a href=\"admin\">Ir para o painel de administração.</a>\x02\n}");
        file_put_contents("settings.php", "<?php\n\$user = \"" . $user . "\";\n\$password = \"" . $password . "\";\n\$dof = \"on\";\n\$lcounter = 0;\n?>");
        echo("<div style=\"text-align:center;\">");
        echo("O BlackbirdIS 1.0 foi instalado corretamente.<br />AVISO: DELETE O ARQUIVO INSTALL.PHP ANTES DE CONTINUAR.<br /><br /><br />");
        echo("<a href=\"index.php\" class=\"b1\">Ir para o painel de administração.</a></div>");
    }
}

?>
</div>
</body>
</html>
