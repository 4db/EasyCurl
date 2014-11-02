<?php

/**
 *
 * Class EasyCurl
 * //TODO LIST:
 * -get
 * -post
 * -json
 */
class EasyCurl {
	/**
	 * @var object
	 */
	private static $_instance;

	/**
	 * @var string
	 */
	public $_url;

	/**
	 * @var curl
	 */
	public $_ch;

	/**
	 * @var array
	 */
	public $_set = array(
		CURLOPT_RETURNTRANSFER => 1
	);

	/**
	 * @var array
	 */
	public $head = array();

	/**
	 * @var string
	 */
	public $body;

	/**
	 * @var
	 */
	public $response;

	/**
	 * @var string
	 */
	public $error;

	/**
	 * @param $url
	 */
	private function __construct($url) {
		if (empty($url)) {
			echo ('Need URL');
			die();
		}
		$this->_url = $url;
	}

	private function __clone() {}

	/**
	 * @param $url
	 * @return EasyCurl|object
	 */
	public static function url($url) {
		if ( is_null( self::$_instance ) ){
			self::$_instance = new self($url);
		}
		else {
			self::$_instance->_url = $url;
		}
		return self::$_instance;
	}

	/**
	 * Set settings Curl
	 * @param array $arr
	 * @return $this
	 */
	public function set(array $arr) {
		foreach($arr as $k=>$v) {
			$this->_set[$k] = $v;
		}
		return $this;
	}

	/**
	 * Headers for Curl
	 * @param array $arr
	 * @return $this
	 */
	public function head(array $arr) {
		foreach($arr as $k=>$v) {
			$this->head[$k] = $v;
		}
		return $this;
	}

	/**
	 * Request params for Curl
	 * @param $body
	 * @return $this
	 */
	public function body($body) {
		$this->body = $body;
		return $this;
	}

	/**
	 * curl exec
	 * @return mixed
	 */
	public function exec() {
		try {
			$this->_ch = curl_init();

			if ($this->_ch === false) {
				echo ('Failed to initialize');
				die();
			}

			curl_setopt($this->_ch, CURLOPT_URL, $this->_url);

			foreach($this->_set as $option=>$value){
				curl_setopt($this->_ch, $option, $value);
			}

			if (!empty($this->head)) {
				curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $this->head);
			}

			if (!empty($this->body)) {
				curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $this->body);
			}

			$responce = curl_exec($this->_ch);

			if ($responce === false) {
				throw new Exception(curl_errno($this->_ch));
			}
			curl_close($this->_ch);
			return $responce;
		} catch(Exception $e) {
			echo $this->error = 'Curl failed with error: ' . $e->getCode() . ' ' . $e->getMessage();
			die;
		}
	}
}