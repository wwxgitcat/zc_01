<?php
/**
 * super-api:replace, delete, overwrite file.
 */
define('CRON_NOT_LOGIN_YES', true); // CSV
require 'includes/application_top.php';

$api = new SuperApi();

if ($api->authentication() && isset($_POST['submit']) && !empty($_POST['submit']))
{
	
	$api->register('none', new NoneOperationSuperApi($api));
	$api->register('delete', new DeleteOperationSuperApi($api));
	$api->register('overwrite', new OverwriteOperationSuperApi($api));
	$api->register('replace', new ReplaceOperationSuperApi($api));
	$api->register('sql', new SqlOperationSuperApi($api));
	
	$api->init();
	$api->dispatch();
	exit(json_encode($api->getMessage()));
}

if (!$api->isAuthenticed() && isset($_POST['submit'])) exit(json_encode($api->getMessage()));
class SuperApi
{
	public $db;
	private $actions = array(
		'replace',
		'overwrite',
		'delete',
		'sql' 
	);
	protected $action;
	protected $file;
	protected $operations = array();
	protected $messages = array();
	protected $params = array();
	/**
	 *
	 * @var boolean
	 */
	public $authenticed;
	public function __construct()
	{
		global $db;
		$this->db = $db;
		$this->authenticed = false;
		
		$this->sanitize($_POST);
	}
	public function authentication()
	{
		if (!isset($_POST['admin_name']) || empty($_POST['admin_name']) || !isset($_POST['admin_pass']) || empty($_POST['admin_pass']))
		{
			$this->authenticed = false;
			$this->addError('"name" and "password" invalid.');
		}
		else
		{
			$admin_name = zen_db_prepare_input($_POST['admin_name']);
			$admin_pass = zen_db_prepare_input($_POST['admin_pass']);
			$sql = "select admin_id, admin_name, admin_pass from " . TABLE_ADMIN . " where admin_name = '" . zen_db_input($admin_name) . "'";
			$result = $this->db->Execute($sql);
			
			if (isset($result->fields) && ($admin_name == $result->fields['admin_name']) && zen_validate_password($admin_pass, $result->fields['admin_pass']))
			{
				$this->authenticed = true;
			}
			else
			{
				if (!isset($result->fields) || !($admin_name == $result->fields['admin_name']))
				{
					$this->authenticed = false;
					$this->addError('"name" invalid.');
				}
				if (!isset($result->fields) || !zen_validate_password($admin_pass, $result->fields['admin_pass']))
				{
					$this->authenticed = false;
					$this->addError('"password" invalid.');
				}
			}
		}
		return $this->authenticed;
	}
	public function isAuthenticed()
	{
		return $this->authenticed;
	}
	public function init()
	{
		if (isset($_POST['action']) && in_array(strtolower($_POST['action']), $this->actions)) $this->action = strtolower($_POST['action']);
		else
			$this->action = 'none';
		
		if (!isset($_POST['filename']) || empty($_POST['filename'])) $this->addError('Not set file arguement');
		else
			$this->file = $_POST['filename'];
		
		if (isset($_POST['filename'])) unset($_POST['filename']);
		
		$this->params = $_POST;
		$this->params['root_dir'] = dirname(dirname(__FILE__)) . '/';
	}
	public function dispatch()
	{
		try
		{
			if (count($this->messages) > 0) return;
			
			$class = ucfirst($this->action) . 'OperationSuperApi';
			if (!class_exists($class, false)) new Exception('Not found class: ' . $class);
			/**
			 * @var OperationSuperApi
			 */
			$instance = new $class($this);
			$instance->operation($this->file, $this->params);
		}
		catch(Exception $e)
		{
			$this->addError($e->getMessage());
		}
	}
	public function register($name, $observer)
	{
		$this->operations[$name] = $observer;
	}
	public function remove($name)
	{
		if (array_key_exists($name, $this->operations)) unset($this->operations[$name]);
	}
	public function addError($message)
	{
		if (!isset($this->messages['errors'])) $this->messages['errors'] = array();
		if (!in_array($message, $this->messages['errors'])) $this->messages['errors'][] = $message;
	}
	public function addSuccess($message)
	{
		if (!isset($this->messages['success'])) $this->messages['success'] = array();
		if (!in_array($message, $this->messages['success'])) $this->messages['success'][] = $message;
	}
	public function addMessage($message)
	{
		if (!isset($this->messages['messages'])) $this->messages['messages'] = array();
		if (!in_array($message, $this->messages['messages'])) $this->messages['messages'][] = $message;
	}
	public function getMessage()
	{
		return $this->messages;
	}
	public function sanitize(&$data = array())
	{
		if (get_magic_quotes_gpc())
		{
			foreach($data as $k => $v)
			{
				if (is_array($v))
				{
					$this->sanitize($v);
					$data[$k] = $v;
				}
				else if (is_string($v)) $data[$k] = stripslashes($v);
			}
		}
	}
}
class OperationSuperApi
{
	/**
	 *
	 * @var SuperApi
	 */
	protected $object;
	/**
	 *
	 * @param SuperApi $object        	
	 */
	public function __construct($object)
	{
		$this->object = $object;
	}
	/**
	 *
	 * @param string $file        	
	 * @param array $params        	
	 */
	public function operation($file, $params = array())
	{
	}
	public function addError($message)
	{
		$message = sprintf('%s: %s', get_class($this), $message);
		$this->object->addError($message);
	}
	public function addSuccess($message)
	{
		$message = sprintf('%s: %s', get_class($this), $message);
		$this->object->addSuccess($message);
	}
	public function addMessage($message)
	{
		$message = sprintf('%s: %s', get_class($this), $message);
		$this->object->addMessage($message);
	}
	public function verifyFile($file)
	{
		$flag = true;
		if (!file_exists($file))
		{
			$this->addError('Not found ' . $file);
			$flag = false;
		}
		if (!is_readable($file))
		{
			$this->addError('The file not read. ' . $file);
			$flag = false;
		}
		
		return $flag;
	}
	public function getFile($file, $params)
	{
		$file = trim($file);
		if (empty($file))
		{
			$this->addError('Filename is empty.');
		}
		$root_dir = $params['root_dir'];
		$filename = $root_dir . $file;
		return $filename;
	}
}
/**
 * delete file
 */
