<?php
/**
 * The Offdev Project
 *
 * Offdev/Bandit - An A/B/x testing algorithm written in PHP by
 * implementing the solution to the multi armed bandit problem
 *
 * @author      Pascal Severin <pascal@offdev.net>
 * @copyright   Copyright (c) 2020, Pascal Severin
 * @license     Apache License 2.0
 */

namespace Offdev\Bandit;

/**
 * The Strategy interface defines a way to solve a multi
 * armed bandit problem. For more information about
 * existing strategies, please refer to following link:
 *
 * https://en.wikipedia.org/wiki/Multi-armed_bandit#Bandit_strategies
 */
interface StrategyInterface
{
    /**
     * Solves the puzzle, and returns the winning lever.
     */
    public function solve(Machine $machine): Lever;
}
