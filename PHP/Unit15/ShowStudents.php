<?php

    require './server/InitializeDatabase.php';

    global $file;
    global $db;

    $a = explode(',', $db->GetStudentsRegistered());


    echo "<!DOCTYPE html>
<html lang=\"pt\">
<head>
    <meta charset=\"UTF-8\">
    <title>Estudantes Cadastrados - Unicamp</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"register-stylesheet.css\">
</head>
<body>

<div>
    <table>
        <caption>Estudantes Cadastrados</caption>";

    $i = 0;
    foreach ($a as $item){
        if($i != count($a)-1) {
            if (($i == 0) || (($i % 7) == 0)) {
                echo "          <tr>";
            }
            $aux = "";
            switch ($i%7){
                case 0: $aux = 'name-cell';
                    break;
                case 1: $aux = 'ra-cell';
                    break;
                case 2: $aux = 'sex-cell';
                    break;
                case 3: $aux = 'age-cell';
                    break;
                case 4: $aux = 'address-cell';
                    break;
                case 5: $aux = 'phone-cell';
                    break;
                case 6: $aux = 'email-cell';
                    break;
            }

            echo "              <td class='${aux}'> ${a[$i++]} <td/>";
            if ($i / 7 == 1) {
                echo "          <tr/>";
            }
        }
    }

    echo "    </table>
</div>

</body>
</html>";