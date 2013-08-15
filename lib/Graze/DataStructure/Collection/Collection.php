<?php
namespace Graze\DataStructure\Collection;

use Graze\DataStructure\ArrayInterface;
use ArrayIterator;

class Collection implements ArrayInterface, CollectionInterface, \Serializable
{
    /**
     * @var array
     */
    protected $items = array();

    /**
     * @param array $items
     */
    public function __construct(array $items = array())
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @param mixed $value
     */
    public function add($value)
    {
        $this->items[] = $value;
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    public function contains($value)
    {
        return in_array($value, $this->items, true);
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @param Closure $closure
     * @return array
     */
    public function filter(\Closure $closure)
    {
        $this->items = array_filter($this->items, $closure);
        return $this->items;
    }

    /**
     * @return Iterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @param Closure $closure
     * @return array
     */
    public function map(\Closure $closure)
    {
        $this->items = array_map($closure, $this->items);
        return $this->items;
    }

    /**
     * @param Closure $closure
     * @return array
     */
    public function reduce(\Closure $closure)
    {
        $this->items = array_reduce($this->items, $closure);
        return $this->items;
    }

    /**
     * @param Closure $closure
     * @return array
     */
    public function sort(\Closure $closure)
    {
        @usort($this->items, $closure);
        return $this->items;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->items);
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $this->items = unserialize($data);
    }
}
