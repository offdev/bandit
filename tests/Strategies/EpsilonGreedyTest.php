<?php
declare(strict_types=1);

namespace Offdev\Tests\Strategies;

use Offdev\Bandit\Exceptions\RuntimeException;
use Offdev\Bandit\Lever;
use Offdev\Bandit\Machine;
use Offdev\Bandit\Math\RandomNumberGeneratorInterface;
use Offdev\Bandit\Strategies\EpsilonGreedy;
use PHPUnit\Framework\TestCase;

class EpsilonGreedyTest extends TestCase
{
    public function testInstantiationThrowsWhenProbabilityToLow(): void
    {
        $rngMock = $this->createMock(RandomNumberGeneratorInterface::class);

        $this->expectException(RuntimeException::class);
        new EpsilonGreedy($rngMock, -0.1);
    }

    public function testInstantiationThrowsWhenProbabilityToHigh(): void
    {
        $rngMock = $this->createMock(RandomNumberGeneratorInterface::class);

        $this->expectException(RuntimeException::class);
        new EpsilonGreedy($rngMock, 1.1);
    }

    public function testSolveWhenRandomLeverIsSelected(): void
    {
        $proportion = 0.1;

        $lever = $this->createMock(Lever::class);
        $machine = $this->createMock(Machine::class);
        $machine->expects($this->once())->method('getRandomLever')->willReturn($lever);

        $rngMock = $this->createMock(RandomNumberGeneratorInterface::class);
        $rngMock->expects($this->once())->method('float')->willReturn(0.0);

        $strategy = new EpsilonGreedy($rngMock, $proportion);
        $solution = $strategy->solve($machine);

        $this->assertSame($lever, $solution);
    }

    public function testSolveWhenBestLeverIsSelected(): void
    {
        $proportion = 0.1;

        $lever = $this->createMock(Lever::class);
        $machine = $this->createMock(Machine::class);
        $machine->expects($this->once())->method('getBestLever')->willReturn($lever);

        $rngMock = $this->createMock(RandomNumberGeneratorInterface::class);
        $rngMock->expects($this->once())->method('float')->willReturn(0.5);

        $strategy = new EpsilonGreedy($rngMock, $proportion);
        $solution = $strategy->solve($machine);

        $this->assertSame($lever, $solution);
    }
}
