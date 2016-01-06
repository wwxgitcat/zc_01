<?php
/**
 * manager cookie
 * @author JunsChen
 * @copyright JunsGo@gmail.com
 */
require_once ('blowfish.php');
class Cookie
{
	private $_key = 'RGDgDu3XLa0gP72xiIBjNEDYpCrCD3M0uufczJ9UdZA27gcX0Ck4cftz';
	private $_iv = 'frM2P8eF';
	private $_cipherTool;
	private $_name;
	private $_content;
	private $_expire;
	private $_modified = false;
	private $_path;
	private $_domain;
	public function __construct($name = '', $path = '/')
	{
		global $current_domain;
		// initialize cookie field
		if (empty($name))
			$name = HTTP_SERVER.DIR_WS_CATALOG;
		$this->_name = md5($name);
		$this->_content = array();
		$this->_expire = time() + 31104000;
		$this->_path = $path;
		
		$host = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);
		
		$this->_domain = (zen_not_null($current_domain) ? $current_domain : '');
		$this->_cipherTool = new Blowfish($this->_key, $this->_iv);
		
		$this->update();
	}
	/**
	 * Magic method wich add data into _content array
	 *
	 * @param $key key
	 *        	desired
	 * @param $value value
	 *        	corresponding to the key
	 */
	public function __set($key, $value)
	{
		if (is_array($value)) die('value is array');
		if (preg_match('/¤|\|/', $key . $value)) throw new Exception('Forbidden chars in cookie');
		if (!$this->_modified && (!isset($this->_content[$key]) || (isset($this->_content[$key]) && $this->_content[$key] != $value))) $this->_modified = true;
		$this->_content[$key] = $value;
	}
	/**
	 * Magic method wich return cookie data from _content array
	 *
	 * @param $key key
	 *        	wanted
	 * @return string value corresponding to the key
	 */
	public function __get($key)
	{
		return isset($this->_content[$key]) ? $this->_content[$key] : false;
	}
	/**
	 * Magic method which check if key exists in the cookie
	 *
	 * @param $key key
	 *        	wanted
	 * @return boolean key existence
	 */
	public function __isset($key)
	{
		return isset($this->_content[$key]);
	}
	
	/**
	 * Magic method wich delete data into _content array
	 *
	 * @param $key key
	 *        	wanted
	 */
	public function __unset($key)
	{
		if (isset($this->_content[$key])) $this->_modified = true;
		unset($this->_content[$key]);
	}
	
	/**
	 * Get cookie content
	 */
	public function update($nullValues = false)
	{
		if (isset($_COOKIE[$this->_name]))
		{
			/* Decrypt cookie content */
			$content = $this->_cipherTool->decrypt($_COOKIE[$this->_name]);
			// printf("\$content = %s<br />", $content);
			
			/* Get cookie checksum */
			$checksum = crc32($this->_iv . substr($content, 0, strrpos($content, '¤') + 2));
			// printf("\$checksum = %s<br />", $checksum);
			
			/* Unserialize cookie content */
			$tmpTab = explode('¤', $content);
			foreach($tmpTab as $keyAndValue)
			{
				$tmpTab2 = explode('|', $keyAndValue);
				if (count($tmpTab2) == 2) $this->_content[$tmpTab2[0]] = $tmpTab2[1];
			}
			/* Blowfish fix */
			if (isset($this->_content['checksum'])) $this->_content['checksum'] = (int)($this->_content['checksum']);
			// printf("\$this->_content['checksum'] = %s<br />", $this->_content['checksum']);
			// die();
			/* Check if cookie has not been modified */
			
			if (!isset($this->_content['date_add'])) $this->_content['date_add'] = date('Y-m-d H:i:s');
		}
		else
			$this->_content['date_add'] = date('Y-m-d H:i:s');
	}
	
	/**
	 * Save cookie with setcookie()
	 */
	public function write()
	{
		if (/*!$this->_modified || */headers_sent()) return;
		
		$cookie = '';
		
		/* Serialize cookie content */
		if (isset($this->_content['checksum'])) unset($this->_content['checksum']);
		foreach($this->_content as $key => $value)
			$cookie .= $key . '|' . $value . '¤';
			
			/* Add checksum to cookie */
		$cookie .= 'checksum|' . crc32($this->_iv . $cookie);
		$this->_modified = false;
		/* Cookies are encrypted for evident security reasons */
		return $this->_setcookie($cookie);
	}
	
	/**
	 * Setcookie according to php version
	 */
	protected function _setcookie($cookie = null)
	{
		if ($cookie)
		{
			$content = $this->_cipherTool->encrypt($cookie);
			$time = $this->_expire;
		}
		else
		{
			$content = 0;
			$time = 1;
		}
		if (PHP_VERSION_ID <= 50200) /* PHP version > 5.2.0 */
			return setcookie($this->_name, $content, $time, $this->_path, $this->_domain, 0);
		else
			return setcookie($this->_name, $content, $time, $this->_path, $this->_domain, 0, true);
	}
	public function __destruct()
	{
		$this->write();
	}
}

?>