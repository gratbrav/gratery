<?php

namespace gratery\Lottery;

abstract class Number
{
    abstract public function count();

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

    function __construct(&$lotteryDraw)
    {
        $this->lotteryDraw = $lotteryDraw;
    }


    /**
     * get all numbers from lottery
     *
     * @param array $config
     * @return array
     */
    public function getNumbers($config)
    {
        if (count($this->numberList) === 0) {
            $this->count();
        }

        if (isset($config['sort']) && $config['sort'] === 'desc') {
            asort($this->numberList);
        } else {
            arsort($this->numberList);
        }

        return (array)$this->numberList;
    }

    /**
     * get all super numbers from lottery
     *
     * @param array $config
     * @return array
     */
    public function getSuperNumbers($config)
    {
        if (count($this->superNumberList) === 0) {
            $this->count();
        }

        if (isset($config['sort']) && $config['sort'] === 'desc') {
            asort($this->superNumberList);
        } else {
            arsort($this->superNumberList);
        }

        return (array)$this->superNumberList;
    }

}