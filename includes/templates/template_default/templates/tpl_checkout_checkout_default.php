<div class="panel">
	<h1 class="panel-heading"></h1>
	<div class="panel-body page-content">
		<?php display_message('checkout');?>
		<?php display_message('pay_error');?>
		<?php if ( !in_array($_SESSION['payment'], array('rpsitepay', 'rpnewpay'))){?>
			<form action="<?php echo $form_action_url;?>" id="checkout" method="post">
			<?php
			if (is_array($payment_modules->modules))
			{
				echo $payment_modules->process_button();
			}
			
			?>
			<script type="text/javascript">document.getElementById('checkout').submit();</script>
			<div class="buttonRow"><?php echo zen_image_submit(BUTTON_IMAGE_CONFIRM_ORDER, BUTTON_CONFIRM_ORDER_ALT, 'name="btn_submit" id="btn_submit"') ;?></div>
			
			</form>
		<?php }else{?>
		<style>
.cybersourcecard1, .cybersourcecard3,.cybersourcecard4 {
background: url(<?php echo DIR_WS_MODULES.'payment/neworder/';?>globalcollect.jpg) no-repeat;
}
.cybersourcecard1, .cybersourcecard3,.cybersourcecard4 {
width: 51px;
height: 32px;
display: inline-block;
}
.cybersourcecard4 {
background-position: 0 -210px  !important;
}
		</style>
			<script>

function CardShow() {
    document.getElementById("bigcard").style.display = "block";
}
function CardHide() {
    document.getElementById("bigcard").style.display = "none";
}
last_submit_time = 0;
function submit_check()
{
	var errmsg = [];
	if (jQuery("input[name=paymethod]:checked").size()==0)
		errmsg[0] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_CREDIT_CARD?>";
	if (jQuery("#creditCardNumber").val()==0)
		errmsg[1] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_CARD?>";
	else
	{
		var ct = jQuery("input[name=paymethod]:checked").val();
		var cn = jQuery("#creditCardNumber").val().substring(0,1);
		if (((cn==4 && ct=="V") || (cn==5 && ct=="M") || (cn==3 && ct=="J")) && (jQuery("#creditCardNumber").val().length==16))
			{}
		else 
			errmsg[1] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_CARD_NUMBER_INVALID?>";
	}
	if (jQuery("#expiryDateMM").val()==-1 || jQuery("#expiryDateYY").val()==-1)
		errmsg[2] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_EXPIRATION?>";
	
	if (jQuery("#card_cvn").val()=="" || jQuery("#card_cvn").val().length<3 || !/^\d+$/.test(jQuery("#card_cvn").val()))
		errmsg[3] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_SECURITY_CODE?>";

	if (jQuery("#txtAddr").val()=="")
		errmsg[4] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_ADDRESS?>";
	if (jQuery("#txtFirstName").val()=="")
		errmsg[5] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_FIRST_NAME?>";
	if (jQuery("#txtLastName").val()=="")
		errmsg[6] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_LAST_NAME?>";
	if (jQuery("#txtPostCode").val()=="")
		errmsg[7] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_POST_CODE?>";
	if (jQuery("#txtCity").val()=="")
		errmsg[8] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_CITY?>";
	if (jQuery("#txtEmail").val()=="")
		errmsg[9] = "<?php echo TEXT_CHECKOUT_PAYMENT_ERROR_BILLING_EMAIL?>";


	
	if (errmsg)
	{
		var str = errmsg.join("\n");
		if (str)
		{
			alert(str);
			return false;
		}
	}
	
	if (last_submit_time > 0)
	{
		alert("<?php echo TEXT_CHECKOUT_PAYMENT_INFOR_REPEAT;?>");
		return false;
	}
	else
	{
		last_submit_time=300;
		interval_clock = setInterval(function(){
			
			last_submit_time--;
			jQuery('#clock_time').html(last_submit_time).show();
			if (last_submit_time<=0){
				clearInterval(interval_clock);
				jQuery('#clock_time').hide();
			}
		},1000);
	}
	jQuery('#clock_time').show();
	return true;
}
</script>
			<form method="post" name="checkout_site" id="checkout_site" class="form-horizontal" enctype="multipart/form-data" onsubmit="return submit_check();">
				<input name="payment_process" type="hidden" value="payment_post">
				<input id="checkout_hDate" name="checkout_hDate" type="hidden" value="">
				<input id="checkout_hTimeZone" name="checkout_hTimeZone" type="hidden" value="">
				<input id="checkout_vga" name="checkout_vga" type="hidden" value="">
				<?php echo zen_draw_hidden_field('securityToken', $_SESSION['securityToken']);?>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<p><?php echo TEXT_CHECKOUT_PAYMENT_INFORMATION;?></p>
					</div>
				</div>
				<div class="row payment-cnt">
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="pay-area">
							<p style="margin: 10px 0;border-bottom:1px solid #ccc;"><?php echo TITLE_CHECKOUT_PAYMENT_CREDIT_INFOR;?></p>
							<p class="errorInfo"></p>
							
							
							
							<div class="form-group">
								<label class="col-xs-12 col-sm-6 col-md-4 control-label">
									<span class="required">*</span>
								</label>
								<div class="col-xs-12 col-sm-6 col-md-8">
									<ul class="clearfix paydemo">
										<li>
											<label for="paymethod1" class="cybersourcecard1"></label>
											<input type="radio" name="paymethod" id="paymethod1" value="V"<?php if(isset($_POST['paymethod']) && $_POST['paymethod']=='V'){echo ' checked="checked"';}?>>
										</li>
										<li>
											<label for="paymethod3" class="cybersourcecard3"></label>
											<input type="radio" name="paymethod" id="paymethod3" value="M"<?php if(isset($_POST['paymethod']) && $_POST['paymethod']=='M'){echo ' checked="checked"';}?>>
										</li>
										<li>
											<label for="paymethod4" class="cybersourcecard4"></label>
											<input type="radio" name="paymethod" id="paymethod4" value="J"<?php if(isset($_POST['paymethod']) && $_POST['paymethod']=='J'){echo ' checked="checked"';}?>>
										</li>
									</ul>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-6 col-md-4 control-label">
									<?php echo TEXT_CHECKOUT_PAYMENT_INFOR_CARD_NUMBER;?>
									<span class="required">*</span>
								</label>
								<div class="col-xs-12 col-sm-6 col-md-8">
									<input maxlength="23" type="text" class="cardNo elmbBlur form-control" name="card_no" id="creditCardNumber" value="<?php if(isset($_POST['card_no'])){echo $_POST['card_no'];}?>"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-6 col-md-4 control-label"><?php echo TEXT_CHECKOUT_PAYMENT_INFOR_EXPIRATION;?>
									<span class="required">*</span>
								</label>
								<div class="col-xs-12 col-sm-6 col-md-8">
									<div class="form-inline">
										
										<select name="card_exp_month" id="expiryDateMM" class=" form-control">
											<option value="-1"><?php echo TEXT_CHECKOUT_PAYMENT_MONTH;?></option>
											<?php foreach (range(1, 12) as $month):?>
											<option value="<?php echo str_pad($month, 2, '0', STR_PAD_LEFT);?>"<?php if(isset($_POST['card_exp_month']) && (int)$_POST['card_exp_month']==$month){echo ' selected="selected"';}?>><?php echo str_pad($month, 2, '0', STR_PAD_LEFT);?></option>
											<?php endforeach;?>
										</select>
										
										<select name="card_exp_year" id="expiryDateYY" class=" form-control">
											<option value="-1"><?php echo TEXT_CHECKOUT_PAYMENT_YEAR;?></option>
											<?php foreach (range(date('Y'), date('Y') + 20) as $year):?>
											<option value="<?php echo $year;?>"<?php if(isset($_POST['card_exp_year']) && (int)$_POST['card_exp_year']==$year){echo ' selected="selected"';}?>><?php echo $year;?></option>
											<?php endforeach;?>
									    </select>
								    </div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-12 col-sm-6 col-md-4 control-label">
									<?php echo TEXT_CHECKOUT_PAYMENT_INFOR_SECURITY_CODE;?><span class="required">*</span>
								</label>
								<div class="col-xs-12 col-sm-6 col-md-8">
									<input type="text" maxlength="4" class="securityCode elmbBlur form-control" name="card_cvn" id="card_cvn" value="<?php if(isset($_POST['card_cvn'])){echo $_POST['card_cvn'];}?>">
									<div id="smallcard" onmouseover="CardShow()" onmouseout="CardHide()">
                                       <img src="<?php echo DIR_WS_MODULES.'payment/neworder/';?>card_demo.png" style="cursor: pointer;">
                                       <div id="bigcard" style="display: none;">
                                           <img src="<?php echo DIR_WS_MODULES.'payment/neworder/';?>card_demo.jpg">
                                       </div>
                                    </div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-xs-12 col-sm-6 col-md-4 control-label"></label>
								<div class="col-xs-12 col-sm-6 col-md-7">
									<input type="submit" name="btn_submit" id="btn_submit" class="btn btn-warning" value="<?php echo BUTTON_CONTINUE_ALT;?>"/>
									&nbsp;&nbsp;<span class="required"  id="clock_time"></span>
								</div>
							</div>
							
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="order-summary2">
							<p style="margin-top: 10px;border-bottom:1px solid #ccc;"><?php echo TITLE_CHECKOUT_PAYMENT_ORDER_SUMMARY;?></p>
								<?php
			if (MODULE_ORDER_TOTAL_INSTALLED)
			{
			?>
			<div id="orderTotals"><?php $order_total_modules->output(); ?></div>
			<?php
			}
			?>
								<p style="margin-top: 10px;border-bottom:1px solid #ccc;"><?php echo TITLE_CHECKOUT_PAYMENT_BILLING_ADDRESS;?></p>
								<div class="form-group">
									<label class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo TITLE_CHECKOUT_PAYMENT_FIRST_NAME;?></label>
									<div class="col-xs-12 col-sm-8 col-md-9">
										<input id="txtFirstName" name="BFirstName" type="text" class="form-control" value="<?php echo $order->billing['firstname'];?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo TITLE_CHECKOUT_PAYMENT_LAST_NAME;?></label>
									<div class="col-xs-12 col-sm-8 col-md-9">
										<input id="txtLastName" name="BLastName" type="text" class="form-control" value="<?php echo $order->billing['lastname'];?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo TITLE_CHECKOUT_PAYMENT_ADDRESS;?></label>
									<div class="col-xs-12 col-sm-8 col-md-9">
										<input id="txtAddr" name="BAddress" type="text" class="form-control" value="<?php echo $order->billing['street_address'];?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo TITLE_CHECKOUT_PAYMENT_POST_CODE;?></label>
									<div class="col-xs-12 col-sm-8 col-md-9">
										<input id="txtPostCode" name="PostCode" type="text"  class="form-control" value="<?php echo $order->billing['postcode'];?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo TITLE_CHECKOUT_PAYMENT_CITY;?></label>
									<div class="col-xs-12 col-sm-8 col-md-9">
										<input id="txtCity" name="BCity" type="text" class="form-control" value="<?php echo $order->billing['city'];?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-12 col-sm-4 col-md-3 control-label"><?php echo TITLE_CHECKOUT_PAYMENT_EMAIL;?></label>
									<div class="col-xs-12 col-sm-8 col-md-9">
										<input id="txtEmail" name="BEmail" type="text"  class="form-control" value="<?php echo $order->customer['email_address'];?>">
									</div>
								</div>
								
							</div>
					</div>
					
				</div>
			
		</form>
<script type="text/javascript">
var d, t, y, m;

d = new Date();
y = d.getFullYear();
m = d.getMonth() + 1;
t = y + "-" + m + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
jQuery("#checkout_hDate").val(t);
jQuery("#checkout_hTimeZone").val(new Date().getTimezoneOffset() / 60 * -1);
jQuery("#checkout_vga").val(window.screen.width + '*' + window.screen.height);


</script>
			
			
		<?php }?>
	</div>
</div>
