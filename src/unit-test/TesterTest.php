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

use Offdev\Bandit\Tester;
use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;
use Offdev\Bandit\Strategies\Strategy;
use Offdev\Bandit\Strategies\EpsilonGreedy;


/**
 * Class TesterTest
 *
 * @package Offdev\Bandit\Test
 */
class TesterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * What is this? Cheating the code coverage?!
     */
    public function testSettingMachineReturnsBanditInstance()
    {
        $m = new Machine();
        $bandit = new Tester();

        $this->assertInstanceOf(Tester::class, $bandit->setMachine($m));
    }

    /**
     * @expectedException \Offdev\Bandit\Exceptions\MissingValueException
     * @expectedExceptionMessage No machine set
     */
    public function testGetMachineThrowsUpWhenNoMachineSet()
    {
        $bandit = new Tester();
        $bandit->getMachine();
    }

    /**
     * Makes sure we get what we want
     */
    public function testGetMachineReturnsMachine()
    {
        $m = new Machine();
        $bandit = new Tester();

        $this->assertInstanceOf(Tester::class, $bandit->setMachine($m));
        $this->assertInstanceOf(Machine::class, $bandit->getMachine());
        $this->assertSame($m, $bandit->getMachine());
    }

    /**
     * Makes sure we get what we want
     */
    public function testSettingStrategyReturnsBanditInstance()
    {
        $s = new EpsilonGreedy(0.0);
        $bandit = new Tester();

        $this->assertInstanceOf(Tester::class, $bandit->setStrategy($s));
    }

    /**
     * Makes sure have a Strategy before trying to get one
     *
     * @expectedException \Offdev\Bandit\Exceptions\MissingValueException
     * @expectedExceptionMessage No strategy set
     */
    public function testGetStrategyThrowsUpWhenNoStrategySet()
    {
        $bandit = new Tester();
        $bandit->getStrategy();
    }

    /**
     * Makes sure we get what we want
     */
    public function testGetStrategyReturnsStrategy()
    {
        $s = new EpsilonGreedy(0.0);
        $bandit = new Tester();

        $this->assertInstanceOf(Tester::class, $bandit->setStrategy($s));
        $this->assertInstanceOf(Strategy::class, $bandit->getStrategy());
        $this->assertSame($s, $bandit->getStrategy());
    }

    /**
     * @expectedException \Offdev\Bandit\Exceptions\MissingValueException
     * @expectedExceptionMessage No machine set
     */
    public function testRunWithoutMachineThrowsException()
    {
        $s = new EpsilonGreedy(0.0);
        $bandit = new Tester();
        $bandit->setStrategy($s);

        $bandit->run();
    }

    /**
     * @expectedException \Offdev\Bandit\Exceptions\MissingValueException
     * @expectedExceptionMessage No strategy set
     */
    public function testRunWithoutStrategyThrowsException()
    {
        $m = new Machine();
        $bandit = new Tester();
        $bandit->setMachine($m);

        $bandit->run();
    }

    /**
     * Makes sure we get what we want
     */
    public function testRunReturnsLever()
    {
        $m = new Machine();
        $s = new EpsilonGreedy(0.0);

        $m->addLever(new Lever('test-lever'));

        $bandit = new Tester();
        $lever = $bandit->setMachine($m)->setStrategy($s)->run();

        $this->assertInstanceOf(Lever::class, $lever);
    }
}
