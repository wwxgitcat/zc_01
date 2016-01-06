<?php if(!isset($_POST['gateway_url']) || empty($_POST['gateway_url'])) header("Location:index.php");?>
<div id="aboutUs">
    <h1 id="aboutUsHeading">&nbsp;<?php echo HEADING_TITLE; ?></h1>
    <div id="aboutUsMainContent">
        <?php
        require($define_page);
        ?>
        <table cellpadding="3" cellspacing="0" width="100%">
            <tr>
                <td width="15%" style="text-align:left; font-weight:bold;font-size:13px"><?php echo TABLE_HEADING_QUANTITY; ?></td>
                <td width="70%" style="text-align:left; font-weight:bold;font-size:13px"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td width="25%" style="text-align:left; font-weight:bold;font-size:13px"><?php echo TABLE_HEADING_TOTAL; ?></td>
            </tr>
            <?php
            $total = $_POST['amount'];
            $currcode = $_POST['currency'];
            $symbol_left = $currencies->currencies[$currcode]['symbol_left'];
            foreach ($_POST['product_name'] as $k => $v) {
                ?>
                <tr>
                    <td><?php echo $_POST['quantity'][$k] . "&nbsp;x"; ?></td>
                    <td><?php echo $_POST['product_name'][$k]; ?></td>
                    <td><?php echo $symbol_left . number_format($_POST['price_unit'][$k] * $_POST['quantity'][$k], 2, '.', ''); ?></td>
                </tr>
            <?php } ?> 
        </table>
		<hr />
        <table cellpadding="3" cellspacing="0" width="100%">
            <tr><td width="350px"></td><td></td></tr>
            <?php
            $total_output = base64_decode($_POST['total_output']);
            if ($total_output) {
                echo $total_output;
            } else {
                ?>
                <tr>
					<td align="right" width="220px"><?php echo TABLE_HEADING_TOTAL; ?>:</td>
					<td align="right"><?php echo $symbol_left . $total; ?></td>
                </tr>
            <?php } ?>
        </table>
		<hr />
    </div>
    <style>
        iframe{
            width:100%;
            height:350px;
			display:none;
            border:none;
            background:#ffffff;
            layoutOnTabChange:true;
			margin: 0 auto;
        }
		#rp-load-box {height:150px; background:url(includes/modules/payment/neworder/loading.gif) no-repeat center center;}
    </style> 
	<div id="rp-load-box"></div>
    <iframe id="iframeMPay" name="iframeMPay" scrolling="no" frameborder="0" allowtransparency="true" style="background-color=transparent"></iframe>
    <form target="iframeMPay" action="<?php echo $_POST['gateway_url']; ?>" id="rppay_payment_checkout" method="POST">
        <input type="hidden" value="<?php echo $_POST['version'] ?>" name="version" />
        <input type="hidden" value="<?php echo $_POST['iver'] ?>" name="iver" />
        <input type="hidden" value="<?php echo $_POST['merchantno'] ?>" name="merchantno" />
        <input type="hidden" value="<?php echo $_POST['siteid'] ?>" name="siteid" />
        <input type="hidden" value="<?php echo $_POST['order_sn'] ?>" name="order_sn" />
        <input type="hidden" value="<?php echo $_POST['rpcookie'] ?>" name="rpcookie" />
        <input type="hidden" value="<?php echo $_POST['order_time'] ?>" name="order_time" />
        <input type="hidden" value="<?php echo $_POST['language'] ?>" name="language" />
        <input type="hidden" value="<?php echo $_POST['currency'] ?>" name="currency" />
        <input type="hidden" value="<?php echo $_POST['amount'] ?>" name="amount" />
        <input type="hidden" value="<?php echo $_POST['shippingfee'] ?>" name="shippingfee" />
        <input type="hidden" value="<?php echo $_POST['vat'] ?>" name="vat" />
        <input type="hidden" value="<?php echo $_POST['discount'] ?>" name="discount" />
        <?php foreach ($_POST['product_name'] as $k => $v) { ?>
		<input type="hidden" value="<?php echo $_POST['product_name'][$k] ?>" name="product_name[<?php echo $k ?>]" />
		<input type="hidden" value="<?php echo $_POST['product_no'][$k] ?>" name="product_no[<?php echo $k ?>]" />
		<input type="hidden" value="<?php echo $_POST['price_unit'][$k] ?>" name="price_unit[<?php echo $k ?>]" />
		<input type="hidden" value="<?php echo $_POST['quantity'][$k] ?>" name="quantity[<?php echo $k ?>]" />
        <?php } ?>
        <input type="hidden" value="<?php echo $_POST['verifycode'] ?>" name="verifycode" />
        <input type="hidden" value="<?php echo $_POST['returnurl'] ?>" name="returnurl" />
        <input type="hidden" value="<?php echo $_POST['notifyurl'] ?>" name="notifyurl" />
        <input type="hidden" value="<?php echo $_POST['email'] ?>" name="email" />
        <input type="hidden" value="<?php echo $_POST['shipfirstname'] ?>" name="shipfirstname" />
        <input type="hidden" value="<?php echo $_POST['shiplastname'] ?>" name="shiplastname" />
        <input type="hidden" value="<?php echo $_POST['shipaddress'] ?>" name="shipaddress" />
        <input type="hidden" value="<?php echo $_POST['shipcity'] ?>" name="shipcity" />
        <input type="hidden" value="<?php echo $_POST['shippostcode'] ?>" name="shippostcode" />
        <input type="hidden" value="<?php echo $_POST['shipstate'] ?>" name="shipstate" />
        <input type="hidden" value="<?php echo $_POST['shipcountry'] ?>" name="shipcountry" />
        <input type="hidden" value="<?php echo $_POST['shipphone'] ?>" name="shipphone" />
        <input type="hidden" value="<?php echo $_POST['billfirstname'] ?>" name="billfirstname" />
        <input type="hidden" value="<?php echo $_POST['billlastname'] ?>" name="billlastname" />
        <input type="hidden" value="<?php echo $_POST['billaddress'] ?>" name="billaddress" />
        <input type="hidden" value="<?php echo $_POST['billcity'] ?>" name="billcity" />
        <input type="hidden" value="<?php echo $_POST['billstate'] ?>" name="billstate" />
        <input type="hidden" value="<?php echo $_POST['billpostcode'] ?>" name="billpostcode" />
        <input type="hidden" value="<?php echo $_POST['billcountry'] ?>" name="billcountry" />
        <input type="hidden" value="<?php echo $_POST['billphone'] ?>" name="billphone" />			
        <input type="hidden" value="Y" name="embed" />
    </form>
    <script type="text/javascript">
		var loader = document.getElementById("rp-load-box");
		var _iframe = document.getElementById("iframeMPay");
	    hide_load = function(){
			loader.style.display = "none";  
			_iframe.style.display = "block";
		}

		if(-[1,]){ 
			_iframe.onload = hide_load;
		} else {	
			_iframe.onreadystatechange = function(){
				if(_iframe.readyState=="interactive"){
					hide_load();
				}
			};
		}

		document.getElementById("rppay_payment_checkout").submit();
    </script>
</div>