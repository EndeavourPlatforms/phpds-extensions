<?php

namespace Endeavour\DsExtensions\Tests;

use Endeavour\DsExtensions\Tests\Stubs\MyObject;
use Endeavour\DsExtensions\Tests\Stubs\MyObjectVector;
use PHPUnit\Framework\TestCase;

class MyobjectVectorTest extends TestCase
{
    public function testCopyReturnsNewTypedVector()
    {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $vector = new MyObjectVector($o1, $o2, $o3);
        $copy = $vector->copy();

        self::assertInstanceOf(MyObjectVector::class, $copy);

        self::assertTrue($copy->contains($o1));
        self::assertTrue($copy->contains($o2));
        self::assertTrue($copy->contains($o3));
    }

    public function testFilterReturnsNewFilteredTypedVector()
    {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $vector = new MyObjectVector($o1, $o2, $o3);
        $filtered = $vector->filter(fn(MyObject $o) => $o->getTitle() === 'test record 2');

        self::assertInstanceOf(MyObjectVector::class, $filtered);

        self::assertFalse($filtered->contains($o1));
        self::assertTrue($filtered->contains($o2));
        self::assertFalse($filtered->contains($o3));
    }

    public function testMapReturnsNewMappedVector()
    {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $vector = new MyObjectVector($o1, $o2, $o3);
        $mapped = $vector->map(fn(MyObject $o) => $o->setTitle($o->getTitle() . ' updated'));

        self::assertInstanceOf(MyObjectVector::class, $mapped);

        self::assertEquals('test record 1 updated', $mapped->get(0)->getTitle());
        self::assertEquals('test record 2 updated', $mapped->get(1)->getTitle());
        self::assertEquals('test record 3 updated', $mapped->get(2)->getTitle());
    }

    public function testMergeReturnsNewMergedVector()
    {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $vector = new MyObjectVector($o1);
        $merged = $vector->merge([$o2, $o3]);

        self::assertInstanceOf(MyObjectVector::class, $merged);

        self::assertTrue($merged->contains($o1));
        self::assertTrue($merged->contains($o2));
        self::assertTrue($merged->contains($o3));
    }

    public function testReversedReturnsNewReversedVector()
    {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $vector = new MyObjectVector($o1, $o2, $o3);
        $reversed = $vector->reversed();

        self::assertInstanceOf(MyObjectVector::class, $reversed);

        self::assertSame($o3, $reversed->get(0));
        self::assertSame($o2, $reversed->get(1));
        self::assertSame($o1, $reversed->get(2));
    }

    public function testSliceReturnsNewSlicedVector()
    {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $vector = new MyObjectVector($o1, $o2, $o3);
        $slice = $vector->slice(1,1);

        self::assertInstanceOf(MyObjectVector::class, $slice);

        self::assertTrue($slice->contains($o2));
        self::assertFalse($slice->contains($o1));
        self::assertFalse($slice->contains($o3));
    }

    public function testSortedReturnsNewSortedVector()
    {
        $o1 = new MyObject('test record 1');
        $o2 = new MyObject('test record 2');
        $o3 = new MyObject('test record 3');

        $vector = new MyObjectVector($o2, $o1, $o3);
        $sorted = $vector->sorted(function (MyObject $current, MyObject $previous) {
            $currentInt = preg_replace('#[^0-9]#', '', $current->getTitle());
            $previousInt = preg_replace('#[^0-9]#', '', $previous->getTitle());

            if ($currentInt > $previousInt) {
                return 1;
            }

            if ($currentInt < $previousInt) {
                return -1;
            }

            return 0;
        });

        self::assertInstanceOf(MyObjectVector::class, $sorted);

        self::assertSame($o1, $sorted->get(0));
        self::assertSame($o2, $sorted->get(1));
        self::assertSame($o3, $sorted->get(2));
    }



}