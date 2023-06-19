<?php

namespace Endeavour\DsExtensions\Tests;

use Endeavour\DsExtensions\Tests\Stubs\MyObject;
use Endeavour\DsExtensions\Tests\Stubs\MyObjectMap;
use PHPUnit\Framework\TestCase;

class MyObjectMapTest extends TestCase
{
    public function testCopy()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2, $o3);
        $copy = $map->copy();

        self::assertInstanceOf(MyObjectMap::class, $copy);

        self::assertTrue($copy->hasValue($o1));
        self::assertTrue($copy->hasValue($o2));
        self::assertTrue($copy->hasValue($o3));
    }

    public function testDiff()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2);
        $map2 = new MyObjectMap($o1, $o3);
        $diff = $map->diff($map2);

        self::assertInstanceOf(MyObjectMap::class, $diff);
    }

    public function testFilter()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2, $o3);
        $filter = $map->filter(fn(int $key, MyObject $o) => $o->getTitle() === 'test object 2');

        self::assertInstanceOf(MyObjectMap::class, $filter);

        self::assertTrue($filter->hasValue($o2));
        self::assertFalse($filter->hasValue($o1));
        self::assertFalse($filter->hasValue($o3));
    }
    
    public function testIntersect()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2);
        $map2 = new MyObjectMap($o1, $o3);
        $intersect = $map->intersect($map2);

        self::assertInstanceOf(MyObjectMap::class, $intersect);

        self::assertTrue($intersect->hasValue($o1));
        self::assertTrue($intersect->hasValue($o2));
        self::assertFalse($intersect->hasValue($o3));
    }


    public function testKsorted()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2, $o3);
        $sorted = $map->ksorted(function(int $key, int $prevKey) {
            return $prevKey <=> $key;
        });

        self::assertInstanceOf(MyObjectMap::class, $sorted);

        self::assertTrue($sorted->first()->value->getTitle() === 'test object 3');
        self::assertTrue($sorted->last()->value->getTitle() === 'test object 1');
    }

    public function testMap()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2, $o3);
        $mapped = $map->map(function(int $k, MyObject $o) {
            return $o->setTitle($o->getTitle() . ' updated');
        });

        self::assertInstanceOf(MyObjectMap::class, $mapped);

        self::assertTrue($mapped->get(0)->getTitle() === 'test object 1 updated');
        self::assertTrue($mapped->get(1)->getTitle() === 'test object 2 updated');
        self::assertTrue($mapped->get(2)->getTitle() === 'test object 3 updated');
    }

    public function testMerge()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2);
        $merged = $map->merge([$o3]);

        self::assertInstanceOf(MyObjectMap::class, $merged);

        self::assertTrue($merged->get(0)->getTitle() === 'test object 3');
        self::assertTrue($merged->get(1)->getTitle() === 'test object 2');
    }

    public function testReversed()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2, $o3);
        $reversed = $map->reversed();

        self::assertInstanceOf(MyObjectMap::class, $reversed);

        self::assertTrue($reversed->get(0)->getTitle() === 'test object 3');
        self::assertTrue($reversed->get(1)->getTitle() === 'test object 2');
        self::assertTrue($reversed->get(2)->getTitle() === 'test object 1');
    }

    public function testSlice()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2, $o3);
        $sliced = $map->slice(1, 1);

        self::assertInstanceOf(MyObjectMap::class, $sliced);

        self::assertTrue($sliced->get(0)->getTitle() === 'test object 2');
        self::assertFalse($sliced->hasKey(1));
        self::assertFalse($sliced->hasKey(2));
    }

    public function testSorted()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2, $o3);
        $sorted = $map->sorted(function(MyObject $val, MyObject $prevVal) {
            $intCur = preg_replace('#[^0-9]#', '', $val->getTitle());
            $intPrev = preg_replace('#[^0-9]#', '', $prevVal->getTitle());

            return $intPrev <=> $intCur;

        });

        self::assertInstanceOf(MyObjectMap::class, $sorted);

        self::assertTrue($sorted->first()->value->getTitle() === 'test object 3');
        self::assertTrue($sorted->last()->value->getTitle() === 'test object 1');
    }

    public function testUnion()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2);
        $map2 = new MyObjectMap($o2, $o3);
        $union = $map->union($map2);

        self::assertInstanceOf(MyObjectMap::class, $union);

        self::assertFalse($union->hasValue($o1));
        self::assertTrue($union->hasValue($o2));
        self::assertTrue($union->hasValue($o3));
    }

    public function testXor()
    {
        $o1 = new MyObject('test object 1');
        $o2 = new MyObject('test object 2');
        $o3 = new MyObject('test object 3');

        $map = new MyObjectMap($o1, $o2);
        $map2 = new MyObjectMap($o2, $o3);
        $xor = $map->xor($map2);

        self::assertInstanceOf(MyObjectMap::class, $xor);

        self::assertFalse($xor->hasValue($o1));
        self::assertFalse($xor->hasValue($o2));
        self::assertFalse($xor->hasValue($o3));
    }




}