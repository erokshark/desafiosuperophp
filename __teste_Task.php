<pre>

<? echo 'Yay'; ?>
<?php

include '_inc_config.php';

$p = new Task('', 'Task teste'.microtime(), '1');

print_r($p);
$p->save();
$p->save();

echo 'Depois <hr>';
print_r($p);

?>