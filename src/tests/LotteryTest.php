<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use gratery\Lottery\Lottery;

class LotteryTest extends TestCase
{
    public function testClassHasAttribute(): void
    {
        $this->assertClassHasAttribute('config', Lottery::class);
        $this->assertClassHasAttribute('lotteryDraw', Lottery::class);
    }

    public function testCreateInstance(): void
    {
        $lottery = new Lottery();
        $this->assertInstanceOf(Lottery::class, $lottery);
    }

    public function testGetNumbers(): void
    {
        $config = [
            'limit' => 6,
        ];
        $lottery = new Lottery();
        $numberList = $lottery->getNumbers($config);

        $this->assertNotEmpty($numberList);
        $this->assertSame(6, count($numberList));
    }

    public function testGetSuperNumbers(): void
    {
        $config = [
            'limit' => 2,
        ];
        $lottery = new Lottery();
        $numberList = $lottery->getSuperNumbers($config);

        $this->assertNotEmpty($numberList);
        $this->assertSame(2, count($numberList));
    }
}