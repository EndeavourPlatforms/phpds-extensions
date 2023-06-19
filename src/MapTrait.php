<?php

namespace Endeavour\DsExtensions;

use Ds\Map;
use Ds\Pair;
use Ds\Sequence;
use Ds\Set;

/**
 * @method void allocate(int $capacity)
 * @method void apply(callable $callback)
 * @method int capacity()
 * @method int count()
 * @method void clear()
 * @method Pair first()
 * @method mixed get($key, $default = null)
 * @method \Traversable getIterator()
 * @method bool hasKey($key)
 * @method bool hasValue($value)
 * @method bool isEmpty()
 * @method array toArray()
 * @method mixed jsonSerialize()
 * @method Set keys()
 * @method void ksort(?callable $comparator = null)
 * @method Pair last()
 * @method Sequence pairs()
 * @method void put($key, $value)
 * @method void putAll($pairs)
 * @method mixed reduce(callable $callback, $initial)
 * @method mixed remove($key, $default = null)
 * @method void reverse()
 * @method Pair skip(int $position)
 * @method void sort(?callable $comparator = null)
 * @method float|int sum()
 * @method Sequence values()
 */
trait MapTrait
{
    private Map $map;

    public function __call($name, $arguments)
    {
        if (!method_exists($this->map, $name)) {
            throw new \Exception('method does not exist');
        }

        return $this->map->{$name}(...$arguments);
    }

    public function getMap(): Map {
        return $this->map;
    }

    public function copy(): self
    {
        return new self(...$this->map->copy());
    }

    public function diff(self $map): self {
        return new self(...$this->map->diff($map->getMap()));
    }

    public function filter(?callable $callback = null): self {
        return new self(...$this->map->filter($callback));
    }

    public function intersect(self $map): self {
        return new self(...$this->map->intersect($map->getMap()));
    }

    public function ksorted(?callable $comparator = null): self {
        return new self(...$this->map->ksorted($comparator));
    }

    public function map(callable $callback): self {
        return new self(...$this->map->map($callback));
    }

    public function merge($values): self {
        return new self(...$this->map->merge($values));
    }

    public function reversed(): self {
        return new self(...$this->map->reversed());
    }

    public function slice(int $index, ?int $length = null): self {
        return new self(...$this->map->slice($index, $length));
    }

    public function sorted(?callable $comparator = null): self {
        return new self(...$this->map->sorted($comparator));
    }

    public function union(self $map): self {
        return new self(...$this->map->union($map->getMap()));
    }

    public function xor(self $map): self {
        return new self(...$this->map->xor($map->getMap()));
    }
}