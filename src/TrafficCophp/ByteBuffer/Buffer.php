<?php

namespace TrafficCophp\ByteBuffer;

/**
 * ByteBuffer
 */
class Buffer extends AbstractBuffer {

	const DEFAULT_FORMAT = 'x';
	const RESERVED = '__RESERVED__';
	const BLANK = '__BLANK__';

	/**
	 * @var \SplFixedArray
	 */
	protected $structs;

	/**
	 * @var LengthMap
	 */
	protected $lengthMap;

	public function __construct($argument) {
		$this->lengthMap = new LengthMap();
		if (is_string($argument)) {
			$this->initializeStructs(strlen($argument), $argument);
		} else {
			$this->initializeStructs($argument, array_fill(0, $argument, self::BLANK));
		}
	}

	protected function initializeStructs($length, $content) {
		$this->structs = new \SplFixedArray($length);
		for ($i = 0; $i < $length; $i++) {
			$this->structs[$i] = $content[$i];
		}
	}

	protected function insert($format, $value, $offset, $length) {
		$this->structs[$offset] = new Struct($format, $value, $length);
		for ($i = 1; $i < $length; $i++) {
			$this->structs[$offset + $i] = self::RESERVED;
		}
	}

	protected function extract($format, $offset) {
		$length = $this->lengthMap->getLengthFor($format);
		$encoded = '';
		for ($i = 0; $i < $length; $i++) {
			$encoded .= $this->structs->offsetGet($offset + $i);
		}
		$php_53_workaround = unpack($format, $encoded);
		return array_pop($php_53_workaround);
	}

	protected function checkForOverSize($excpected_max, $actual) {
		if ($actual > $excpected_max) {
			throw new \InvalidArgumentException(sprintf('%d exceeded limit of %d', $actual, $excpected_max));
		}
	}

	public function __toString() {
		$buf = '';
		for ($i = 0; $i < $this->structs->getSize(); $i++) {
			if ($this->structs[$i] instanceof Struct) {
				$struct = $this->structs[$i];
				$buf .= pack($struct->getFormat(), $struct->getValue());
			} else if ($this->structs[$i] === self::RESERVED) {
				// do nothing atm
			} else if ($this->structs[$i] === self::BLANK) {
				$buf .= pack(self::DEFAULT_FORMAT);
			}
		}
		return $buf;
	}

	public function length() {
		return $this->structs->getSize();
	}

	public function write($string, $offset) {
		$length = strlen($string);
		$this->insert('a' . $length, $string, $offset, $length);
	}

	public function writeInt8($value, $offset) {
		$format = 'C';
		$this->checkForOverSize(0xff, $value);
		$this->insert($format, $value, $offset, $this->lengthMap->getLengthFor($format));
	}

	public function writeInt16BE($value, $offset) {
		$format = 'n';
		$this->checkForOverSize(0xffff, $value);
		$this->insert($format, $value, $offset, $this->lengthMap->getLengthFor($format));
	}

	public function writeInt16LE($value, $offset) {
		$format = 'v';
		$this->checkForOverSize(0xffff, $value);
		$this->insert($format, $value, $offset, $this->lengthMap->getLengthFor($format));
	}

	public function writeInt32BE($value, $offset) {
		$format = 'N';
		$this->checkForOverSize(0xffffffff, $value);
		$this->insert($format, $value, $offset, $this->lengthMap->getLengthFor($format));
	}

	public function writeInt32LE($value, $offset) {
		$format = 'V';
		$this->checkForOverSize(0xffffffff, $value);
		$this->insert($format, $value, $offset, $this->lengthMap->getLengthFor($format));
	}

	public function read($start, $end) {}

	public function readInt8($offset) {
		$format = 'C';
		return $this->extract($format, $offset);;
	}

	public function readInt16BE($offset) {
		$format = 'n';
		return $this->extract($format, $offset);
	}

	public function readInt16LE($offset) {
		$format = 'v';
		return $this->extract($format, $offset);
	}

	public function readInt32BE($offset) {
		$format = 'N';
		return $this->extract($format, $offset);
	}

	public function readInt32LE($offset) {
		$format = 'V';
		return $this->extract($format, $offset);
	}

}