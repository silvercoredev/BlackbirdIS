<?php
    /*
     Copyright (c) 2012, Silvercore Dev. (www.silvercoredev.com)
     Todos os direitos reservados.
     Ver o arquivo licenca.txt na raiz do BlackbirdIS para mais detalhes.
     */
session_start();
if (!isset($_SESSION["bis"]) || $_SESSION["bis"] != 1) {
    header("Location: index.php");
    die();
}
?>