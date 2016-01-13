# PHP Library for reading and writing binary data

[![Build Status](https://secure.travis-ci.org/nesQuick/ByteBuffer.png?branch=master)](http://travis-ci.org/nesQuick/ByteBuffer)  [![No Maintenance Intended](http://unmaintained.tech/badge.svg)](http://unmaintained.tech/)

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

A simple usage example could look like this

```php
<?php

require __DIR__ . '/vendor/.composer/autoload.php';

use TrafficCophp\ByteBuffer\ByteBuffer;

$channel = 'channel_one';
$message = 'php';

$buffer = new ByteBuffer(4 + 1 + 4 + strlen($channel) + strlen($message));
$buffer->writeInt32BE($buffer->length(), 0);
$buffer->writeInt8(0x1, 4);
$buffer->writeInt32BE(strlen($channel), 5);
$buffer->write($channel, 9);
$buffer->write($message, 9 + strlen($channel));

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$result = socket_connect($socket, '127.0.0.1', 3542);

socket_write($socket, (string) $buffer, $buffer->length());
```

## ToDo's

* Write Documentation
* Improve examples
* Allow Buffer as constructor
* Write test for concatinating buffers

## License

Licensed under the MIT license.
