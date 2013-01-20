<?php
    /*
     Copyright (c) 2012, Silvercore Dev. (www.silvercoredev.com)
     Todos os direitos reservados.
     Ver o arquivo licenca.txt na raiz do BlackbirdIS para mais detalhes.
     */
    
    // Leitura do arquivo data.bdf
    $path_to_datafile = "data.bdf";
    include("readdata.php");
    unset($path_to_datafile);
    if (!isset($station_name) || !isset($message)) {
        header("Location: admin");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo($station_name); ?></title>
        <meta charset="utf-8" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="viewport" content="width=320, initial-scale=1, user-scalable=yes" />
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="bar">
            <?php echo($station_name); ?>
        </div>
        <div id="main">
            <noscript>
                <div class="cont">
                    Este sistema utiliza JavaScript.<br>
                    É recomendável que você ative o JavaScript nas preferências do seu navegador. Caso contrário, a mensagem abaixo não será atualizada automaticamente.
                </div>
            </noscript>
            <?php echo($message); ?>
            <div id="sta"></div>
            <div id="stb"></div>
        </div>
        <script type="text/javascript">

            // Adiciona "0" aos números menores que 10
            function addZero(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }

            var sta = document.getElementById("sta");
            var stb = document.getElementById("stb");

            var months = [
                "Janeiro",
                "Fevereiro",
                "Março",
                "Abril",
                "Maio",
                "Junho",
                "Julho",
                "Agosto",
                "Setembro",
                "Outubro",
                "Novembro",
                "Dezembro"
            ];

            // Obtém e exibe data e hora do carregamento da página
            var d = new Date();
            var day = d.getDate();
            var month_n = d.getMonth();
            var year = d.getFullYear();
            var hours = d.getHours();
            var minutes = d.getMinutes();
            var seconds = d.getSeconds();

            day = addZero(day);
            hours = addZero(hours);
            minutes = addZero(minutes);
            seconds = addZero(seconds);
            month = months[month_n];

            sta.innerHTML = "Última atualização recebida em " + day + " de " + month + " de " + year + " às " + hours + ":" + minutes + ":" + seconds;

            // Verifica se o arquivo update.txt foi alterado a cada 5 segundos
            // Se sim, atualiza a página
            var xmlhttp = new XMLHttpRequest();
            var counter = 0;
            var original = 0;
            var delay = 5000;
            stb.innerHTML = "Aguardando...";
            check();

            function check() {
                xmlhttp.open("GET","update.txt?r=" + Math.random());
                xmlhttp.send();
            }

            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4) {
                    if (xmlhttp.status == 200) {
                        if (counter == 1) {
                            response = xmlhttp.responseText;
                            if (response != original) {
                                window.location.reload();
                            }
                        }
                        else {
                            counter = 1;
                            original = xmlhttp.responseText;
                        }
                        var tmp_date = new Date();
                        stb.innerHTML = "Última busca por atualização realizada às " + addZero(tmp_date.getHours()) + ":" + addZero(tmp_date.getMinutes()) + ":" + addZero(tmp_date.getSeconds());
                        setTimeout(check, delay);
                    }
                    else {
                        sta.innerHTML += "<br />Não foi possível buscar novas atualizações.";
                        stb.innerHTML = "Ocorreu um erro. A mensagem acima não será atualizada automaticamente.<br />Isto pode ter sido provocado por um problema com o servidor ou com sua conexão. Você pode tentar atualizar a página.";
                    }
                }
            };
        </script>
    </body>
</html>
