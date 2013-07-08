<?php
namespace Graze\DataStructure\Container;

use Graze\DataStructure\ArrayInterface;
use OutOfBoundsException;

class Container implements ArrayInterface, ContainerInterface, \Serializable
{
    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        foreach ($parameters as $key => $value) {
            $this->add($key, $value);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function add($key, $value)
    {
        if ($this->has($key)) {
            throw new OutOfBoundsException('Container already has a value for "' . $key . '"');
        }

        $this->set($key, $value);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->has($key) ? $this->parameters[$key] ? null;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return isset($this->parameters[$key]);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @param string $key
     */
    public function remove($key)
    {
        if ($this->has([$key])) {
            unset($this->parameters[$key]);
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->parameters);
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $this->parameters = unserialize($data);
    }
}