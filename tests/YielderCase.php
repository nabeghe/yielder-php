<?php declare(strict_types=1);

use Nabeghe\Yielder\Yielder;

class YielderCase extends \PHPUnit\Framework\TestCase
{
    public function testSimple(): void
    {
        $data = [
            'value 1',
            'value 2',
            'value 3',
        ];
        $value = Yielder::value($data, $index);
        $this->assertSame('value 1', $value);
        $this->assertSame(0, $index);

        $value = Yielder::value($data, $index);
        $this->assertSame('value 2', $value);
        $this->assertSame(1, 1);

        $value = Yielder::value($data, $index);
        $this->assertSame('value 3', $value);
        $this->assertSame(2, 2);

        $value = Yielder::value($data, $index);
        $this->assertSame(null, $value);
        $this->assertSame(-1, $index);

        $value = Yielder::value($data, $index);
        $this->assertSame(null, $value);
        $this->assertSame(-1, $index);

        Yielder::reset($data);
        $value = Yielder::value($data, $index);
        $this->assertSame('value 1', $value);
        $this->assertSame(0, $index);
    }

    public function testYieldValueCall(): void
    {
        $data = [
            function () {
                return 'value 1';
            },
            function () {
                return 'value 2';
            },
            function () {
                return 'value 3';
            },
        ];
        $value = Yielder::valueCall($data, $index);
        $this->assertSame('value 1', $value);
        $this->assertSame(0, $index);

        $value = Yielder::valueCall($data, $index);
        $this->assertSame('value 2', $value);
        $this->assertSame(1, 1);

        $value = Yielder::valueCall($data, $index);
        $this->assertSame('value 3', $value);
        $this->assertSame(2, 2);
    }

    public function testItterate(): void
    {
        $data = [
            'value 1',
            'value 2',
            'value 3',
            'value 4',
            'value 5',
            'value 6',
            'value 7',
            'value 8',
            'value 9',
            'value 10',
        ];
        Yielder::each($data, function ($value, $index) {
            $this->assertSame('value '.($index + 1), $value);
        });
        Yielder::each($data, function ($value, $index) {
            $this->assertSame('value '.($index + 1), $value);
        });
    }
}