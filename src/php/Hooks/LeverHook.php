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

namespace Offdev\Bandit\Hooks;

use Offdev\Bandit\Lever;

/**
 * Hooks! Everybody LOVES hooks =D
 *
 * @package Offdev\Bandit\Hooks
 */
interface LeverHook
{
    /**
     * @param Lever $lever
     */
    public function tryLever(Lever $lever);

    /**
     * @param Lever $lever
     */
    public function rewardLever(Lever $lever);
}
