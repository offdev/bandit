<?php
declare(strict_types=1);

namespace Offdev\Tests;

use Offdev\Skeleton\ExampleClass;
use PHPUnit\Framework\TestCase;

/**
 * Class ExampleTest
 * @package Offdev\Tests
 */
final class ExampleTest extends TestCase
{
    /**
     * The most meaningful test, ever!
     */
    public function testGreetMethod()
    {
        $obj = new ExampleClass();
        $result = $obj->greet('Pascal');
        $this->assertEquals('Hello, Pascal!', $result);
    }
}
