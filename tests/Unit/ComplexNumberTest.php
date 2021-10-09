<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vladimir\Laptop\ComplexNumber\Exceptions\InvalidObjectWhenDividing;
use Vladimir\Laptop\ComplexNumber\ComplexNumber;

class ComplexNumberTest extends TestCase
{
    private float $re = 3;
    private float $im = 4.5;

    private ComplexNumber $complex;

    public function setUp(): void
    {
        $this->complex = new ComplexNumber($this->re, $this->im);
    }

    public function testGetters(): void
    {
        $this->assertEquals($this->re, $this->complex->getReal());
        $this->assertEquals($this->im, $this->complex->getImaginary());
    }

    /**
     * @dataProvider addProvider
     */
    public function testAdd(
        float $re,
        float $im,
        float $expectedRe,
        float $expectedIm
    ): void {
        $newComplex = $this->complex->add(new ComplexNumber($re, $im));

        $this->assertEquals($expectedRe, $newComplex->getReal());
        $this->assertEquals($expectedIm, $newComplex->getImaginary());
    }

    public function addProvider(): array
    {
        return [
            [0, 0, 3, 4.5],
            [1.4, 15.5, 4.4, 20],
            [-1.4, -15.5, 1.6, -11],
            [1.4, -15.5, 4.4, -11],
            [-1.4, 15.5, 1.6, 20],
        ];
    }

    /**
     * @dataProvider subProvider
     */
    public function testSub(
        float $re,
        float $im,
        float $expectedRe,
        float $expectedIm
    ): void {
        $newComplex = $this->complex->sub(new ComplexNumber($re, $im));

        $this->assertEquals($expectedRe, $newComplex->getReal());
        $this->assertEquals($expectedIm, $newComplex->getImaginary());
    }

    public function subProvider(): array
    {
        return [
            [0, 0, 3, 4.5],
            [1.4, 15.5, 1.6, -11],
            [-1.4, -15.5, 4.4, 20],
            [1.4, -15.5, 1.6, 20],
            [-1.4, 15.5, 4.4, -11],
        ];
    }

    /**
     * @dataProvider mulProvider
     */
    public function testMul(
        float $re,
        float $im,
        float $expectedRe,
        float $expectedIm
    ): void {
        $newComplex = $this->complex->mul(new ComplexNumber($re, $im));

        $this->assertEquals($expectedRe, $newComplex->getReal());
        $this->assertEquals($expectedIm, $newComplex->getImaginary());
    }

    public function mulProvider(): array
    {
        return [
            [0, 0, 0, 0],
            [1.4, 15.5, -65.55, 52.8],
            [-1.4, -15.5, 65.55, -52.8],
            [1.4, -15.5, 73.95, -40.2],
            [-1.4, 15.5, -73.95, 40.2],
        ];
    }

    public function testInvalidOtherObjectWhenDividing(): void
    {
        $this->expectException(InvalidObjectWhenDividing::class);
        $this->expectExceptionMessage(InvalidObjectWhenDividing::create()->getMessage());

        $this->complex->div(new ComplexNumber(0, 0));
    }

    /**
     * @dataProvider divProvider
     */
    public function testDiv(
        float $re,
        float $im,
        float $expectedRe,
        float $expectedIm
    ): void {
        $newComplex = $this->complex->div(new ComplexNumber($re, $im));

        $this->assertEqualsWithDelta($expectedRe, $newComplex->getReal(), 0.00001);
        $this->assertEqualsWithDelta($expectedIm, $newComplex->getImaginary(), 0.00001);
    }

    public function divProvider(): array
    {
        return [
            [1.4, 15.5, 0.30531, -0.16597],
            [-1.4, -15.5, -0.30531, 0.16597],
            [1.4, -15.5, -0.27063, 0.21799],
            [-1.4, 15.5, 0.27063, -0.21799],
        ];
    }
}