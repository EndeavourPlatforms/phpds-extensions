<?php

namespace Endeavour\DsExtensions\Tests;

use Endeavour\DsExtensions\Tests\Stubs\MyObject;
use Endeavour\DsExtensions\Tests\Stubs\MyObjectSet;
use PHPUnit\Framework\TestCase;

class MyObjectSetTest extends TestCase
{
    public function testSetSetHasObject() {
        $objects = [
            new MyObject(),
        ];

        $set = new MyObjectSet(...$objects);

        self::assertEquals(1, $set->count());
    }

    public function testCopyGivesNewTypedSet() {
        $objects = [
            new MyObject('test record 1'),
            new MyObject('test record 2'),
        ];

        $set = new MyObjectSet(...$objects);
        $copy = $set->copy();

        self::assertEquals($set, $copy);
    }

    public function testDiffGivesNewTypedSetContainingDiff() {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $set = new MyObjectSet($o1, $o2);
        $set2 = new MyObjectSet($o2, $o3);

        $diff = $set->diff($set2);

        self::assertInstanceOf(MyObjectSet::class, $diff);

        self::assertTrue($diff->contains($o1));
        self::assertFalse($diff->contains($o3));
        self::assertFalse($diff->contains($o2));

        $diff2 = $set2->diff($set);

        self::assertTrue($diff2->contains($o3));
        self::assertFalse($diff2->contains($o1));
        self::assertFalse($diff2->contains($o2));
    }

    public function testFilterGivesNewTypedSetContainingFilteredResult() {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $set = new MyObjectSet($o1, $o2, $o3);

        $filter = $set->filter(fn(MyObject $o) => $o->getTitle() === 'test record 2');

        self::assertInstanceOf(MyObjectSet::class, $filter);

        self::assertTrue($filter->contains($o2));
        self::assertFalse($filter->contains($o1));
        self::assertFalse($filter->contains($o3));
    }

    public function testIntersectGivesNewTypedSetContainingIntersection() {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $set = new MyObjectSet($o1, $o2);
        $set2 = new MyObjectSet($o2, $o3);

        $intersect = $set->intersect($set2);

        self::assertInstanceOf(MyObjectSet::class, $intersect);

        self::assertTrue($intersect->contains($o2));
        self::assertFalse($intersect->contains($o1));
        self::assertFalse($intersect->contains($o3));
    }
    public function testMapGivesTypedSetContainingAppliedMap() {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $set = new MyObjectSet($o1, $o2, $o3);
        $map = $set->map(fn(MyObject $o) => $o->setTitle($o->getTitle() . ' update'));

        self::assertInstanceOf(MyObjectSet::class, $map);

        self::assertEquals('test record 1 update', $map->get(0)->getTitle());
        self::assertEquals('test record 2 update', $map->get(1)->getTitle());
        self::assertEquals('test record 3 update', $map->get(2)->getTitle());
    }

    public function testReversedGivesTypedSetContainingReversedOrder() {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $set = new MyObjectSet($o1, $o2, $o3);
        $reversed = $set->reversed();

        self::assertInstanceOf(MyObjectSet::class, $reversed);

        self::assertEquals('test record 1', $reversed->get(2)->getTitle());
        self::assertEquals('test record 2', $reversed->get(1)->getTitle());
        self::assertEquals('test record 3', $reversed->get(0)->getTitle());
    }

    public function testSliceGivesTypedSetContainingLeftOverObjects() {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $set = new MyObjectSet($o1, $o2, $o3);
        $slice = $set->slice(1, 1);

        self::assertInstanceOf(MyObjectSet::class, $slice);

        self::assertTrue($slice->contains($o2));
        self::assertFalse($slice->contains($o1));
        self::assertFalse($slice->contains($o3));
    }

    public function testUnionGivesTypedSetWithUnionResult() {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $set = new MyObjectSet($o1);
        $set2 = new MyObjectSet($o2, $o3);
        $union = $set->union($set2);

        self::assertInstanceOf(MyObjectSet::class, $union);

        self::assertTrue($union->contains($o1));
        self::assertTrue($union->contains($o2));
        self::assertTrue($union->contains($o3));
    }

    public function testXorGivesTypedSetWithXorResult() {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $set = new MyObjectSet($o1);
        $set2 = new MyObjectSet($o2, $o3);
        $xor = $set->xor($set2);

        self::assertInstanceOf(MyObjectSet::class, $xor);

        self::assertTrue($xor->contains($o1));
        self::assertTrue($xor->contains($o2));
        self::assertTrue($xor->contains($o3));
    }
}