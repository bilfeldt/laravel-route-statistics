<?php

namespace Bilfeldt\LaravelRouteStatistics\Tests\Unit;

use Bilfeldt\LaravelRouteStatistics\Facades\LaravelRouteStatisticsFacade;
use Bilfeldt\LaravelRouteStatistics\LaravelRouteStatistics;
use Bilfeldt\LaravelRouteStatistics\Tests\TestCase;

class LaravelRouteStatisticsTest extends TestCase
{
    /** @var LaravelRouteStatistics */
    protected $class;

    public function setUp(): void
    {
        parent::setUp();

        $this->class = LaravelRouteStatisticsFacade::mergeAttributes([]);
    }

    public function test_enabling()
    {
        $this->assertFalse($this->class->isEnabled());
        $this->class->enable();
        $this->assertTrue($this->class->isEnabled());
        $this->class->disable();
        $this->assertFalse($this->class->isEnabled());
    }

    public function test_attributes()
    {
        $this->assertIsArray($this->class->getAttributes());
        $this->assertEmpty($this->class->getAttributes());

        $this->class->setAttributes(['test1' => 'A', 'test2' => 'B']);

        $this->assertIsArray($this->class->getAttributes());
        $this->assertCount(2, $this->class->getAttributes());
        $this->assertEquals(['test1' => 'A', 'test2' => 'B'], $this->class->getAttributes());

        $this->class->setAttributes(['test3' => 'C']); // This will override the existing attributes

        $this->assertIsArray($this->class->getAttributes());
        $this->assertCount(1, $this->class->getAttributes());
        $this->assertEquals(['test3' => 'C'], $this->class->getAttributes());

        $this->class->mergeAttributes(['test4' => 'D']); // This will merge to the existing attributes

        $this->assertIsArray($this->class->getAttributes());
        $this->assertCount(2, $this->class->getAttributes());
        $this->assertEquals(['test3' => 'C', 'test4' => 'D'], $this->class->getAttributes());
    }
}
