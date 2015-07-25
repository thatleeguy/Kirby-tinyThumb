<?php
function tinyThumb( $image, $args ) {
	$class = new TinyThumb( $image, $args );
	return $class;
}

class TinyThumb {
	public $image				= null;
	public $thumb				= null;
	public $to_path				= null;
	public $to_name				= null;
	public $to_url				= null;

	public function __construct( $image, $args = array() ) {
		$this->image 			= $image;
		$this->thumb 			= thumb( $image, $args );
		$this->to_path 			= $this->thumb()->dir() . '/' . $this->toFilename();
		$this->to_name 			= $this->removeExtension();
		$this->to_url			= $this->toUrl();

		if( ! file_exists( $this->to_path ) ) {
			$this->compressImage();
		}
	}

	private function toFilename() {
		return $this->str_lreplace( '.', '-min.', $this->thumb->filename() );
	}

	private function toUrl() {
		return $this->str_lreplace( '.', '-min.', $this->thumb->url() );
	}

	private function str_lreplace( $search, $replace, $subject ) {
		$pos = strrpos( $subject, $search );
		if( $pos !== false ) {
			$subject = substr_replace( $subject, $replace, $pos, strlen( $search ) );
		}
		return $subject;
	}

	private function compressImage() {
		$request = curl_init();
		curl_setopt_array($request, array(
			CURLOPT_URL => "https://api.tinify.com/shrink",
			CURLOPT_USERPWD => "api:" . c::get('tinypngKey'),
			CURLOPT_POSTFIELDS => file_get_contents( $this->thumb->url() ),
			CURLOPT_BINARYTRANSFER => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => true,
			CURLOPT_CAINFO => __DIR__ . "/cacert.pem",
			CURLOPT_SSL_VERIFYPEER => true
		));

		$response = curl_exec($request);
		if (curl_getinfo($request, CURLINFO_HTTP_CODE) === 201) {
			$headers = substr($response, 0, curl_getinfo($request, CURLINFO_HEADER_SIZE));
			foreach (explode("\r\n", $headers) as $header) {
				if (strtolower(substr($header, 0, 10)) === "location: ") {
					$request = curl_init();
					curl_setopt_array($request, array(
						CURLOPT_URL => substr($header, 10),
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_CAINFO => __DIR__ . "/cacert.pem",
						CURLOPT_SSL_VERIFYPEER => true
					));
					file_put_contents($this->to_path, curl_exec($request));
				}
			}
		}
	}

	public function removeExtension() {
		$bits = explode( '.', $this->toFilename() );
		array_pop($bits);
		$name = implode( '.', $bits );
		return $name;
	}

	public function dimensions() {
		return $this->thumb->dimensions();
	}

	public function dir() {
		return $this->thumb->dir();
	}

	public function extension() {
		return $this->thumb->extension();
	}

	public function filename() {
		return $this->toFilename();
	}

	public function height() {
		return $this->thumb->height();
	}

	public function isLandscape() {
		return $this->thumb->isLandscape();
	}

	public function isPortrait() {
		return $this->thumb->isPortrait();
	}

	public function isSquare() {
		return $this->thumb->isSquare();
	}

	public function name() {
		return $this->to_name;
	}

	public function orientation() {
		return $this->thumb->orientation();
	}

	public function ratio() {
		return $this->thumb->ratio();
	}

	public function root() {
		return $this->thumb->root();
	}

	public function type() {
		return $this->thumb->type();
	}

	public function width() {
		return $this->thumb->width();
	}

	public function thumb() {
		return $this->thumb;
	}

	public function image() {
		return $this->image;
	}

	public function __toString() {
		if( file_exists( $this->to_path ) ) {
			$filename = $this->toFilename();
		} else {
			$filename = $this->thumb->filename();
		}

		return html::img( $this->to_url, array(
			'alt' => $this->thumb->name()
		));
	}
}