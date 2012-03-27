<?php

use TrafficCophp\ByteBuffer\Buffer;

/**
 * Buffer testsuite
 */
class BufferTest extends PHPUnit_Framework_TestCase {

	public function testTrailingEmptyByte() {
		$buffer = new Buffer(5);
		$buffer->writeInt32LE(0xfeedface, 0);
		$this->assertSame(pack('Vx', 0xfeedface), (string) $buffer);
	}

	public function testSurroundedEmptyByte() {
		$buffer = new Buffer(9);
		$buffer->writeInt32BE(0xfeedface, 0);
		$buffer->writeInt32BE(0xcafebabe, 5);
		$this->assertSame(pack('NxN', 0xfeedface, 0xcafebabe), (string) $buffer);
	}

	public function testTooSmallBuffer() {
		$buffer = new Buffer(4);
		$buffer->writeInt32BE(0xfeedface, 0);
		$this->setExpectedException('RuntimeException');
		$buffer->writeInt32LE(0xfeedface, 4);
	}

	public function testTwo4ByteIntegers() {
		$buffer = new Buffer(8);
		$buffer->writeInt32BE(0xfeedface, 0);
		$buffer->writeInt32LE(0xfeedface, 4);
		$this->assertSame(pack('NV', 0xfeedface, 0xfeedface), (string) $buffer);
	}

	public function testWritingString() {
		$buffer = new Buffer(10);
		$buffer->writeInt32BE(0xcafebabe, 0);
		$buffer->write('please', 4);
		$this->assertSame(pack('Na6', 0xcafebabe, 'please'), (string) $buffer);
	}

	public function testTooLongIntegers() {
		$buffer = new Buffer(12);
		$this->setExpectedException('InvalidArgumentException');
		$buffer->writeInt32BE(0xfeedfacefeed, 0);
	}

	public function testLength() {
		$buffer = new Buffer(8);
		$this->assertEquals(8, $buffer->length());
	}

	public function testWriteInt8() {
		$buffer = new Buffer(1);
		$buffer->writeInt8(0xfe, 0);
		$this->assertSame(pack('c', 0xfe), (string) $buffer);
	}

	public function testWriteUInt16BE() {
		$buffer = new Buffer(2);
		$buffer->writeInt16BE(0xbabe, 0);
		$this->assertSame(pack('n', 0xbabe), (string) $buffer);
	}

	public function testWriteUInt16LE() {
		$buffer = new Buffer(2);
		$buffer->writeInt16LE(0xabeb, 0);
		$this->assertSame(pack('v', 0xabeb), (string) $buffer);
	}

	public function testWriteUInt32BE() {
		$buffer = new Buffer(4);
		$buffer->writeInt32BE(0xfeedface, 0);
		$this->assertSame(pack('N', 0xfeedface), (string) $buffer);
	}

	public function testWriteUInt32LE() {
		$buffer = new Buffer(4);
		$buffer->writeInt32LE(0xfeedface, 0);
		$this->assertSame(pack('V', 0xfeedface), (string) $buffer);
	}

}