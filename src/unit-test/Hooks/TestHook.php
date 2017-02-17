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

namespace Offdev\Bandit\Test\Hooks;

use Offdev\Bandit\Hooks\LeverHook;
use Offdev\Bandit\Lever;

/**
 * Class TestHook
 *
 * Testing class, makes unit testing easier.
 *
 * @package Offdev\Bandit\Test\Hooks
 */
class TestHook implements LeverHook
{
    /**
     * @param Lever $lever
     *
     * @throws \Exception
     */
    public function tryLever(Lever $lever)
    {
        throw new \Exception($lever->getId().':'.$lever->getTries());
    }

    /**
     * @param Lever $lever
     *
     * @throws \Exception
     */
    public function rewardLever(Lever $lever)
    {
        throw new \Exception($lever->getId().':'.$lever->getRewards());
    }
}
