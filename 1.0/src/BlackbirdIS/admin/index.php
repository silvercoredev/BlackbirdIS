<?php
    /*
     Copyright (c) 2012, Silvercore Dev. (www.silvercoredev.com)
     Todos os direitos reservados.
     Ver o arquivo licenca.txt na raiz do BlackbirdIS para mais detalhes.
     */

    // Carrega as configurações
    include("settings.php");
    
    // Se não existir usuário e senha no arquivo settings.php, redirecionar para install.php
    if (!isset($user) || !isset($password)) {
        header("Location: install.php");
        die();
    }

    // Impede o acesso caso o arquivo install.php exista
    if (file_exists("install.php")) {
        die("<!DOCTYPE html><html><head><title>BlackbirdIS</title><meta charset=\"utf-8\" /></head><body>É necessário deletar o arquivo install.php antes de continuar.</body></html>");
    }
    
    // Se o usuário já estiver logado, redirecionar para a página de administração
    session_start();
    if (isset($_SESSION["bis"])) {
        if ($_SESSION["bis"] == 1) {
            header("Location: admin.php");
            die();
        }
    }
    
    // Impede o acesso caso a opção "Desativar painel de administração após três tentativas de login consecutivas" esteja ativada
    // e o número máximo de tentativas de login excedido.
    if ($dof == "on" && $lcounter == 3) {
        die("<!DOCTYPE html><html><head><title>BlackbirdIS</title><meta charset=\"utf-8\" /></head><body>Número máximo de tentativas de login excedido. O painel de administração foi desativado. Para reativar, altere o valor da variável \$lcounter no arquivo settings.php para 0. Em caso de dúvidas, consulte a <a href='http://www.silvercoredev.com/blackbird/documentacao/'>documentação</a>.</body></html>");
    }
    
    // Se o usuário e senha estiverem corretos, reinicia o contador de tentativas de login e continua para admin.php
    // Caso contrário, aumenta o contador de tentativas de login e coloca mensagem de erro na variável $errormsg
    if (isset($_POST['tuser']) && isset($_POST['tpassword'])) {
    $tuser = $_POST['tuser'];
    $tpassword = $_POST['tpassword'];
        if (sha1($tuser) == $user && sha1($tpassword) == $password) {
            session_regenerate_id(TRUE);
            $_SESSION["bis"] = 1;
            $new_lcounter = 0;
            $settings = file_get_contents("settings.php");
            $settings = str_replace("\$lcounter = " . $lcounter, "\$lcounter = " . $new_lcounter, $settings);
            file_put_contents("settings.php", $settings);
            header("Location: admin.php");
        }
        else {
            $errormsg = "Erro: usuário ou senha incorretos.";
            $new_lcounter = $lcounter + 1;
            $settings = file_get_contents("settings.php");
            $settings = str_replace("\$lcounter = " . $lcounter, "\$lcounter = " . $new_lcounter, $settings);
            file_put_contents("settings.php", $settings);
            if ($new_lcounter == 3) {
                header("Location: index.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>BlackbirdIS</title>
<meta charset="utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="bar">
Administração
</div>
<div id="main" style="text-align:center">
<?php
    // Se a variável $errormsg existir, mostra a mensagem de erro
    if (isset($errormsg)) {
        echo($errormsg);
    }
?>
<form action="index.php" method="post">
Login<br />
<input type="text" name="tuser" class="seinput" /><br /><br />
Senha<br />
<input type="password" name="tpassword" class="seinput" /><br /><br />
<input type="submit" value="Continuar" class="b1" />
</form>
</div>
</body>
</html>
