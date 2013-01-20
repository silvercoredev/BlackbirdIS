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
    
    // Lê o arquivo data.bdf
    $path_to_datafile = "../data.bdf";
    include("../readdata.php");
    unset($path_to_datafile);
    
    // Se a página a exibir não estiver definida,
    // define a página principal.
    if (!isset($_GET['pag'])) {
        $_GET['pag'] = "principal";
    }
    
    // Logout
    if ($_GET['pag'] == "logout") {
        session_destroy();
        header("Location: index.php");
    }
    ?>
<!DOCTYPE html>
<html>
<head>
<title>BlackbirdIS</title>
<meta charset="utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
#main {
    padding:5px;
    width:900px;
}
#menu {
    float:left;
    width:125px;
    height:200px;
}

#menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
}
#menu li {
    font-size:16px;
    padding:5px 15px;
    background-color:#242424;
    border-radius:5px;
    border-style:solid;
    border-width:1px;
    border-color:#B5B5B5;
    margin-bottom:10px;
    width:90px;
    text-align:center;
}
#menu a {
    text-decoration:none;
    color:white;
}
#menu li:hover {
    background-color:#3D3D3D;
}
.cont {
    background-color:#454545;
    padding:15px;
    border-radius:5px;
    border-style:solid;
    border-width:1px;
    border-color:#4e4e4e;
    width:730px;
    float:right;
    margin-bottom:10px;
}
</style>
</head>
<body>
<div id="bar">
<?php
    if ($_GET['pag'] == "principal") {
        echo('Principal');
    }
    elseif ($_GET['pag'] == "seguranca") {
        echo('Segurança');
    }
    elseif ($_GET['pag'] == "sobre") {
        echo('Sobre');
    }
?>
</div>
<div id="main">
<div id="menu">
<ul>
    <a href="?pag=principal"><li>Principal</li></a>
    <a href="?pag=seguranca"><li>Segurança</li></a>
    <a href="?pag=sobre"><li>Sobre</li></a>
    <a href="?pag=logout"><li>Sair</li></a>
</ul>
</div>
<?php
    if (isset($_GET['s'])) {
        // Mensagens do painel de administração
        if ($_GET['s'] == 1) {
            echo('<div class="cont">');
            echo('As novas configurações foram salvas com sucesso.');
            echo('</div>');
        }
        elseif ($_GET['s'] == 2) {
            echo('<div class="cont">');
            echo('Erro: senha incorreta. As novas configurações não foram salvas.');
            echo('</div>');
        }
    }
    // Páginas
    if ($_GET['pag'] == "principal") {
        echo('<form method="post" action="save.php?p=principal">');
        echo('<div class="cont">');
        echo('Nome da estação Blackbird<br>');
        echo('<input name="station_name" type="text" class="seinput" value="' . htmlentities($station_name, ENT_QUOTES, 'UTF-8') . '" />');
        echo('</div>');
        
        echo('<div class="cont">');
        echo('<h1>Mensagem</h1>');
        echo('Mensagem a ser exibida pela estação Blackbird (aceita HTML).<br />');
        echo('<textarea name="message" class="seinput" style="width:540px; height:100px; max-width:700px;">' . htmlentities($message, ENT_QUOTES, 'UTF-8') . '</textarea>');
        echo('</div>');
        echo('<div class="cont">');
        echo('É necessário digitar a senha atual para salvar as alterações.<br />');
        echo('<input name="password" type="password" class="seinput"/>');
        echo('</div>');
        echo('<div style="margin-left:136px;"><input type="submit" value="Salvar" class="b1" style=""/></div>');
        echo('</form>');
    }
        
    elseif ($_GET['pag'] == "seguranca") {
        echo('<form method="post" action="save.php?p=seguranca">');
        echo('<div class="cont">');
        echo('<h1>Alteração de senha</h1>');
        echo('Nova senha<br />');
        echo('<input name="password_new" type="password" class="seinput"/><br />');
        echo('</div>');
        echo('<div class="cont">');
        echo('<input name="dof" type="checkbox" ');
        if ($dof == "on") {
            echo('checked');
        }
        echo('/> Desativar painel de administração após três tentativas de login consecutivas.<br />');
        echo('</div>');
        echo('<div class="cont">');
        echo('É necessário digitar a senha atual para salvar as alterações.<br />');
        echo('<input name="password" type="password" class="seinput" />');
        echo('</div>');
        echo('<div style="margin-left:136px;"><input type="submit" value="Salvar" class="b1" style=""/></div>');
        echo('</form>');
    }
    
    elseif ($_GET['pag'] == "sobre") {
        echo('<div class="cont">');
        echo('BlackbirdIS 1.0.<br /><a href="http://www.silvercoredev.com/blackbird/update/?v=1-0">Verificar atualizações</a><br /><a href="http://www.silvercoredev.com/documentacao/blackbird/">Documentação</a><br /><a href="http://www.silvercoredev.com/documentacao/blackbird/licenca/">Licença</a>');
        echo('</div>');
    }
    ?>
</div>
</body>
</html>