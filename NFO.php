<?php
/**
 * NFO
 *
 * ASCII NFO-like site.
 *
 * (c) 2012, Dereckson, some rights reserved.
 * Released under BSD license.
 *
 * @filesource
 */

/**
 * NFO
 *
 * It's basically a file reader, adding a nice frame, like NFO.
 */
class NFO {
	/**
	 * The NFO file (suggested extensions: .txt or .nfo)
	 *
	 * @var string
	 */
	private $file;

	/**
	 * The line length
	 */
	public $lineLength = 0;

	/**
	 * The frame characters
	 */
	public $frame = "╔╗╚╝║═";

	/**
	 * Initializes a new NFO instnace
	 *
	 * @param string $file The NFO file
	 */
	public function __construct ($file) {
		$this->file = $file;
	}

	/**
	 * Gets the maximal line length of a file
	 *
	 * @param string $file The file to check
	 */
	public static function getMaxLineLength ($file) {
		$lines = file($file);
		$len = 0;
		foreach ($lines as $line) {
			$line_len = strlen($line);
			if ($line_len > $len) {
				$len = $line_len;
			}
		}
		return $len;
	}

	/**
	 * Raises the line length according the NFO file, to avoid overflows.
	 */
	public function raiseLineLength () {
		$len = self::getMaxLineLength($this->file);
		if ($len > $this->lineLength) {
			$this->lineLength = $len;
		}
	}

	/**
	 * Gets frame characters
	 *
	 * @return Array an array containing the 4 corners (TL TR BL BR), the vertical and the horizontal glyphes
	 */
	public function getFrame () {
		$frame = array();
		for ($i = 0 ; $i < mb_strlen($this->frame, 'UTF-8') ; $i++) {
			$frame[$i] = mb_substr($this->frame, $i, 1, 'UTF-8');
		}
		return $frame;
	}

        /**
         * Gets the NFO content, with a nice border
	 *
	 * @return string the NFO content
         */
	public function __toString () {
		$this->raiseLineLength();
		$frame = $this->getFrame();

		$text  = $frame[0] . str_repeat($frame[5], $this->lineLength + 2) . $frame[1] . "\n";
		$text .= $frame[4] . str_repeat(' ', $this->lineLength + 2) . $frame[4] . "\n";

		$lines = file($this->file);
		foreach ($lines as $line) {
			$text .=  $frame[4] . ' ';
			$text .= str_pad(rtrim($line), $this->lineLength);
			$text .= ' ' . $frame[4] . "\n";
		}

		$text .= $frame[4] . str_repeat(' ', $this->lineLength + 2) . $frame[4] . "\n";
		$text .= $frame[2] . str_repeat($frame[5], $this->lineLength + 2) . $frame[3] . "\n";

		return $text;
	}
}