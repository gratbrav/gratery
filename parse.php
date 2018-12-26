<?php


require __DIR__ . '/vendor/autoload.php';

use DiDom\Document;

$startYear = 1955;
$currentYear = date('Y');

$numberList = $superNumberList = [];

echo time();

for (; $startYear <= $currentYear; $startYear++) {

    $url = 'https://www.lottozahlenonline.de/statistik/lotto-am-samstag/lottozahlen-archiv.php?j=' . $startYear;
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