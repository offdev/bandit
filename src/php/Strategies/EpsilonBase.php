<?php
/**
 * The Offdev Project
 *
 * Offdev/Bandit - An A/B/x testing algorithm written in PHP by
 * implementing the solution to the multi armed bandit problem
 *
 * @author      Pascal Severin <pascal@offdev.net>
 * @copyright   Copyright (c) 2017, Pascal Severin
 * @license     Apache License 2.0
 */

namespace Offdev\Bandit\Strategies;

use Offdev\Bandit\Exceptions\MissingValueException;
use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;

/**
 * Class EpsilonBase
 *
 * Implements base functionality for the epsilon-* algorithms.
 *
 * @package Offdev\Bandit\Strategies
 */
abstract class EpsilonBase implements Strategy
{
    /**
     * Probability (in percent) of pulling a lever randomly.
     *
     * @var float
     */
    protected $e = 0.1;

    /**
     * Returns the lever which has the best conversion rate.
     * Throws an exception if no lever can be found.
     *
     * @param Machine $machine
     *
     * @return Lever
     *
     * @throws MissingValueException
     */
    protected function getBestLever(Machine $machine): Lever
    {
        $list = $machine->getLeverList();
        if (empty($list)) {
            throw new MissingValueException("No lever added to the machine!");
        }

        $bestLever = reset($list);
        $bestConversion = $this->getConversion($bestLever);
        foreach ($list as $lever) {
            $c = $this->getConversion($lever);
            if ($c > $bestConversion) {
                $bestConversion = $c;
                $bestLever = $lever;
            }
        }

        return $bestLever;
    }

    /**
     * Returns a lever at random. Throws an exception if no lever can be found.
     *
     * @param Machine $machine
     *
     * @return Lever
     *
     * @throws MissingValueException
     */
    protected function getRandomLever(Machine $machine): Lever
    {
        $list = $machine->getLeverList();
        if (empty($list)) {
            throw new MissingValueException("No lever added to the machine!");
        }
        $k = array_rand($list);

        return $list[$k];
    }

    /**
     * Returns the conversion rate for a specific lever.
     *
     * @param Lever $lever
     *
     * @return float
     */
    protected function getConversion(Lever $lever): float
    {
        if (!$lever->getTries()) {
            return 1.0;
        }

        return $lever->getRewards() / $lever->getTries();
    }
}
