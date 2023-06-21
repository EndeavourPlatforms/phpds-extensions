<?php

namespace Endeavour\DsExtensions;

use Ds\Set;
use Traversable;

/**
 * @method void add(...$values)
 * @method void allocate(int $capacity)
 * @method bool contains(... $values)
 * @method int capacity()
 * @method void clear()
 * @method int count()
 * @method mixed first()
 * @method mixed get(int $position)
 * @method Traversable getIterator()
 * @method bool isEmpty()
 * @method string join(?string $glue = null)
 * @method mixed reduce(callable $callback, $initial = null)
 * @method void remove(...$values)
 * @method void reverse()
 * @method mixed last()
 * @method void sort(?callable $comparator = null)
 * @method float|int sum()
 * @method array toArray()
 * @method mixed jsonSerializable()
 */
trait SetTrait {
    private Set $set;

    public function __call($name, $arguments)
    {
        if (!method_exists($this->set, $name)) {
            throw new \Exception('method does not exist');
        }

        return $this->set->{$name}(...$arguments);
    }

    public function getSet(): Set
    {
        return $this->set;
    }

    public function copy(): self
    {
        return new self(...$this->set->copy());
    }

    public function diff(self $set): self
    {
        return new self(...$this->set->diff($set->getSet()));
    }

    public function filter(?callable $callback = null): self
    {
        return new self(...$this->set->filter($callback));
    }

    public function intersect(self $set): self
    {
        return new self(...$this->set->intersect($set->getSet()));
    }

    public function map(callable $callback): self
    {
        return new self(...$this->set->map($callback));
    }

    public function merge($values): self
    {
        return new self(...$this->set->merge($values));
    }

    public function reversed(): self
    {
        return new self(...$this->set->reversed());
    }

    public function slice(int $index, ?int $length = null): self
    {
        return new self(...$this->set->slice($index, $length));
    }

    public function sorted(?callable $comparator = null): self
    {
        return new self(...$this->set->sorted($comparator));
    }

    public function union(self $set): self
    {
        return new self(...$this->set->union($set->getSet()));
    }

    public function xor(self $set): self
    {
        return new self(...$this->set->xor($set->getSet()));
    }
}