# PHP Library for (reading) and writing binary data

[![Build Status](https://secure.travis-ci.org/nesQuick/ByteBuffer.png?branch=master)](http://travis-ci.org/nesQuick/ByteBuffer)

I intentionally needed that for writing a PHP Client for [TrafficCop](https://github.com/santosh79/traffic_cop/).
But the source grows so I decided to move it into an own package.
You can also call this a [pack()](http://www.php.net/manual/en/function.pack.php) wrapper.

## Install

Installation should be done via [composer](http://packagist.org/).

```
{
    "require": {
        "TrafficCophp/ByteBuffer": "dev-master"
    }
}
```

## Example

```php
$tbd = true;
```

## ToDo's

* Implement support for reading
* Write Documentation

## License

Licensed under the MIT license.