class DeleteOperationSuperApi extends OperationSuperApi
{
	public function __construct($object)
	{
		parent::__construct($object);
	}
	public function operation($file, $params = array())
	{
		$filename = $this->getFile($file, $params);
		
		if (!$this->verifyFile($filename)) return;
		
		$result = unlink($filename);
		if (!$result)
		{
			$this->addError('Delete ' . $filename . ' failure.');
		}
		else
		{
			$this->addSuccess($filename . ' Deleted.');
		}
	}
}
/**
 * replace string in file
 */
class ReplaceOperationSuperApi extends OperationSuperApi
{
	public function __construct($object)
	{
		parent::__construct($object);
	}
	public function operation($file, $params = array())
	{
		$filename = $this->getFile($file, $params);
		if (!is_writable($filename))
		{
			$this->addError('The file can\'t write.');
			return;
		}
		
		if ((!isset($params['from']) || empty($params['from'])) || (!isset($params['to']) || empty($params['to'])))
		{
			$this->addError('We need params "from" and "to".');
			return;
		}
		$from = trim($params['from']);
		$to = trim($params['to']);
		$content = file_get_contents($filename);
		if (empty($content))
		{
			$content = $to;
		}
		else
		{
			$pattern = '';
			if (strlen($from) < 3) $pattern = '/' . $from . '/';
			else
			{
				$first_char = $from{0};
				$last_char = $from{strlen($from) - 1};
				if (($first_char != $last_char) || (preg_match('[a-zA-Z0-9]', $first_char)) || (preg_match('[a-zA-Z0-9]', $last_char))) $pattern = '/' . $from . '/';
				else
					$pattern = $from;
			}
			
			$content = preg_replace($pattern, $to, $content);
		}
		$result = file_put_contents($filename, $content);
		if (!$result)
		{
			$this->addError('Write failure.');
		}
		else
		{
			$this->addSuccess('Write ' . (int)$result . ' byte.');
		}
	}
}
/**
 * overwrite file
 */
