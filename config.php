<?php

$config = [
    'startYear' => 1955,
    'currentYear' => date('Y'),
    'url' => 'https://www.lottozahlenonline.de/statistik/lotto-am-samstag/lottozahlen-archiv.php?j=',
];

if (file_exists('config.local.php')) {
    include_once 'config.local.php';
}
