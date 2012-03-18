<?php

namespace TrafficCophp\ByteBuffer;

/**
 * LenghtMap
 */
class LenghtMap {

	protected $map;

	public function __construct() {
		$this->map = array(
			'n' => 2,
			'N' => 4,
			'v' => 2,
			'V' => 4,
			'c' => 1,
			'C' => 1
		);
	}

	public function getLenghtFor($format) {
		return $this->map[$format];
	}

}