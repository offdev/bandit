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

namespace Offdev\Bandit\Test;

use Offdev\Bandit\Lever;
use Offdev\Bandit\Test\Hooks\TestHook;


/**
 * Class LeverTest
 *
 * @package Offdev\Bandit\Test
 */
class LeverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $id
     *
     * @dataProvider leverNameProvider
     */
    public function testInstantiationSetsIdCorrectly(string $id)
    {
        $lever = new Lever($id);

        $this->assertEquals($id, $lever->getId());
    }

    /**
     * @param int $tries
     *
     * @dataProvider leverNumberProvider
     */
    public function testSetTriesReturnsCorrectValue(int $tries)
    {
        $lever = new Lever('test');
        $lever->setTries($tries);

        $this->assertEquals($tries, $lever->getTries());
    }

    /**
     * @param int $rewards
     *
     * @dataProvider leverNumberProvider
     */
    public function testSetRewardsReturnsCorrectValue(int $rewards)
    {
        $lever = new Lever('test');
        $lever->setRewards($rewards);

        $this->assertEquals($rewards, $lever->getRewards());
    }

    /**
     * Makes sure the hook works fine
     */
    public function testLeverSetHookFillsData()
    {
        $hook = new TestHook();
        $lever = new Lever('test');
        $this->assertInstanceOf(Lever::class, $lever->setHook($hook));

        $this->assertEquals(500, $lever->getTries());
        $this->assertEquals(125, $lever->getRewards());
    }

    /**
     * Makes sure the hook works fine
     */
    public function testPullLeverIncreasesTries()
    {
        $lever = new Lever('test');
        $lever->pull();

        $this->assertEquals(1, $lever->getTries());
    }

    /**
     * Makes sure the hook works fine
     *
     * @expectedException \Exception
     * @expectedExceptionMessage test:501
     */
    public function testPullLeverIncreasesTriesAndHookGetsCalled()
    {
        $hook = new TestHook();
        $lever = new Lever('test');
        $lever->setHook($hook);
        $lever->pull();
    }

    /**
     * Makes sure the hook works fine
     */
    public function testRewardLeverIncreasesRewards()
    {
        $lever = new Lever('test');
        $lever->reward();

        $this->assertEquals(1, $lever->getRewards());
    }

    /**
     * Makes sure the hook works fine
     *
     * @expectedException \Exception
     * @expectedExceptionMessage test:126
     */
    public function testRewardLeverIncreasesRewardsAndHookGetsCalled()
    {
        $hook = new TestHook();
        $lever = new Lever('test');
        $lever->setHook($hook);
        $lever->reward();
    }

    /**
     * @return array[]
     */
    public function leverNameProvider()
    {
        return [
            ["lever"],
            ["other-lever"],
            ["more-levers"],
        ];
    }

    /**
     * @return array[]
     */
    public function leverNumberProvider()
    {
        return [
            [-2147483648],
            [-123456],
            [-1],
            [0],
            [1],
            [123456],
            [2147483647]
        ];
    }
}
