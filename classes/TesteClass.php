<pre>TesteClass.php
<?php

include '../_inc_config.php';


$p = new Task();
echo '<br>1<hr>';
//$->pdo.. ??; //protected

$lista = $p->get_list();
foreach ($lista as $row) {
    echo '<br>Linha  ';
    print_r($row);
}

echo '<br>2<hr>';
$lista = $p->get_list(array(),array(),array(" nomtask LIKE '%1' ") );
foreach ($lista as $row) {
    echo '<br>Linha  ';
    print_r($row);
}


echo '<br>3<hr>';
print_r($p->get(2));


echo '* Fim ';

