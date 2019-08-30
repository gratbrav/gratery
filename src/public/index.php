<?php

require __DIR__ . '/Lottery.php';

echo time();

echo'<pre>';

$lottery = new \gratery\Lottery\Lottery();

echo "Number - Count <br>";

foreach ($lottery->getNumbers() as $index => $count) {
    echo "$index  - $count <br>";
}

echo '<br>';

echo "SuperNumber - Count <br>";
foreach ($lottery->getSuperNumbers() as $index => $count) {
    echo "$index  - $count <br>";
}

echo '</pre>';