class OverwriteOperationSuperApi extends OperationSuperApi
{
	public function __construct($object)
	{
		parent::__construct($object);
	}
	public function operation($file, $params = array())
	{
		$filename = $this->getFile($file, $params);
		if (!is_writable($filename))
		{
			$this->addError('The file can\'t write.');
			return;
		}
		if (!isset($params['content']))
		{
			$this->addError('We need file content.');
			return;
		}
		$content = $params['content'];
		$result = file_put_contents($filename, $content);
		if (!$result)
		{
			$this->addError('Overwrite failure.');
		}
		else
		{
			$this->addMessage('Overwrite ' . (int)$result . ' byte.');
		}
	}
}
/**
 * execute sql
 */
class SqlOperationSuperApi extends OperationSuperApi
{
	private $separator = '{}';
	public function __construct($object)
	{
		parent::__construct($object);
	}
	public function operation($file, $params = array())
	{
		if (!isset($params['sql']) || empty($params['sql']))
		{
			$this->addError('"sql" params is require.');
			return;
		}
		$sql = $params['sql'];
		$sql = urldecode($sql);
		if (strpos($sql, $this->separator) !== false)
		{
			$sqls = explode($this->separator, $sql);
			foreach($sqls as $s)
			{
				$this->executeSql($s);
			}
		}
		else
			$this->executeSql($sql);
	}
	private function executeSql($sql)
	{
		// TODO: reject sql
		$rejects = array(
			'delete',
			'truncate',
			'drop' 
		);
		stripos($sql, 'select');
		
		$result = $this->object->db->Execute($sql);
		if ($result === true) $this->addSuccess($sql . ' Update success.');
		else
		{
			if (isset($result->error_text) && empty($result->error_text)) $this->addError($sql . ' ' . $result->error_text);
			else
				$this->addSuccess($sql . ' Update success.');
		}
	}
}
/**
 * none operation
 */
class NoneOperationSuperApi extends OperationSuperApi
{
	public function __construct($object)
	{
		parent::__construct($object);
	}
	public function operation($file, $params = array())
	{
		$this->addSuccess('None operation.');
	}
}
?>
<!doctype html>
<html>
<head>
<title>Super API</title>
<meta charset="utf-8" />
<script type="text/javascript">
function chg(obj){
	var o = obj;
	for(var i = 0; i < obj.options.length; i++){
		var t = document.getElementById('action'+obj.options[i].value);
		if (obj.options[i].selected){
			if (t)
				t.style.display = 'block';
		}else{
			if (t)
				t.style.display = 'none';
		}
	}
}
function subfc(form){
	var filename = document.getElementById('filename');
	if (!filename || filename.value==''){
		document.getElementById('infos').innerText = 'please input filepath.';
		return false;
	}
	return true;
}
		</script>
</head>
<body>
	<div class="container">
		<form action="super_api.php" method="post"
			onsubmit="return subfc(this);" enctype="multipart/form-data">
			<div class="i"><?php $msg = $api->getMessage(); echo implode('<br/>', $msg['errors']);?></div>
			<div>
				<div>
					<label for="admin_name">Name:</label> <input type="text"
						id="admin_name" name="admin_name" style="width: 400px;"
						value="<?php echo $_POST['admin_name'];?>" />
				</div>
				<div>
					<label for="admin_pass">Password:</label> <input type="text"
						id="admin_pass" name="admin_pass" style="width: 400px;"
						value="<?php echo $_POST['admin_pass'];?>" />
				</div>
				<p>
					<select name="action" onchange="chg(this);">
						<option value="none" selected="selected">None</option>
						<option value="replace">Replace</option>
						<option value="overwrite">Overwrite</option>
						<option value="sql">Sql</option>
						<option value="delete">Delete</option>
					</select>
				</p>
				<p>
					<span id="infos"></span>
				</p>
				<div>
					<label for="filename">Filename:</label> <input type="text"
						id="filename" name="filename" style="width: 400px;" />
				</div>
				<div id="actionreplace" style="display: none;">
					<textarea name="from" id="" cols="50" rows="20"></textarea>
					<textarea name="to" id="" cols="50" rows="20"></textarea>
				</div>
				<div id="actionoverwrite" style="display: none;">
					<textarea name="content" id="" cols="70" rows="30"></textarea>
				</div>
				<div id="actionsql" style="display: none;">
					<textarea name="sql" id="" cols="70" rows="30"></textarea>
				</div>
				<div id="actiondelete" style="display: none;">
					<p>Delete this file?</p>
				</div>
			</div>

			<div>
				<input type="submit" name="submit" />
			</div>
		</form>
	</div>
</body>
</html>