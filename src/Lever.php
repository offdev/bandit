<?php
declare(strict_types=1);

namespace Offdev\Bandit;

class Lever
{
    private string $id;

    private int $tries;

    private int $rewards;

    public function __construct(int $tries = 0, int $rewards = 0)
    {
        $this->tries = $tries;
        $this->rewards = $rewards;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTries(): int
    {
        return $this->tries;
    }

    public function getRewards(): int
    {
        return $this->rewards;
    }
}