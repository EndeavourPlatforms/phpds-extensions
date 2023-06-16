<?php

namespace Endeavour\DsExtensions\Tests\Stubs;

use Ds\Set;
use Endeavour\DsExtensions\SetTrait;

class MyObjectSet
{
    use SetTrait;

    public function __construct(MyObject ... $myObject) {
        $this->set = new Set($myObject);
    }
}