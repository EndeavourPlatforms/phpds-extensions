<?php

namespace Endeavour\DsExtensions;

use Ds\Vector;
use Traversable;


/**
 * @method void allocate(int $capacity)
 * @method void apply(callable $callback)
 * @method int capacity()
 * @method void clear()
 * @method bool contains(...$values)
 * @method mixed find($value)
 * @method mixed first()
 * @method mixed get(int $index)
 * @method Traversable getIterator()
 * @method void insert(int $index, ...$values)
 * @method string join(?string $glue = null)
 * @method mixed last()
 * @method mixed pop()
 * @method mixed push(...$values)
 * @method mixed reduce(callable $callback, $initial = null)
 * @method mixed remove(int $index)
 * @method void reverse()
 * @method void rotate(int $rotations)
 * @method void set(int $index, $value)
 * @method mixed shift()
 * @method void sort(?callable $comparator = null)
 * @method float sum()
 * @method void unshift($values)
 * @method int count()
 * @method bool isEmpty()
 * @method array toArray()
 * @method mixed jsonSerializable()
 */
trait VectorTrait {
    private Vector $vector;

    public function __call($name, $arguments)
    {
        if (!method_exists($this->vector, $name)) {
            throw new \Exception('method does not exist');
        }

        return $this->vector->{$name}(...$arguments);
    }

    public function getVector(): Vector
    {
        return $this->vector;
    }

    public function copy(): self
    {
        return new self(...$this->vector->copy());
    }

    public function filter(?callable $callback = null): self
    {
        return new self(...$this->vector->filter($callback));
    }

    public function map(callable $callback): self
    {
        return new self(...$this->vector->map($callback));
    }

    public function merge($values): self
    {
        return new self(...$this->vector->merge($values));
    }

    public function reversed(): self
    {
        return new self(...$this->vector->reversed());
    }

    public function slice(int $index, int $length = null): self
    {
        return new self(...$this->vector->slice($index, $length));
    }

    public function sorted(?callable $comparator = null): self
    {
        return new self(...$this->vector->sorted($comparator));
    }
}