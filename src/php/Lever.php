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

namespace Offdev\Bandit;

use Offdev\Bandit\Hooks\LeverHook;

/**
 * Class Lever
 *
 * @package Offdev\Bandit
 */
class Lever
{
    /**
     * @var string
     */
    private $id = '';

    /**
     * @var int
     */
    private $tries = 0;

    /**
     * @var int
     */
    private $rewards = 0;

    /**
     * The callback hook, called whenever an action
     * is executed on the lever
     *
     * @var LeverHook|null
     */
    private $hook;

    /**
     * Lever constructor.
     *
     * When building the object, you need to pass it a unique
     * identifier, further referenced as id.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * Returns the id of the lever
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets the number of tries
     *
     * @param int $tries
     * @return Lever
     */
    public function setTries(int $tries): Lever
    {
        $this->tries = $tries;

        return $this;
    }

    /**
     * Retrieves the amount of tries
     *
     * @return int
     */
    public function getTries(): int
    {
        return $this->tries;
    }

    /**
     * Sets the amount of rewards
     *
     * @param int $rewards
     * @return Lever
     */
    public function setRewards(int $rewards): Lever
    {
        $this->rewards = $rewards;

        return $this;
    }

    /**
     * Get the amount of rewards
     *
     * @return int
     */
    public function getRewards(): int
    {
        return $this->rewards;
    }

    /**
     * Set a callback hook, notifying you whenever a lever is
     * pulled or rewarded.
     *
     * @param LeverHook $hook
     *
     * @return Lever
     */
    public function setHook(LeverHook $hook): Lever
    {
        $this->hook = $hook;

        return $this;
    }

    /**
     * Uses a try, and pulls the lever
     *
     * @return mixed
     */
    public function pull()
    {
        $this->tries++;
        if ($this->hook instanceof LeverHook) {
            return $this->hook->tryLever($this);
        }

        return $this->tries;
    }

    /**
     * Rewards this lever
     */
    public function reward()
    {
        $this->rewards++;
        if ($this->hook instanceof LeverHook) {
            return $this->hook->rewardLever($this);
        }

        return $this->rewards;
    }
}
