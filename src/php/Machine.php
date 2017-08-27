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

use Offdev\Bandit\Exceptions\EmptyNameException;

/**
 * Class Machine
 *
 * @package Offdev\Bandit
 */
class Machine
{
    /**
     * @var Lever[]
     */
    private $leverList = [];

    /**
     * @param Lever $lever
     *
     * @return Machine
     * @throws EmptyNameException
     */
    public function addLever(Lever $lever): Machine
    {
        $leverId = $lever->getId();
        if (empty($leverId)) {
            throw new EmptyNameException("Cannot add lever with empty name");
        } else {
            $this->leverList[$leverId] = $lever;
        }

        return $this;
    }

    /**
     * @return Lever[]
     */
    public function getLeverList(): array
    {
        return $this->leverList;
    }

    /**
     * @param string $id
     *
     * @return Lever|null
     */
    public function getLever(string $id)
    {
        if (isset($this->leverList[$id])) {
            return $this->leverList[$id];
        }

        return null;
    }
}
