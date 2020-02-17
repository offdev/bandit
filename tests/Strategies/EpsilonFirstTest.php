<?php
declare(strict_types=1);

namespace Offdev\Tests\Strategies;

use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;
use Offdev\Bandit\Strategies\EpsilonFirst;
use PHPUnit\Framework\TestCase;

class EpsilonFirstTest extends TestCase
{
    public function testInstantiationThrowsWhenTriesToLow()
    {
        $this->expectException(\RuntimeException::class);
        new EpsilonFirst(-1, 100, 0.1);
    }

    public function testInstantiationThrowsWhenMaxTriesToLow()
    {
        $this->expectException(\RuntimeException::class);
        new EpsilonFirst(0, 0, 0.1);
    }

    public function testInstantiationThrowsWhenProbabilityToLow()
    {
        $this->expectException(\RuntimeException::class);
        new EpsilonFirst(0, 10, -0.1);
    }

    public function testInstantiationThrowsWhenProbabilityToHigh()
    {
        $this->expectException(\RuntimeException::class);
        new EpsilonFirst(0, 10, 1.1);
    }

    public function testSolveWhenPhaseIsExplorationPhase()
    {
        $proportion = 0.1;
        $tries = 10;
        $maxTries = 100;

        $lever = $this->createMock(Lever::class);
        $machine = $this->createMock(Machine::class);
        $machine->expects($this->once())->method('getRandomLever')->willReturn($lever);

        $strategy = new EpsilonFirst($tries, $maxTries, $proportion);
        $solution = $strategy->solve($machine);

        $this->assertSame($lever, $solution);
    }

    public function testSolveWhenPhaseIsExploitationPhase()
    {
        $proportion = 0.1;
        $tries = 11;
        $maxTries = 100;

        $lever = $this->createMock(Lever::class);
        $machine = $this->createMock(Machine::class);
        $machine->expects($this->once())->method('getBestLever')->willReturn($lever);

        $strategy = new EpsilonFirst($tries, $maxTries, $proportion);
        $solution = $strategy->solve($machine);

        $this->assertSame($lever, $solution);
    }
}
