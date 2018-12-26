<?php

require __DIR__ . '/Lottery.php';

echo time();

echo'<pre>';

echo 'Number<br>';
$lottery = new \gratery\Lottery\Lottery();
print_r($lottery->getNumbers());

echo 'SuperNumber<br>';
print_r($lottery->getSuperNumbers());

echo '</pre>';