<?php
/**
 * 
 * @author JunsChen Junsgo@msn.com
 * @copyright Junsgo@msn.com
 * @version 0.1.2
 */
class UnionManager
{
	public $url;
	public $host;
	public $anthor; // website builder
	public $date_add;
	public $total; // product total
	public $total_enable; // product total enable
	public $email;
	public $last_customer_id; // just new customer
	public $last_order_id; //
	public $last_new_total; //
	public $cache_file = 'data.cache';
	public $cache_expire = 300;
	
	/**
	 *
	 * @var UnionCustomer[]
	 */
	public $customers = array();
	public function __construct()
	{
		$this->url = HTTP_SERVER . DIR_WS_HTTPS_ADMIN . 'union_manager.php';
		$this->host = trim(strstr(HTTPS_SERVER, '://'), ':/');
		$this->email = EMAIL_FROM;
		$this->date_add = date('Y-m-d H:i:s');
	}
	/**
	 * result new customer and order detail
	 */
	public function getNewsCustomerDetail()
	{
		$last_customer_id = isset($_GET['last_customer_id']) ? (int)$_GET['last_customer_id'] : 0;
		$last_order_id = isset($_GET['last_order_id']) ? (int)$_GET['last_order_id'] : 0;
		$manager = $this->getCustomerDetail($last_customer_id, $last_order_id, 0, 0);
		
		if ($manager->total == 0) return '';
		
		$serialize = json_encode($manager);
		return $serialize;
	}
	public function getCustomerDetail($last_customer_id = 0, $last_order_id = 0, $start = 0, $end = 10)
	{
		global $db;
		$sql = 'SELECT c.`customers_id`,
c.`customers_firstname`,
c.`customers_lastname`,
c.`customers_email_address`,
c.`customers_gender`,
c.`customers_telephone`,
c.`customers_fax`,
c.`customers_dob` AS `customers_birthday`,

ci.`customers_info_date_account_created` AS `customers_date_add`,
ci.`customers_info_date_of_last_logon` AS `customers_date_last_logon`,
ci.`customers_info_date_account_last_modified` AS `date_last_modified`,
ci.`customers_info_number_of_logons` AS `customers_logon_count`,

cf.`customers_follow` AS `follow_id`,
cf.`orders_id` AS `follow_orders_id`,
cf.`active` AS `follow_active`,
cf.`identify` AS `follow_identify`,
cf.`sended` AS `follow_sended`,
cf.`sended_date` AS `follow_sended_date`,
cf.`from_count` AS `follow_from_count`,
cf.`referer` AS `follow_referer`,
cf.`keyword` AS `follow_keyword`,
cf.`user_agent` AS `follow_user_agent`,
cf.`date_add` AS `follow_date_add`,
cf.`date_upd` AS `follow_date_upd`,

ab.`address_book_id`,
ab.`entry_firstname`,
ab.`entry_lastname`,
ab.`entry_gender`,
ab.`entry_company`,
ab.`entry_state`,
ab.`entry_city`,
ab.`entry_street_address`,
ab.`entry_suburb`,
ab.`entry_postcode`,

ct.`countries_id`,
ct.`countries_name`,
ct.`countries_iso_code_3` AS `countries_iso`,

z.`zone_id`,
z.`zone_country_id`,
z.`zone_code`,
z.`zone_name`,

o.`orders_id` AS `o_orders_id`,
o.`customers_name` AS `o_customers_name`,
o.`customers_company` AS `o_customers_company`,
o.`customers_telephone` AS `o_customers_phone`,
o.`customers_email_address` AS `o_customers_email`,
o.`customers_country` AS `o_customers_country`,
o.`customers_state` AS `o_customers_state`,
o.`customers_city` AS `o_customers_city`,
o.`customers_street_address` AS `o_customers_street`,
o.`customers_suburb` AS `o_customers_suburb`,
o.`customers_postcode` AS `o_customers_postcode`,

o.`delivery_name` AS `o_delivery_name`,
o.`delivery_company` AS `o_delivery_company`,
o.`delivery_country` AS `o_delivery_country`,
o.`delivery_state` AS `o_delivery_state`,
o.`delivery_city` AS `o_delivery_city`,
o.`delivery_street_address` AS `o_delivery_street`,
o.`delivery_suburb` AS `o_delivery_suburb`,
o.`delivery_postcode` AS `o_delivery_postcode`,

o.`billing_name` AS `o_billing_name`,
o.`billing_company` AS `o_billing_company`,
o.`billing_country` AS `o_billing_country`,
o.`billing_state` AS `o_billing_state`,
o.`billing_city` AS `o_billing_city`,
o.`billing_street_address` AS `o_billing_street`,
o.`billing_suburb` AS `o_billing_suburb`,
o.`billing_postcode` AS `o_billing_postcode`,

o.`payment_method` AS `o_payment_method`,
o.`payment_module_code` AS `o_payment_module_code`,
o.`shipping_method` AS `o_shipping_method`,
o.`shipping_module_code` AS `o_shipping_module_code`,
o.`coupon_code` AS `o_coupon_code`,
o.`date_purchased` AS `o_date_add`,
o.`last_modified` AS `o_date_modified`,
o.`currency` AS `o_currency`,
o.`currency_value` AS `o_currency_value`,
ROUND(o.`order_total`) AS `o_total`,
o.`order_tax` AS `o_tax`,
o.`ip_address` AS `o_ip`,


os.`orders_status_id`,
os.`orders_status_name` AS `o_status_name`,

op.`orders_products_id`,
op.`orders_id` AS `op_orders_id`,
op.`products_id`,
op.`products_model`,
op.`products_name`,
op.`products_price`,
op.`final_price`,
op.`products_tax`,
op.`products_quantity`,
op.`product_is_free`,

opa.`orders_products_attributes_id`,
opa.`products_options`,
opa.`products_options_values`,
opa.`options_values_price`,
opa.`price_prefix`,
opa.`product_attribute_is_free`
FROM `' . TABLE_CUSTOMERS . '` c
LEFT JOIN `' . TABLE_CUSTOMERS_INFO . '` ci ON (c.`customers_id` = ci.`customers_info_id`)
LEFT JOIN `' . TABLE_CUSTOMERS_FOLLOW . '` cf ON (c.`customers_id` = cf.`customers_id`)
LEFT JOIN `' . TABLE_ADDRESS_BOOK . '` ab ON (c.`customers_id` = ab.`customers_id`)
LEFT JOIN `' . TABLE_COUNTRIES . '` ct ON (ab.`entry_country_id` = ct.`countries_id`)
LEFT JOIN `' . TABLE_ZONES . '` z ON (ab.`entry_zone_id` = z.`zone_id`)
LEFT JOIN `' . TABLE_ORDERS . '` o ON (o.`customers_id` = c.`customers_id`)
LEFT JOIN `' . TABLE_ORDERS_STATUS . '` os ON (o.`orders_status` = os.`orders_status_id` AND os.`language_id` = 3)
LEFT JOIN `' . TABLE_ORDERS_PRODUCTS . '` op ON (op.`orders_id` = o.`orders_id`)
LEFT JOIN `' . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . '` opa ON (opa.`orders_id` = o.`orders_id` AND opa.`orders_products_id` = op.`products_id`)';
		
		$where = array();
		if ($last_customer_id > 0) $where[] = 'c.`customers_id` >' . (int)$last_customer_id;
		if ($last_order_id > 0) $where[] = 'o.`orders_id` >' . (int)$last_order_id;
		if (count($where) > 0)
		{
			$where = ' WHERE (' . implode(' OR ', $where) . ')';
			$sql .= $where;
		}
		
		$sql .= '
ORDER BY c.`customers_id` DESC, o.`orders_id` DESC
';
		// just show 180day
		if ($end > $start) $sql .= 'LIMIT ' . (int)$start . ', ' . (int)$end;
		
		$result = $db->Execute($sql, false, true, 3600);
		// all data
		$customer = null;
		$order = null;
		$address = null;
		$product = null;
		$attribute = null;
		while(!$result->EOF)
		{
			$customer_id = (int)$result->fields['customers_id'];
			$order_id = (int)$result->fields['o_orders_id'];
			$address_id = (int)$result->fields['address_book_id'];
			$countries_id = (int)$result->fields['countries_id'];
			$zone_id = (int)$result->fields['zone_id'];
			$product_id = (int)$result->fields['products_id'];
			$follow_id = (int)$result->fields['follow_id'];
			$attribute_id = (int)$result->fields['orders_products_attributes_id'];
			if ($customer_id > $this->last_customer_id) $this->last_customer_id = $customer_id;
			if ($order_id > $this->last_order_id) $this->last_order_id = $order_id;
			
			if (isset($this->customers[$customer_id])) $customer = $this->customers[$customer_id];
			else
			{
				$customer = $this->addCustomer($result);
				$this->customers[$customer_id] = $customer;
			}
			
			if ($address_id > 0)
			{
				if (isset($customer->addresses[$address_id])) $address = $customer->addresses[$address_id];
				else
				{
					$address = $this->addAddress($result);
					$customer->addresses[$address_id] = $address;
				}
			}
			
			if ($order_id > 0)
			{
				if (isset($customer->orders[$order_id])) $order = $customer->orders[$order_id];
				else
				{
					$order = $this->addOrder($result);
					$customer->orders[$order_id] = $order;
				}
			}
			
			if ($product_id > 0)
			{
				if (isset($order->products[$product_id])) $product = $order->products[$product_id];
				else
				{
					$product = $this->addProduct($result);
					$order->products[$product_id] = $product;
				}
			}
			
			if ($attribute_id > 0)
			{
				if (isset($product->attributes[$attribute_id])) $attribute = $product->attributes[$address_id];
				else
				{
					$attribute = $this->addAttribute($result);
					$product->attributes[$address_id] = $attribute;
				}
			}
			$result->MoveNext();
		}
		
		$this->total = count($this->customers);
		$this->last_new_total = count($this->customers);
		return $this;
	}
	public function getAll()
	{
		$manager = $this->getCache();
		if ($manager == null)
		{
			$manager = $this->getCustomerDetail(0, 0, 0, 0);
			$manager = $this->writeCache($manager);
		}
		
		return $manager;
	}
	private function getCacheName($start, $end)
	{
	}
	private function getCache()
	{
		$manager = null;
		$dir = realpath(dirname(__FILE__)) . '/';
		$cache = $dir . $this->cache_file;
		if (!file_exists($cache) || filesize($cache) < 512 || time() - filemtime($cache) > $this->cache_expire) return null;
		else
			$manager = file_get_contents($cache);
		return $manager;
	}
	private function writeCache($manager)
	{
		// include_once('json.php');
		// $pear_json = new Services_JSON();
		$dir = realpath(dirname(__FILE__)) . '/';
		$cache = $dir . $this->cache_file;
		$ser = json_encode($manager);
		// if (!file_exists($cache) || filesize($cache) < 512 || time()-filemtime($cache) > $this->cache_expire)
		// if (is_writeable($cache))
		// file_put_contents($cache, $ser);
		// else
		// return false;
		file_put_contents($cache, $ser);
		return $ser;
	}
	/**
	 *
	 * @param $data queryFactoryResult        	
	 * @return UnionCustomer
	 */
	private function addCustomer(&$data)
	{
		$customer = new UnionCustomer();
		$customer->id = $data->fields['customers_id'];
		$customer->firstname = $data->fields['customers_firstname'];
		$customer->lastname = $data->fields['customers_lastname'];
		$customer->email = $data->fields['customers_email_address'];
		$customer->gender = $data->fields['customers_gender'];
		$customer->phone = $data->fields['customers_telephone'];
		$customer->fax = $data->fields['customers_fax'];
		$customer->date_birthday = $data->fields['customers_birthday'];
		$customer->date_add = $data->fields['customers_date_add'];
		$customer->date_last_logon = $data->fields['customers_date_last_logon'];
		$customer->date_last_modified = $data->fields['date_last_modified'];
		$customer->logon_count = $data->fields['customers_logon_count'];
		
		$customer->follow_id = $data->fields['follow_id'];
		$customer->follow_order_id = $data->fields['follow_orders_id'];
		$customer->active = $data->fields['follow_active'];
		$customer->identify = $data->fields['follow_identify'];
		$customer->sended = $data->fields['follow_sended'];
		$customer->date_sended = $data->fields['follow_sended_date'];
		$customer->from_count = $data->fields['follow_from_count'];
		$customer->referer = $data->fields['follow_referer'];
		$customer->keyword = $data->fields['follow_keyword'];
		$customer->user_agent = $data->fields['follow_user_agent'];
		
		return $customer;
	}
	/**
	 *
	 * @param $data queryFactoryResult        	
	 * @return UnionOrder
	 */
	private function addOrder(&$data)
	{
		$order = new UnionOrder();
		$order->id = $data->fields['o_orders_id'];
		$order->name = $data->fields['o_customers_name'];
		$order->company = $data->fields['o_customers_company'];
		$order->phone = $data->fields['o_customers_phone'];
		$order->email = $data->fields['o_customers_email'];
		$order->country = $data->fields['o_customers_country'];
		$order->state = $data->fields['o_customers_state'];
		$order->city = $data->fields['o_customers_city'];
		$order->street = $data->fields['o_customers_street'];
		$order->street_sub = $data->fields['o_customers_suburb'];
		$order->zipcode = $data->fields['o_customers_postcode'];
		
		$order->delivery_name = $data->fields['o_delivery_name'];
		$order->delivery_company = $data->fields['o_delivery_company'];
		$order->delivery_country = $data->fields['o_delivery_country'];
		$order->delivery_state = $data->fields['o_delivery_state'];
		$order->delivery_city = $data->fields['o_delivery_city'];
		$order->delivery_street = $data->fields['o_delivery_street'];
		$order->delivery_street_sub = $data->fields['o_delivery_suburb'];
		$order->delivery_zipcode = $data->fields['o_delivery_postcode'];
		
		$order->billing_name = $data->fields['o_billing_name'];
		$order->billing_company = $data->fields['o_billing_company'];
		$order->billing_country = $data->fields['o_billing_country'];
		$order->billing_state = $data->fields['o_billing_state'];
		$order->billing_city = $data->fields['o_billing_city'];
		$order->billing_street = $data->fields['o_billing_street'];
		$order->billing_street_sub = $data->fields['o_billing_suburb'];
		$order->billing_zipcode = $data->fields['o_billing_postcode'];
		
		$order->payment_method = $data->fields['o_payment_method'];
		$order->payment_module_code = $data->fields['o_payment_module_code'];
		$order->shipping_method = $data->fields['o_shipping_method'];
		$order->shipping_module_code = $data->fields['o_shipping_module_code'];
		$order->coupon_code = $data->fields['o_coupon_code'];
		$order->date_add = $data->fields['o_date_add'];
		$order->date_modified = $data->fields['o_date_modified'];
		$order->currency = $data->fields['o_currency'];
		$order->currency_value = $data->fields['o_currency_value'];
		
		$order->total = $data->fields['o_total'];
		$order->tax = $data->fields['o_tax'];
		$order->ip = $data->fields['o_ip'];
		$order->gift_message = ''; // fix: 1.5 not gift_message
		
		$order->status = $data->fields['o_status_name'];
		$order->message = '';
		
		return $order;
	}
	/**
	 *
	 * @param $data queryFactoryResult        	
	 * @return UnionAddress
	 */
	private function addAddress(&$data)
	{
		$address = new UnionAddress();
		$address->id = $data->fields['address_book_id'];
		$address->firstname = $data->fields['entry_firstname'];
		$address->lastname = $data->fields['entry_lastname'];
		$address->gender = $data->fields['entry_gender'];
		$address->company = $data->fields['entry_company'];
		$address->country = $data->fields['countries_name'];
		$address->country_iso = $data->fields['countries_iso'];
		$address->city = $data->fields['entry_city'];
		$address->zone = $data->fields['zone_name'];
		$address->zone_code = $data->fields['zone_code'];
		$address->state = $data->fields['entry_state'];
		$address->street = $data->fields['entry_street_address'];
		$address->street_sub = $data->fields['entry_suburb'];
		$address->zipcode = $data->fields['entry_postcode'];
		
		return $address;
	}
	/**
	 *
	 * @param $data queryFactoryResult        	
	 * @return UnionProduct
	 */
	private function addProduct(&$data)
	{
		$product = new UnionProduct();
		$product->id = $data->fields['products_id'];
		$product->item_number = $data->fields['products_model'];
		$product->name = $data->fields['products_name'];
		$product->price = $data->fields['products_price'];
		$product->final_price = $data->fields['final_price'];
		$product->tax = $data->fields['products_tax'];
		$product->quantity = $data->fields['products_quantity'];
		$product->is_free = $data->fields['product_is_free'];
		
		return $product;
	}
	/**
	 *
	 * @param $data queryFactoryResult        	
	 * @return UnionAttribute
	 */
	private function addAttribute(&$data)
	{
		$attribute = new UnionAttribute();
		$attribute->id = $data->fields['orders_products_attributes_id'];
		$attribute->option = $data->fields['products_options'];
		$attribute->value = $data->fields['products_options_values'];
		$attribute->price = $data->fields['options_values_price'];
		$attribute->prefix = $data->fields['price_prefix'];
		$attribute->is_free = $data->fields['product_attribute_is_free'];
		
		$attribute->order_id = $data->fields['op_orders_id'];
		$attribute->product_id = $data->fields['products_id'];
		
		return $attribute;
	}
}
class UnionOrder
{
	public $id;
	public $customers_id;
	public $name;
	public $company;
	public $street;
	public $street_sub;
	public $city;
	public $zipcode;
	public $state;
	public $country;
	public $phone;
	public $email;
	public $coupon_code;
	public $date_add;
	public $date_modified;
	public $status; // text
	public $currency;
	public $currency_value;
	public $total;
	public $tax;
	public $ip;
	public $gift_message;
	
