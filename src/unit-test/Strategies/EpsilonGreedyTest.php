<?php
/**
 * The Offdev Project
 *
 * Offdev/Bandit - An A/B/x testing algorithm written in PHP by
 * implementing the solution to the multi armed bandit problem
 *
 * @author      Pascal Severin <pascal.severin@gmail.com>
 * @copyright   Copyright (c) 2016, Pascal Severin
 * @license     Apache License 2.0
 */

namespace Offdev\Bandit\Test\Strategies;

use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;
use Offdev\Bandit\Strategies\EpsilonGreedy;


/**
 * Class EpsilonGreedyTest
 *
 * @package Offdev\Bandit\Test\Strategies
 */
class EpsilonGreedyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Adjust the number of levers for the unit test. More levers means
     * a better stability. Less levers means humbug mutation testing might
     * give you more false positives.
     */
    const NUMBER_OF_LEVERS_FOR_TEST = 1000;

    /**
     * @dataProvider testCaseProvider
     */
    public function testFullWorkingSetup(
        Machine $m,
        float $randomness,
        string $winnerId,
        array $leverList)
    {
        $strategy = new EpsilonGreedy($randomness);
        $lever = $strategy->solve($m);

        if ($randomness < 0.5) {
            $this->assertInstanceOf(Lever::class, $lever);
            $this->assertTrue(in_array($lever->getId(), $leverList));
        } else {
            $this->assertInstanceOf(Lever::class, $lever);
            $this->assertEquals($winnerId, $lever->getId());
        }
    }

    /**
     * @expectedException \Offdev\Bandit\Exceptions\MissingValueException
     * @expectedExceptionMessage No lever added to the machine!
     */
    public function testRunningWithoutLeverThrowsException()
    {
        $m = new Machine();
        $strategy = new EpsilonGreedy(0.0);
        $strategy->solve($m);
    }

    /**
     * @expectedException \Offdev\Bandit\Exceptions\MissingValueException
     * @expectedExceptionMessage No lever added to the machine!
     */
    public function testRunningWithoutLeverThrowsAnotherException()
    {
        $m = new Machine();
        $strategy = new EpsilonGreedy(1.0);
        $strategy->solve($m);
    }

    /**
     * @return array[]
     */
    public function testCaseProvider()
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
            [$m, 0.1, 'winning-lever', $nameList]
        ];
    }
}
