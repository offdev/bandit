<?php
declare(strict_types=1);

namespace Offdev\Tests;

use Offdev\Bandit\Exceptions\RuntimeException;
use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;
use PHPUnit\Framework\TestCase;

class MachineTest extends TestCase
{
    public function testMachineWhenNoLeversGiven(): void
    {
        $this->expectException(RuntimeException::class);
        new Machine();
    }

    public function testGetLeverList(): void
    {
        $leverList = [
            new Lever('1', 100, 10),
            new Lever('2', 10, 2)
        ];

        $machine = new Machine(...$leverList);
        $this->assertSame($leverList, $machine->getLeverList());
    }

    public function testGetRandomLever(): void
    {
        $leverList = [
            new Lever('1', 100, 10),
            new Lever('2', 10, 2)
        ];

        $machine = new Machine(...$leverList);
        $lever = $machine->getRandomLever();

        $this->assertInstanceOf(Lever::class, $lever);
        $this->assertContains($lever->getId(), ['1', '2']);
    }

    public function testGetBestLever(): void
    {
        $leverList = [
            new Lever('1', 100, 10),
            new Lever('2', 10, 2)
        ];

        $machine = new Machine(...$leverList);
        $lever = $machine->getBestLever();

        $this->assertSame('2', $lever->getId());
    }

    public function testGetBestLeverWhenLeverHasNoTries(): void
    {
        $leverList = [
            new Lever('1', 100, 10),
            new Lever('2', 0, 0)
        ];

        $machine = new Machine(...$leverList);
        $lever = $machine->getBestLever();

        $this->assertSame('2', $lever->getId());
    }
}