	/* delivery */
	public $delivery_name;
	public $delivery_company;
	public $delivery_street;
	public $delivery_street_sub;
	public $delivery_city;
	public $delivery_zipcode;
	public $delivery_state;
	public $delivery_country;
	/* billing */
	public $billing_name;
	public $billing_company;
	public $billing_street;
	public $billing_street_sub;
	public $billing_city;
	public $billing_zipcode;
	public $billing_state;
	public $billing_country;
	/* shipping */
	public $shipping_method;
	public $shipping_module_code;
	/* payment */
	public $payment_method;
	public $payment_module_code;
	public $message;
	
	/**
	 *
	 * @var UnionProduct[]
	 */
	public $products = array();
	public function __construct()
	{
	}
}
class UnionCustomer
{
	public $id;
	public $firstname;
	public $lastname;
	public $email;
	public $gender;
	public $phone;
	public $fax;
	public $date_birthday;
	/* customers_info */
	public $date_add;
	public $date_last_logon;
	public $date_last_modified;
	public $logon_count;
	public $follow_id;
	public $follow_order_id;
	public $active; // is normal customer
	public $sended; // create order and normal customer
	public $date_sended; // order email send date
	public $identify; // customer identify
	public $from_count;
	public $referer; //
	public $user_agent;
	public $keyword;
	/**
	 *
	 * @var UnionOrder[]
	 */
	public $orders = array();
	/**
	 *
	 * @var UnionAddress[]
	 */
	public $addresses = array();
	public function __construct()
	{
	}
}
/**
 * product
 * is ordered product
 */
class UnionProduct
{
	public $id;
	public $name;
	public $item_number;
	public $price;
	public $final_price;
	public $tax;
	public $quantity;
	public $is_free;
	/**
	 *
	 * @var UnionAttribute[]
	 */
	public $attributes = array();
	public function __construct()
	{
	}
}
/**
 * is ordered product attribute
 */
class UnionAttribute
{
	public $id;
	public $order_id;
	public $product_id;
	public $option;
	public $value;
	public $price;
	public $prefix;
	public $is_free;
	public function __construct()
	{
	}
}
/**
 * customer addresses
 */
class UnionAddress
{
	public $id;
	public $gender;
	public $firstname;
	public $lastname;
	public $company;
	public $street;
	public $street_sub;
	public $zipcode;
	public $city;
	public $state;
	public $country;
	public $country_iso;
	public $zone;
	public $zone_code;
	public function __construct()
	{
	}
}

?>