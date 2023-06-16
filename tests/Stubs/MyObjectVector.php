<?php

namespace Endeavour\DsExtensions\Tests\Stubs;

use Ds\Vector;
use Endeavour\DsExtensions\VectorTrait;

class MyObjectVector
{
    use VectorTrait;
    public function __construct(MyObject ... $object)
    {
        $this->vector = new Vector($object);
    }
}