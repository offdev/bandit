<?php
declare(strict_types=1);

namespace Offdev\Tests\Strategies;

use Offdev\Bandit\Exceptions\RuntimeException;
use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;
use Offdev\Bandit\Strategies\EpsilonFirst;
use PHPUnit\Framework\TestCase;

class EpsilonFirstTest extends TestCase
{
    public function testInstantiationThrowsWhenMaxTriesToLow(): void
    {
        $this->expectException(RuntimeException::class);
        new EpsilonFirst(0, 0.1);
    }

    public function testInstantiationThrowsWhenProbabilityToLow(): void
    {
        $this->expectException(RuntimeException::class);
        new EpsilonFirst(10, -0.1);
    }

    public function testInstantiationThrowsWhenProbabilityToHigh(): void
    {
        $this->expectException(RuntimeException::class);
        new EpsilonFirst(10, 1.1);
    }

    public function testSolveWhenPhaseIsExplorationPhase(): void
    {
        $proportion = 0.1;
        $tries = 10;
        $maxTries = 100;

        $lever = $this->createMock(Lever::class);
        $lever->expects($this->once())->method('getTries')->willReturn($tries);
        $machine = $this->createMock(Machine::class);
        $machine->expects($this->once())->method('getLeverList')->willReturn([$lever]);
        $machine->expects($this->once())->method('getRandomLever')->willReturn($lever);

        $strategy = new EpsilonFirst($maxTries, $proportion);
        $solution = $strategy->solve($machine);

        $this->assertSame($lever, $solution);
    }

    public function testSolveWhenPhaseIsExploitationPhase(): void
    {
        $proportion = 0.1;
        $tries = 11;
        $maxTries = 100;

        $lever = $this->createMock(Lever::class);
        $lever->expects($this->once())->method('getTries')->willReturn($tries);
        $machine = $this->createMock(Machine::class);
        $machine->expects($this->once())->method('getLeverList')->willReturn([$lever]);
        $machine->expects($this->once())->method('getBestLever')->willReturn($lever);

        $strategy = new EpsilonFirst($maxTries, $proportion);
        $solution = $strategy->solve($machine);

        $this->assertSame($lever, $solution);
    }
}
