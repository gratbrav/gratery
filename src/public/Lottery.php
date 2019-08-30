<?php

namespace gratery\Lottery;

require __DIR__ . '/NumberCount.php';

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
     * Load lottery numbers from file
     *
     * @return Lottery
     */
    protected function parseNumbers()
    {
        $startYear = $this->config['startYear'];
        $endYear = $this->config['currentYear'];

        for ($year = $startYear; $year <= $endYear; $year++) {
            $lotteryDraw = [];
            $lotteryTimestamp = 0;

            $handle = fopen('../data/file' . $year . '.csv', 'r');
            while (($data = fgetcsv($handle)) !== FALSE) {
                $lotteryDraw[] = $data;
            }

            $numberResult = [];
            foreach($lotteryDraw as $post) {
                foreach ($post as $index => $number) {
                    if ($index === 0) {
                        $lotteryTimestamp = strtotime($number);
                        continue;
                    } else if ($index >= 1 && $index <= 6) {
                        $numberResult['number'][] = $number;
                        continue;
                    } else if ($index === 7) {
                        $numberResult['superNumber'][] = $number;
                        continue;
                    }
                }
            }

            $this->lotteryDraw[$lotteryTimestamp] = $numberResult;
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

        $numberList = $numberCount->getNumbers();

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

        $superNumberList = $numberCount->getSuperNumbers();
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
        include '../config.php';
        $this->config = $config;
        return $this;
    }
}