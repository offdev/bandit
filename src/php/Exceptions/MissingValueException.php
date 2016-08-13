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

namespace Offdev\Bandit\Exceptions;

/**
 * Class EmptyNameException
 *
 * Thrown whenever someone (or some object) feels something missing. Any thieves around?
 *
 * @package Offdev\Bandit\Exceptions
 */
class MissingValueException extends \Exception
{
}
