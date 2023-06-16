# phpds-extensions

This is a small extension library which will allow you to create strong typed php datastructures as well as typing it's contents.

### Usage

```
class MySet {

    use \Endeavour\DsExtensions\SetTrait;
    
    public function __construct(MyObjectType ... $object) {}
}
```