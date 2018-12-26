<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

use DiDom\Document;

$numberList = $superNumberList = [];

echo time();

for ($year = $config['startYear']; $year <= $config['currentYear']; $year++) {

    $url = $config['url'] . $year;
    $document = new Document($url, true);

    $posts = $document->find('.zahlensuche_rahmen');

    foreach($posts as $post) {

        $lotteryDraw = $post->find('.zahlensuche_datum');
        // echo 'Import: ' . $lotteryDraw[0]->text() . '<br>';

        $lotteryNumbers = $post->find('.zahlensuche_zahl');
        foreach ($lotteryNumbers as $numberEntry) {
            $number = trim($numberEntry->text());
            if (!isset($numberList[$number])) {
                $numberList[$number] = 0;
            }
            $numberList[$number]++;
        }

        $zuperZahl = $post->find('.zahlensuche_zz');
        $superNumber = trim($zuperZahl[0]->text());
        if ($superNumber != '') {
            if (!isset($superNumberList[$superNumber])) {
                $superNumberList[$superNumber] = 0;
            }
            $superNumberList[$superNumber]++;
        }

    }

}

echo'<pre>';

echo 'Number<br>';
arsort($numberList);
print_r($numberList);

echo 'SuperNumber<br>';
arsort($superNumberList);
print_r($superNumberList);

echo '</pre>';