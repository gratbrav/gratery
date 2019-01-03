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
     * @return array
     */
    public function getNumbers()
    {
        if (count($this->numberList) === 0) {
            $this->count();
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
            $this->count();
        }
        arsort($this->superNumberList);

        return (array)$this->superNumberList;
    }

}