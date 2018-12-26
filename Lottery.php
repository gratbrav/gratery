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
    protected $numberList = [];

    /**
     * @var array
     */
    protected $superNumberList = [];


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

                $lotteryNumbers = $post->find('.zahlensuche_zahl');
                foreach ($lotteryNumbers as $numberEntry) {
                    $number = trim($numberEntry->text());
                    if (!isset($this->numberList[$number])) {
                        $this->numberList[$number] = 0;
                    }
                    $this->numberList[$number]++;
                }

                $zuperZahl = $post->find('.zahlensuche_zz');
                $superNumber = trim($zuperZahl[0]->text());
                if ($superNumber != '') {
                    if (!isset($this->superNumberList[$superNumber])) {
                        $this->superNumberList[$superNumber] = 0;
                    }
                    $this->superNumberList[$superNumber]++;
                }

            }

        }
        return $this;
    }

    /**
     * get all numbers from lottery
     *
     * @return array
     */
    public function getNumbers()
    {
        if (count($this->numberList) === 0) {
            $this->parseNumbers();
        }
        arsort($this->numberList);
        return (array)$this->numberList;
    }

    /**
     * get all super numbers from lottery
     *
     * @return array
     */
    public function getSuperNumbers()
    {
        if (count($this->superNumberList) === 0) {
            $this->parseNumbers();
        }
        arsort($this->superNumberList);
        return (array)$this->superNumberList;
    }

    /**
     * load config from local file
     *
     * @return Lottery
     */
    protected function loadConfig()
    {
        include './config.php';
        $this->config = $config;
        return $this;
    }

}