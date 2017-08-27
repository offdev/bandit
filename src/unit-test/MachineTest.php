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

namespace Offdev\Bandit\Test;

use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;
use PHPUnit\Framework\TestCase;

/**
 * Class MachineTest
 *
 * @package Offdev\Bandit\Test
 */
class MachineTest extends TestCase
{
    /**
     * @expectedException \Offdev\Bandit\Exceptions\EmptyNameException
     * @expectedExceptionMessage Cannot add lever with empty name
     */
    public function testAddingEmptyLeverThrowsException()
    {
        $lever = new Lever('');
        $machine = new Machine();

        $machine->addLever($lever);
    }

    /**
     * @param Lever[] $leverList
     * @param string[] $leverIdsList
     *
     * @dataProvider leverListProvider
     */
    public function testGetLeverListReturnSameListOfLevers(array $leverList, array $leverIdsList)
    {
        $machine = new Machine();
        foreach ($leverList as $lever) {
            $machine->addLever($lever);
        }

        $resultList = $machine->getLeverList();
        foreach ($resultList as $lever) {
            $this->assertInstanceOf(Lever::class, $lever);
        }

        $this->assertEquals(count($leverList), count($resultList));
    }

    /**
     * @param Lever[] $leverList
     * @param string[] $leverIdsList
     *
     * @dataProvider leverListProvider
     */
    public function testGetLeverReturnsCorrectLever(array $leverList, array $leverIdsList)
    {
        $machine = new Machine();
        foreach ($leverList as $lever) {
            $machine->addLever($lever);
        }

        foreach ($leverIdsList as $leverId) {
            $lever = $machine->getLever($leverId);

            $this->assertInstanceOf(Lever::class, $lever);
            $this->assertEquals($leverId, $lever->getId());
        }
    }

    /**
     * Trying to be a smartass, huh?
     */
    public function testGetLeverWithUnknownIdReturnsNull()
    {
        $lever = new Lever('name');
        $machine = new Machine();
        $machine->addLever($lever);

        $specificLever = $machine->getLever('non-existing');
        $this->assertNull($specificLever);
    }

    /**
     * @return array
     */
    public function leverListProvider()
    {
        $idList = [
            'lever-one',
            'lever-two',
            'lever-three',
            'lever-four',
            'lever-five',
        ];
        $leverList = [];
        foreach ($idList as $id) {
            $leverList[] = new Lever($id);
        }

        return [
            [$leverList, $idList]
        ];
    }
}
