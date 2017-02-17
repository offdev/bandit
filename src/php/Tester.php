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

namespace Offdev\Bandit;

use Offdev\Bandit\Exceptions\MissingValueException;
use Offdev\Bandit\Hooks\LeverHook;
use Offdev\Bandit\Strategies\Strategy;

/**
 * Class Tester
 *
 * Represents the human being trying to decide which lever to pull
 * at the multi armed bandit. Get a machined assigned, and a strategy,
 * to hopefully win the jackpot!
 *
 * @package Offdev\Bandit
 */
class Tester
{
    /**
     * The machine we're playing
     *
     * @var Machine
     */
    private $machine;

    /**
     * The strategy we've chosen to pull a lever
     *
     * @var Strategy
     */
    private $strategy;

    /**
     * The callback hook, which will be passed to the winning lever
     *
     * @var LeverHook|null
     */
    private $hook;

    /**
     * Runs the bandit, and returns the lever most probable of winning
     *
     * @return Lever
     *
     * @throws MissingValueException
     */
    public function run(): Lever
    {
        if (is_null($this->machine)) {
            throw new MissingValueException("No machine set");
        }

        if (is_null($this->strategy)) {
            throw new MissingValueException("No strategy set");
        }

        $lever = $this->strategy->solve($this->machine);
        if ($this->hook instanceof LeverHook) {
            $lever->setHook($this->hook);
        }

        return $lever;
    }

    /**
     * Set a callback hook, notifying you whenever a lever is
     * pulled or rewarded.
     *
     * @param LeverHook $hook
     *
     * @return Tester
     */
    public function setHook(LeverHook $hook): Tester
    {
        $this->hook = $hook;

        return $this;
    }

    /**
     * @return Machine
     *
     * @throws MissingValueException
     */
    public function getMachine(): Machine
    {
        if (is_null($this->machine)) {
            throw new MissingValueException("No machine set");
        }

        return $this->machine;
    }

    /**
     * @param Machine $machine
     *
     * @return Tester
     */
    public function setMachine(Machine $machine): Tester
    {
        $this->machine = $machine;

        return $this;
    }

    /**
     * @return Strategy
     *
     * @throws MissingValueException
     */
    public function getStrategy(): Strategy
    {
        if (is_null($this->strategy)) {
            throw new MissingValueException("No strategy set");
        }

        return $this->strategy;
    }

    /**
     * @param Strategy $strategy
     *
     * @return Tester
     */
    public function setStrategy(Strategy $strategy): Tester
    {
        $this->strategy = $strategy;

        return $this;
    }
}
