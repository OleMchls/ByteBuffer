<?php

namespace TrafficCophp\ByteBuffer;

/**
 * BufferStruct
 */
class Struct {

	protected $format;
	protected $value;
	protected $lenght;

	function __construct($format, $value, $lenght) {
		$this->format = $format;
		$this->value = $value;
		$this->lenght = $lenght;
	}

	public function getFormat() {
		return $this->format;
	}

	public function getValue() {
		return $this->value;
	}

	public function getLenght() {
		return $this->lenght;
	}

}