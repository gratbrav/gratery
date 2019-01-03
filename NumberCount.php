<?php

namespace gratery\Lottery;

require __DIR__ . '/Number.php';

class NumberCount extends Number
{
    /**
     * count all numbers in lottery draw
     *
     * @return NumberCount
     */
    public function count()
    {
        // check each lottery draw
        foreach ((array)$this->lotteryDraw as $draw) {
            // count each number
            foreach ((array)$draw['number'] as $number) {
                if (!isset($this->numberList[$number])) {
                    $this->numberList[$number] = 0;
                }
                $this->numberList[$number]++;
            }

            // count super number
            if (isset($draw['superNumber'])) {
                if (!isset($this->superNumberList[$draw['superNumber']])) {
                    $this->superNumberList[$draw['superNumber']] = 0;
                }
                $this->superNumberList[$draw['superNumber']]++;
            }
        }

        return $this;
    }

}