<?php
declare(strict_types=1);

namespace Offdev\Tests;

use Offdev\Bandit\Lever;
use PHPUnit\Framework\TestCase;

final class LeverTest extends TestCase
{
    public function testGetId()
    {
        $lever = new Lever('lever-1', 100, 10);

        $this->assertSame('lever-1', $lever->getId());
    }

    public function testGetTries()
    {
        $lever = new Lever('lever-1', 100, 10);

        $this->assertSame(100, $lever->getTries());
    }

    public function testGetRewards()
    {
        $lever = new Lever('lever-1', 100, 10);

        $this->assertSame(10, $lever->getRewards());
    }
}
