<?php
/**
 * Super cache html page
 * @author QQ46231996
 * @create 2015/2/12
 * @modify  2015/2/12
 */

include_once('includes/classes/minify_html.class.php');
class JSuperCache
{
	public $root_dir;
	public $identify = null;
	public $enable = false;
	public $content;
	public $level = 0;
	public function __construct()
	{
		$this->root_dir = dirname(dirname(dirname(__FILE__))).'/';
		$this->enable = true;
	}
	public function exists()
	{
		if (!$this->enable)
			return null;
		$identify = $this->getIdentify();
		if (empty($identify))
			return null;
		if (file_exists($this->root_dir.'cache/'.$identify))
			return file_get_contents($this->root_dir.'/cache/'.$identify);
		else
			return false;
	}
	public function save($content)
	{
		if (!$this->enable)
			return;
		$identify = $this->getIdentify();
		$file = $this->root_dir.'cache/'.$identify;
		if (!is_dir(dirname($file)))
			mkdir(dirname($file));
		
		if (file_exists($file))
			unlink($file);
		
		$content = Minify_HTML::minify($content);
		
		file_put_contents($file, $content);
	}
	public function getIdentify()
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
			return null;
		
		if (!empty($this->identify))
			return $this->identify;
		
		$page = isset($_GET['main_page']) ? $_GET['main_page'] : '';
		if (empty($page))
		{
			$page = 'index';
		}
		switch ($this->level)
		{
			case 0:
				break;
			case 1:
				if ($page == 'index' && (!isset($_GET['cPath']) || empty($_GET['cPath'])))
					$this->identify = 'index';
				break;
			case 2:
				if ($page == 'index')
					$this->identify = 'index';
				if (isset($_GET['cPath']) && !empty($_GET['cPath']))
				{
					$this->identify = 'category/'.$_GET['cPath'];
					if (isset($_GET['page']))
						$this->identify .= '/'.$_GET['page'];
					if (isset($_GET['sort']))
						$this->identify .= '/'.$_GET['sort'];
				}
				break;
			case 3:
				if ($page == 'index' || $page == 'product_info')
				{
					$this->identify = 'index';
					if (isset($_GET['products_id']) && (int)$_GET['products_id'] > 0)
					{
						$this->identify = 'products/'.(int)$_GET['products_id'];
					}
					else if (isset($_GET['cPath']) && !empty($_GET['cPath']))
					{
						$this->identify = 'category/'.$_GET['cPath'];
						if (isset($_GET['page']))
							$this->identify .= '/'.$_GET['page'];
						if (isset($_GET['sort']))
							$this->identify .= '/'.$_GET['sort'];
					}
				}
				break;
		}
		
		return $this->identify;
	}
	public function obStart()
	{
		
		if (!$this->enable)
			return;
		
		ob_start();
	}
	public function obGetClean()
	{
		if (!$this->enable)
			return;
		
		$this->content = ob_get_clean();
		return $this->content;
	}
	public function echoAndExit()
	{
		if (!$this->enable)
			return;
		echo $this->content;
	}
}