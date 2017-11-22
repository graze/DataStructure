<?php

namespace Graze\DataStructure\Container;

use PHPUnit_Framework_TestCase as TestCase;

class CollapsedContainerTest extends TestCase
{
    /**
     * @dataProvider getData
     *
     * @param array  $base
     * @param string $key
     * @param mixed  $expected
     */
    public function testGet(array $base, $key, $expected)
    {
        $cont = new CollapsedContainer($base);

        $this->assertEquals($expected, $cont->get($key));
    }

    /**
     * @dataProvider getData
     *
     * @param array  $base
     * @param string $key
     * @param mixed  $expected
     */
    public function testArrayGet(array $base, $key, $expected)
    {
        $cont = new CollapsedContainer($base);

        $this->assertEquals($expected, $cont[$key]);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            [
                ['first' => 'one', 'second' => 'two'],
                'first',
                'one',
            ],
            [
                ['first' => 'one', 'second' => ['a' => 'b', 'c' => 'd']],
                'second',
                ['a' => 'b', 'c' => 'd'],
            ],
            [
                ['first' => 'one', 'second' => ['a' => 'b', 'c' => 'd']],
                'second.a',
                'b',
            ],
            [
                ['first' => 'one', 'second' => ['a' => 'b', 'c' => 'd']],
                'nope',
                null,
            ],
            [
                ['first' => 'one', 'second' => ['a' => 'b', 'c' => 'd']],
                'second.nope',
                null,
            ],
            [
                ['first' => 'one', 'second' => ['a' => 'b', 'c' => 'd']],
                'first.nope',
                null,
            ],
            [
                ['indexed' => ['first', 'second']],
                'indexed.0',
                'first',
            ],
        ];
    }

    /**
     * @dataProvider setData
     *
     * @param array  $base
     * @param string $key
     * @param mixed  $value
     * @param array  $expected
     */
    public function testSet(array $base, $key, $value, array $expected)
    {
        $cont = new CollapsedContainer($base);
        $cont->set($key, $value);

        $this->assertEquals($expected, $cont->getAll());
    }

    /**
     * @dataProvider setData
     *
     * @param array  $base
     * @param string $key
     * @param mixed  $value
     * @param array  $expected
     */
    public function testArraySet(array $base, $key, $value, array $expected)
    {
        $cont = new CollapsedContainer($base);
        $cont[$key] = $value;

        $this->assertEquals($expected, $cont->getAll());
    }

    /**
     * @return array
     */
    public function setData()
    {
        return [
            [
                [],
                'simple',
                'value',
                ['simple' => 'value'],
            ],
            [
                [],
                'key.child',
                'value',
                ['key' => ['child' => 'value']],
            ],
            [
                ['key' => ['child' => 'one']],
                'key.child',
                'value',
                ['key' => ['child' => 'value']],
            ],
            [
                ['key' => ['child' => 'one']],
                'key.second',
                'value',
                ['key' => ['child' => 'one', 'second' => 'value']],
            ],
            [
                ['key' => 'node'],
                'key.second',
                'value',
                ['key' => ['second' => 'value']],
            ],
        ];
    }

    /**
     * @dataProvider hasData
     *
     * @param array  $base
     * @param string $key
     * @param bool   $expected
     */
    public function testHas(array $base, $key, $expected)
    {
        $cont = new CollapsedContainer($base);
        $this->assertEquals($expected, $cont->has($key));
    }

    /**
     * @dataProvider hasData
     *
     * @param array  $base
     * @param string $key
     * @param bool   $expected
     */
    public function testArrayIsset(array $base, $key, $expected)
    {
        $cont = new CollapsedContainer($base);
        $this->assertEquals($expected, isset($cont[$key]));
    }

    /**
     * @return array
     */
    public function hasData()
    {
        return [
            [
                [], 'key', false,
            ],
            [
                [], 'key.nope', false,
            ],
            [
                ['key' => 'value'], 'key', true,
            ],
            [
                ['key' => 'value'], 'nope', false,
            ],
            [
                ['key' => ['child' => 'value']], 'key', true,
            ],
            [
                ['key' => ['child' => 'value']], 'key.child', true,
            ],
            [
                ['key' => ['value']], 'key.value', false,
            ],
            [
                ['key' => ['value']], 'key.0', true,
            ],
            [
                ['key' => ['child' => 'value']], 'key.nope', false,
            ],
        ];
    }

    /**
     * @dataProvider removeData
     *
     * @param array  $base
     * @param string $key
     * @param array  $expected
     */
    public function testRemove(array $base, $key, array $expected)
    {
        $cont = new CollapsedContainer($base);
        $cont->remove($key);
        $this->assertEquals($expected, $cont->getAll());
    }

    /**
     * @dataProvider removeData
     *
     * @param array  $base
     * @param string $key
     * @param array  $expected
     */
    public function testArrayUnset(array $base, $key, array $expected)
    {
        $cont = new CollapsedContainer($base);
        unset($cont[$key]);
        $this->assertEquals($expected, $cont->getAll());
    }

    /**
     * @return array
     */
    public function removeData()
    {
        return [
            [
                [], 'key', [],
            ],
            [
                [], 'key.nope', [],
            ],
            [
                ['key' => 'value'], 'key', [],
            ],
            [
                ['key' => 'value'], 'nope', ['key' => 'value'],
            ],
            [
                ['key' => ['child' => 'value']], 'key', [],
            ],
            [
                ['key' => ['child' => 'value']], 'key.child', ['key' => []],
            ],
            [
                ['key' => ['value']], 'key.value', ['key' => ['value']],
            ],
            [
                ['key' => ['value']], 'key.0', ['key' => []],
            ],
            [
                ['key' => ['child' => 'value']], 'key.nope', ['key' => ['child' => 'value']],
            ],
        ];
    }
}
