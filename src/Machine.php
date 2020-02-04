<?php
declare(strict_types=1);

namespace Offdev\Bandit;

class Machine
{
    private array $leverList = [];

    public function __construct(Lever ...$levers)
    {
        $this->leverList = $levers;
    }

    /**
     * @return Lever[]
     */
    public function getLeverList(): array
    {
        return $this->leverList;
    }
}
