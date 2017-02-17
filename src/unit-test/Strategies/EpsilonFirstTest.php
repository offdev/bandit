<?php
/**
 * The Offdev Project
 *
 * Offdev/Bandit - An A/B/x testing algorithm written in PHP by
 * implementing the solution to the multi armed bandit problem
 *
 * @author      Pascal Severin <pascal.severin@gmail.com>
 * @copyright   Copyright (c) 2017, Pascal Severin
 * @license     Apache License 2.0
 */

namespace Offdev\Bandit\Test\Strategies;

use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;
use Offdev\Bandit\Strategies\EpsilonFirst;
use PHPUnit\Framework\TestCase;

/**
 * Class EpsilonFirstTest
 *
 * @package Offdev\Bandit\Test\Strategies
 */
class EpsilonFirstTest extends TestCase
{
    /**
     * Adjust the number of levers for the unit test. More levers means
     * a better stability. Less levers means humbug mutation testing might
     * give you more false positives.
     */
    const NUMBER_OF_LEVERS_FOR_TEST = 1000;

    /**
     * @param Machine   $m
     * @param float     $proportion
     * @param int       $exploration
     * @param int       $exploitation
     * @param string    $winnerId
     * @param array     $leverList
     *
     * @dataProvider caseProvider
     */
    public function testAllWorkingSetups(
        Machine $m,
        float $proportion,
        int $exploration,
        int $exploitation,
        string $winnerId,
        array $leverList
    ) {
        $strategy = new EpsilonFirst($proportion, $exploration, $exploitation);
        $lever = $strategy->solve($m);

        if (!empty($winnerId)) {
            $this->assertInstanceOf(Lever::class, $lever);
            $this->assertEquals($winnerId, $lever->getId());
        } else {
            $this->assertInstanceOf(Lever::class, $lever);
            $this->assertTrue(in_array($lever->getId(), $leverList));
        }
    }

    /**
     * @expectedException \Offdev\Bandit\Exceptions\MissingValueException
     * @expectedExceptionMessage No lever added to the machine!
     */
    public function testRunningWithoutLeverThrowsException()
    {
        $m = new Machine();
        $strategy = new EpsilonFirst(0.0, 0, 0);
        $strategy->solve($m);
    }

    /**
     * @expectedException \Offdev\Bandit\Exceptions\MissingValueException
     * @expectedExceptionMessage No lever added to the machine!
     */
    public function testRunningWithoutLeverThrowsAnotherException()
    {
        $m = new Machine();
        $strategy = new EpsilonFirst(1.0, 0, 0);
        $strategy->solve($m);
    }

    /**
     * @return array[]
     */
    public function caseProvider()
    {
        $m = new Machine();
        // Sets up a shitload of levers, just to make sure our calculations are right ^_^
        // Conversions for those levers are all between 10% and 20%
        $nameList = ['winning-lever'];
        for ($i = 0; $i < self::NUMBER_OF_LEVERS_FOR_TEST; $i++) {
            $rewards = 10000 + rand(0, 10000);
            $leverName = sprintf('%.8f', $rewards / 100000);
            $nameList[] = $leverName;
            $m->addLever((new Lever($leverName))->setTries(100000)->setRewards($rewards));
        }
        $m->addLever((new Lever('winning-lever'))->setTries(100000)->setRewards(50000));

        return [
            [$m, 0.1, 1, 100, '', $nameList],
            [$m, 0.1, 0, 0, 'winning-lever', $nameList],
            [$m, 0.1, 20, 100, 'winning-lever', $nameList],
        ];
    }
}
