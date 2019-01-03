<?php

namespace gratery\Lottery;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/NumberCount.php';

use DiDom\Document;

class Lottery
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $lotteryDraw = [];

    /**
     * Lottery constructor.
     */
    function __construct()
    {
        $this->loadConfig();
        $this->parseNumbers();
    }

    /**
     * Load lottery numbers from url
     *
     * @return Lottery
     */
    protected function parseNumbers()
    {
        for ($year = $this->config['startYear']; $year <= $this->config['currentYear']; $year++) {

            $url = $this->config['url'] . $year;
            $document = new Document($url, true);

            $posts = $document->find('.zahlensuche_rahmen');

            foreach($posts as $post) {

                $lotteryDraw = $post->find('.zahlensuche_datum');
                // echo 'Import: ' . $lotteryDraw[0]->text() . '<br>';

                $lotteryTimestamp = strtotime($lotteryDraw[0]->text());
                $this->lotteryDraw[$lotteryTimestamp]['date'] = date('d.m.Y', strtotime($lotteryDraw[0]->text()));

                $lotteryNumbers = $post->find('.zahlensuche_zahl');
                foreach ($lotteryNumbers as $numberEntry) {
                    $number = trim($numberEntry->text());
                    $this->lotteryDraw[$lotteryTimestamp]['number'][] = $number;
                }

                $zuperZahl = $post->find('.zahlensuche_zz');
                $superNumber = trim($zuperZahl[0]->text());
                if ($superNumber != '') {
                    $this->lotteryDraw[$lotteryTimestamp]['superNumber'] = $superNumber;
                }

            }

        }
        return $this;
    }

    /**
     * get all numbers from lottery
     *
     * Configuration params:
     * - int limit  number of values to return
     *
     * @param array  $config  configuration params
     * @return array
     */
    public function getNumbers($config = [])
    {
        $config = array_merge($this->config['numbers'], $config);

        $numberCount = new NumberCount($this->lotteryDraw);

        $numberList = $numberCount->getNumbers($config);

        if (isset($config['limit']) && $config['limit'] != 0) {
            $numberList = array_slice($numberList, 0, $config['limit'], true);
        }

        return $numberList;
    }

    /**
     * get all super numbers from lottery
     *
     * Configuration params:
     * - int limit  number of values to return
     *
     * @param array  $config  configuration params
     * @return array
     */
    public function getSuperNumbers($config = [])
    {
        $config = array_merge($this->config['superNumbers'], $config);

        $numberCount = new NumberCount($this->lotteryDraw);

        $superNumberList = $numberCount->getSuperNumbers($config);
        if (isset($config['limit']) && $config['limit'] != 0) {
            $superNumberList = array_slice($superNumberList, 0, $config['limit'], true);
        }
        return $superNumberList;
    }

    /**
     * load config from local file
     *
     * @return Lottery
     */
    protected function loadConfig()
    {
        $config = [];
        include './config.php';
        $this->config = $config;
        return $this;
    }

}