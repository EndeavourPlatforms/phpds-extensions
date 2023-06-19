<?php

namespace Endeavour\DsExtensions\Tests\Stubs;

use Ds\Map;
use Endeavour\DsExtensions\MapTrait;

class MyObjectMap
{
    use MapTrait;

    public function __construct(MyObject ...$object) {
        $this->map = new Map($object);
    }
}