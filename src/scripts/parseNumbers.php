<?php

require '../vendor/autoload.php';
include '../config.php';

use DiDom\Document;

$year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);

$year = $year ?? (int)date('Y');

$url = $config['url'] . $year;
$document = new Document($url, true);

$posts = $document->find('.zahlensuche_rahmen');

$fp = fopen('../data/file' . $year . '.csv', 'w');

foreach($posts as $post) {
    $numberList = [];

    $lotteryDraw = $post->find('.zahlensuche_datum');
    echo 'Import: ' . $lotteryDraw[0]->text() . ': ';

    $lotteryNumbers = $post->find('.zahlensuche_zahl');
    foreach ($lotteryNumbers as $numberEntry) {
        $numberList[] = trim($numberEntry->text());
    }

    $zuperZahl = $post->find('.zahlensuche_zz');
    $superNumber = trim($zuperZahl[0]->text());

    // add date
    array_unshift($numberList, $lotteryDraw[0]->text());

    // add super number
    if ($superNumber != '') {
        array_push($numberList, $superNumber);
    }

    echo print_r($numberList, true) . "<br>";
    fputcsv($fp, $numberList);
}

fclose($fp);
