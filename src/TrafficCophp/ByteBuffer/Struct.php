<?php

namespace TrafficCophp\ByteBuffer;

/**
 * BufferStruct
 */
class Struct {

	protected $format;
	protected $value;
	protected $length;

	function __construct($format, $value, $length) {
		$this->format = $format;
		$this->value = $value;
		$this->length = $length;
	}

	public function getFormat() {
		return $this->format;
	}

	public function getValue() {
		return $this->value;
	}

	public function getLength() {
		return $this->length;
	}

}