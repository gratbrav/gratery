<?php

namespace gratery\Lottery;

require __DIR__ . '/vendor/autoload.php';

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
     * @var array
     */
    protected $numberList = [];

    /**
     * @var array
     */
    protected $superNumberList = [];

    /**
     * Lottery constructor.
     */
    function __construct()
    {
        $this->loadConfig();
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
                    if (!isset($this->numberList[$number])) {
                        $this->numberList[$number] = 0;
                    }
                    $this->numberList[$number]++;

                    $this->lotteryDraw[$lotteryTimestamp]['number'][] = $number;
                }

                $zuperZahl = $post->find('.zahlensuche_zz');
                $superNumber = trim($zuperZahl[0]->text());
                if ($superNumber != '') {
                    if (!isset($this->superNumberList[$superNumber])) {
                        $this->superNumberList[$superNumber] = 0;
                    }
                    $this->superNumberList[$superNumber]++;

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

        if (count($this->numberList) === 0) {
            $this->parseNumbers();
        }
        arsort($this->numberList);

        $numberList = $this->numberList;
        if (isset($config['limit']) && $config['limit'] != 0) {
            $numberList = array_slice($numberList, 0, $config['limit'], true);
        }

        return (array)$numberList;
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

        if (count($this->superNumberList) === 0) {
            $this->parseNumbers();
        }
        arsort($this->superNumberList);

        $superNumberList = $this->superNumberList;
        if (isset($config['limit']) && $config['limit'] != 0) {
            $superNumberList = array_slice($superNumberList, 0, $config['limit'], true);
        }

        return (array)$superNumberList;
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