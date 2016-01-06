<?php
/**
 * 
 * @version 1.0
 * @author QQ46231996
 */
function get_variable_order($order_id)
{
	global $db;
	$variable = array();
	$result = $db->Execute('SELECT o.orders_id,o.customers_id, customers_name,delivery_name,billing_name,track_number
		FROM ' . TABLE_ORDERS . ' o LEFT JOIN orders_delivery d ON (o.orders_id=d.orders_id)
		WHERE o.orders_id=' . (int)$order_id);
	
	if($result->RecordCount() > 0)
	{
		$variable = get_variable_customer($result->fields['customers_id']);
		
		foreach($result->fields as $key => $value)
		{
			$variable[sprintf('{%s}', $key)] = $value;
		}
	}
	$variable['{store_name}'] = STORE_NAME;
	return $variable;
}
function get_variable_customer($customer_id)
{
	global $db;
	$variable = array();
	$result = $db->Execute('SELECT customers_id, customers_gender, customers_firstname, customers_lastname, customers_email_address, customers_nick
		,customers_telephone, customers_fax
		FROM ' . TABLE_CUSTOMERS . ' WHERE customers_id=' . (int)$customer_id);
	
	if($result->RecordCount() > 0)
	{
		foreach($result->fields as $key => $value)
		{
			$variable[sprintf('{%s}', $key)] = $value;
		}
	}
	
	$variable['{store_name}'] = STORE_NAME;
	
	return $variable;
}
function get_email_variable_description()
{
	return array(
		'orders_id'		=>	'订单编号',
		'customers_name'		=>	'客户名称',
		'delivery_name'		=>	'收货名称',
		'billing_name'		=>	'账单名称',
		'track_number'		=>	'运单号',
		'customers_firstname'		=>	'firstname',
		'customers_lastname'		=>	'lastname',
		'customers_email_address'		=>	'客户邮箱',
		'customers_telephone'		=>	'电话',
		'customers_fax'		=>	'传真',
	);
}
function get_email_template($template_id)
{
	global $db;
	$result = $db->Execute('SELECT * FROM email_template WHERE email_template_id=' . $template_id);
	return $result->fields;
}
function get_mail_random()
{
	static $mail_list;
	if($mail_list == null)
		$mail_list = get_mail_list();
	
	shuffle($mail_list);
	return $mail_list[0];
}
function get_mail_list()
{
	global $db;
	$result = $db->Execute('SELECT * FROM email_infor');
	$list = array();
	while(!$result->EOF)
	{
		$list[] = $result->fields;
		$result->MoveNext();
	}
	return $list;
}
function jsend_mail($to_name, $to_address, $email_subject, $email_text, $from_email_name, $from_email_address, $block = array(), $attachments_list = '')
{
	global $db, $messageStack, $zco_notifier;
	foreach(array( 
		$from_email_address,
		$to_address,
		$from_email_name,
		$to_name,
		$email_subject 
	) as $key => $value)
	{
		if(preg_match("/\r/i", $value) || preg_match("/\n/i", $value))
			return false;
	}
	// if no text or html-msg supplied, exit
	if(trim($email_text) == '')
		return false;
		// Parse "from" addresses for "name" <email@address.com> structure, and supply name/address info from it.
	if(preg_match("/ *([^<]*) *<([^>]*)> */i", $from_email_address, $regs))
	{
		$from_email_name = trim($regs[1]);
		$from_email_address = $regs[2];
	}
	// if email name is same as email address, use the Store Name as the senders 'Name'
	if($from_email_name == $from_email_address)
		$from_email_name = STORE_NAME;
		// loop thru multiple email recipients if more than one listed --- (esp for the admin's "Extra" emails)...
	foreach(explode(',', $to_address) as $key => $value)
	{
		if(preg_match("/ *([^<]*) *<([^>]*)> */i", $value, $regs))
		{
			$to_name = str_replace('"', '', trim($regs[1]));
			$to_email_address = $regs[2];
		}
		elseif(preg_match("/ *([^ ]*) */i", $value, $regs))
		{
			$to_email_address = trim($regs[1]);
		}
		if(!isset($to_email_address))
			$to_email_address = trim($to_address); // if not more than one, just use the main one.
				                                       // ensure the address is valid, to prevent unnecessary delivery failures
		if(!zen_validate_email($to_email_address))
		{
			@error_log(sprintf(EMAIL_SEND_FAILED . ' (failed validation)', $to_name, $to_email_address, $email_subject));
			continue;
		}
		// define some additional html message blocks available to templates, then build the html portion.
		if(!isset($block['EMAIL_TO_NAME']) || $block['EMAIL_TO_NAME'] == '')
			$block['EMAIL_TO_NAME'] = $to_name;
		if(!isset($block['EMAIL_TO_ADDRESS']) || $block['EMAIL_TO_ADDRESS'] == '')
			$block['EMAIL_TO_ADDRESS'] = $to_email_address;
		if(!isset($block['EMAIL_SUBJECT']) || $block['EMAIL_SUBJECT'] == '')
			$block['EMAIL_SUBJECT'] = $email_subject;
		if(!isset($block['EMAIL_FROM_NAME']) || $block['EMAIL_FROM_NAME'] == '')
			$block['EMAIL_FROM_NAME'] = $from_email_name;
		if(!isset($block['EMAIL_FROM_ADDRESS']) || $block['EMAIL_FROM_ADDRESS'] == '')
			$block['EMAIL_FROM_ADDRESS'] = $from_email_address;
		
		if(!is_array($block) && $block == '' || $block == 'none')
			$email_html = '';
		
		$email_text = strip_tags($email_text);
		
		// bof: body of the email clean-up
		// clean up &amp; and && from email text
		while(strstr($email_text, '&amp;&amp;'))
			$email_text = str_replace('&amp;&amp;', '&amp;', $email_text);
		while(strstr($email_text, '&amp;'))
			$email_text = str_replace('&amp;', '&', $email_text);
		while(strstr($email_text, '&&'))
			$email_text = str_replace('&&', '&', $email_text);
			// clean up currencies for text emails
		$zen_fix_currencies = preg_split("/[:,]/", CURRENCIES_TRANSLATIONS);
		$size = sizeof($zen_fix_currencies);
		for($i = 0, $n = $size; $i < $n; $i += 2)
		{
			$zen_fix_current = $zen_fix_currencies[$i];
			$zen_fix_replace = $zen_fix_currencies[$i + 1];
			if(strlen($zen_fix_current) > 0)
			{
				while(strpos($email_text, $zen_fix_current))
					$email_text = str_replace($zen_fix_current, $zen_fix_replace, $email_text);
			}
		}
		// fix double quotes
		while(strstr($email_text, '&quot;'))
			$email_text = str_replace('&quot;', '"', $email_text);
			// prevent null characters
		while(strstr($email_text, chr(0)))
			$email_text = str_replace(chr(0), ' ', $email_text);
			// fix slashes
		$text = stripslashes($email_text);
		$email_html = stripslashes($email_html);
		
		$mail = new PHPMailer();
		$lang_code = strtolower(($_SESSION['languages_code'] == '' ? 'en' : $_SESSION['languages_code']));
		$mail->SetLanguage($lang_code, DIR_FS_CATALOG . DIR_WS_CLASSES . 'support/');
		$mail->CharSet = (defined('CHARSET')) ? CHARSET : "iso-8859-1";
		$mail->Encoding = (defined('EMAIL_ENCODING_METHOD')) ? EMAIL_ENCODING_METHOD : "7bit";
		if((int)EMAIL_SYSTEM_DEBUG > 0)
			$mail->SMTPDebug = (int)EMAIL_SYSTEM_DEBUG;
		$mail->WordWrap = 76; // set word wrap to 76 characters
		                      // set proper line-endings based on switch ... important for windows vs linux hosts:
		$mail->LE = (EMAIL_LINEFEED == 'CRLF') ? "\r\n" : "\n";
		switch(EMAIL_TRANSPORT)
		{
			case 'smtp':
				$mail->IsSMTP();
				$mail->Host = trim($block['smtp_addr']);
				if($block['smtp_port'] != '25' && $block['smtp_port'] != '')
					$mail->Port = trim($block['smtp_port']);
				$mail->LE = "\r\n";
				break;
			case 'smtpauth':
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->Username = (zen_not_null($block['smtp_user'])) ? trim($block['smtp_user']) : EMAIL_FROM;
				$mail->Password = trim($block['smtp_pwd']);
				$mail->Host = trim($block['smtp_addr']);
				if($block['smtp_port'] != '25' && $block['smtp_port'] != '')
					$mail->Port = trim($block['smtp_port']);
				$mail->LE = "\r\n";
				// set encryption protocol to allow support for Gmail or other secured email protocols
				if($block['smtp_port'] == '465' || $block['smtp_port'] == '587' || $block['smtp_addr'] == 'smtp.gmail.com')
					$mail->Protocol = 'ssl';
				if(defined('SMTPAUTH_EMAIL_PROTOCOL') && SMTPAUTH_EMAIL_PROTOCOL != 'none')
				{
					$mail->Protocol = SMTPAUTH_EMAIL_PROTOCOL;
					if(SMTPAUTH_EMAIL_PROTOCOL == 'starttls' && defined('SMTPAUTH_EMAIL_CERTIFICATE_CONTEXT'))
					{
						$mail->Starttls = true;
						$mail->Context = SMTPAUTH_EMAIL_CERTIFICATE_CONTEXT;
					}
				}
				break;
			case 'PHP':
				$mail->IsMail();
				break;
			case 'Qmail':
				$mail->IsQmail();
				break;
			case 'sendmail':
			case 'sendmail-f':
				$mail->LE = "\n";
			default:
				$mail->IsSendmail();
				if(defined('EMAIL_SENDMAIL_PATH'))
					$mail->Sendmail = trim(EMAIL_SENDMAIL_PATH);
				break;
		}
		$mail->Subject = $email_subject;
		$mail->From = $from_email_address;
		$mail->FromName = $from_email_name;
		$mail->AddAddress($to_email_address, $to_name);
		// $mail->AddAddress($to_email_address); // (alternate format if no name, since name is optional)
		// $mail->AddBCC(STORE_OWNER_EMAIL_ADDRESS, STORE_NAME);
		// set the reply-to address. If none set yet, then use Store's default email name/address.
		// If sending from contact-us or tell-a-friend page, use the supplied info
		$email_reply_to_address = (isset($email_reply_to_address) && $email_reply_to_address != '') ? $email_reply_to_address : (in_array($module, array( 
			'contact_us',
			'tell_a_friend' 
		)) ? $from_email_address : EMAIL_FROM);
		$email_reply_to_name = (isset($email_reply_to_name) && $email_reply_to_name != '') ? $email_reply_to_name : (in_array($module, array( 
			'contact_us',
			'tell_a_friend' 
		)) ? $from_email_name : STORE_NAME);
		$mail->AddReplyTo($email_reply_to_address, $email_reply_to_name);
		// if mailserver requires that all outgoing mail must go "from" an email address matching domain on server, set it to store address
		if(EMAIL_SEND_MUST_BE_STORE == 'Yes')
			$mail->From = EMAIL_FROM;
		if(EMAIL_TRANSPORT == 'sendmail-f' || EMAIL_SEND_MUST_BE_STORE == 'Yes')
		{
			$mail->Sender = EMAIL_FROM;
		}
		if(EMAIL_USE_HTML == 'true')
			$email_html = processEmbeddedImages($email_html, $mail);
			// PROCESS FILE ATTACHMENTS
		if($attachments_list == '')
			$attachments_list = array();
		if(is_string($attachments_list))
		{
			if(file_exists($attachments_list))
			{
				$attachments_list = array( 
					array( 
						'file' => $attachments_list 
					) 
				);
			}
			elseif(file_exists(DIR_FS_CATALOG . $attachments_list))
			{
				$attachments_list = array( 
					array( 
						'file' => DIR_FS_CATALOG . $attachments_list 
					) 
				);
			}
			else
			{
				$attachments_list = array();
			}
		}
		global $newAttachmentsList;
		$zco_notifier->notify('NOTIFY_EMAIL_BEFORE_PROCESS_ATTACHMENTS', array( 
			'attachments' => $attachments_list,
			'module' => '' 
		));
		if(isset($newAttachmentsList) && is_array($newAttachmentsList))
			$attachments_list = $newAttachmentsList;
		if(defined('EMAIL_ATTACHMENTS_ENABLED') && EMAIL_ATTACHMENTS_ENABLED && is_array($attachments_list) && sizeof($attachments_list) > 0)
		{
			foreach($attachments_list as $key => $val)
			{
				$fname = (isset($val['name']) ? $val['name'] : null);
				$mimeType = (isset($val['mime_type']) && $val['mime_type'] != '' && $val['mime_type'] != 'application/octet-stream') ? $val['mime_type'] : '';
				switch(true)
				{
					case (isset($val['raw_data']) && $val['raw_data'] != ''):
						$fdata = $val['raw_data'];
						if($mimeType != '')
						{
							$mail->AddStringAttachment($fdata, $fname, "base64", $mimeType);
						}
						else
						{
							$mail->AddStringAttachment($fdata, $fname);
						}
						break;
					case (isset($val['file']) && file_exists($val['file'])): // 'file' portion must contain the full path to the file to be attached
						$fdata = $val['file'];
						if($mimeType != '')
						{
							$mail->AddAttachment($fdata, $fname, "base64", $mimeType);
						}
						else
						{
							$mail->AddAttachment($fdata, $fname);
						}
						break;
				} // end switch
			} // end foreach attachments_list
		} // endif attachments_enabled
		
		
		$mail->Body = $text; // text-only content of message
		
		$oldVars = array();
		$tmpVars = array( 
			'REMOTE_ADDR',
			'HTTP_X_FORWARDED_FOR',
			'PHP_SELF',
			'SERVER_NAME' 
		);
		foreach($tmpVars as $key)
		{
			if(isset($_SERVER[$key]))
			{
				$oldVars[$key] = $_SERVER[$key];
				$_SERVER[$key] = '';
			}
			if($key == 'REMOTE_ADDR')
				$_SERVER[$key] = HTTP_SERVER;
			if($key == 'PHP_SELF')
				$_SERVER[$key] = '/obf' . 'us' . 'cated';
		}
		/**
		 * Send the email.
		 * If an error occurs, trap it and display it in the messageStack
		 */
		$ErrorInfo = '';
		$zco_notifier->notify('NOTIFY_EMAIL_READY_TO_SEND', $mail);
		if(!($result = $mail->Send()))
		{
			if(IS_ADMIN_FLAG === true)
			{
				$messageStack->add_session(sprintf(EMAIL_SEND_FAILED . '&nbsp;' . $mail->ErrorInfo, $to_name, $to_email_address, $email_subject), 'error');
			}
			else
			{
				$messageStack->add('header', sprintf(EMAIL_SEND_FAILED . '&nbsp;' . $mail->ErrorInfo, $to_name, $to_email_address, $email_subject), 'error');
			}
			$ErrorInfo .= ($mail->ErrorInfo != '') ? $mail->ErrorInfo . '<br />' : '';
		}
		$zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND');
		foreach($oldVars as $key => $val)
		{
			$_SERVER[$key] = $val;
		}
		$zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND_WITH_ALL_PARAMS', array( 
			$to_name,
			$to_email_address,
			$from_email_name,
			$from_email_address,
			$email_subject,
			$email_html,
			$text,
			$ErrorInfo 
		));
		// Archive this message to storage log
		// don't archive pwd-resets and CC numbers
		if(EMAIL_ARCHIVE == 'true')
		{
			zen_mail_archive_write($to_name, $to_email_address, $from_email_name, $from_email_address, $email_subject, $email_html, $text, $module, $ErrorInfo);
		} // endif archiving
	} // end foreach loop thru possible multiple email addresses
	$zco_notifier->notify('NOTIFY_EMAIL_AFTER_SEND_ALL_SPECIFIED_ADDRESSES');
// 	if(EMAIL_FRIENDLY_ERRORS == 'false' && $ErrorInfo != '')
// 		die('<br /><br />Email Error: ' . $ErrorInfo);
	return $ErrorInfo;
}
