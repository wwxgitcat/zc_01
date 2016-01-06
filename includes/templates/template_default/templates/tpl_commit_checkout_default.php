<iframe name="iframePay" style="width:100%;height:600px;border:none;" id="iframePay"></iframe>
<form target="iframePay" action="https://www.onebuttonpay.com/payment/payment/index" name="payment_checkout" id="payment_checkout" method="post">
    <input type="hidden" value="<?php echo $_POST['MerchantID']; ?>" name="MerchantID">
    <input type="hidden" value="<?php echo $_POST['TransNo']; ?>" name="TransNo">
    <input type="hidden" value="<?php echo $_POST['OrderID']; ?>" name="OrderID">
    <input type="hidden" value="<?php echo $_POST['Currency']; ?>" name="Currency">
    <input type="hidden" value="<?php echo $_POST['Amount']; ?>" name="Amount">
    <input type="hidden" value="<?php echo $_POST['MD5info']; ?>" name="MD5info">
	<input type="hidden" value="<?php echo $_POST['Version']; ?>" name="Version">
    <input type="hidden" value="<?php echo $_POST['BFirstname']; ?>" name="BFirstname">
    <input type="hidden" value="<?php echo $_POST['BLastname']; ?>" name="BLastname">
    <input type="hidden" value="<?php echo $_POST['BEmail']; ?>" name="BEmail">
    <input type="hidden" value="<?php echo $_POST['BAddress']; ?>" name="BAddress">
    <input type="hidden" value="<?php echo $_POST['BCity']; ?>" name="BCity">
    <input type="hidden" value="<?php echo $_POST['BState']; ?>" name="BState">
    <input type="hidden" value="<?php echo $_POST['BPostcode']; ?>" name="BPostcode">
    <input type="hidden" value="<?php echo $_POST['BCountry']; ?>" name="BCountry">
    <input type="hidden" value="<?php echo $_POST['BPhone']; ?>" name="BPhone">
    <input type="hidden" value="<?php echo $_POST['DFirstname']; ?>" name="DFirstname">
    <input type="hidden" value="<?php echo $_POST['DLastname']; ?>" name="DLastname">
    <input type="hidden" value="<?php echo $_POST['DEmail']; ?>" name="DEmail">
    <input type="hidden" value="<?php echo $_POST['DAddress']; ?>" name="DAddress">
    <input type="hidden" value="<?php echo $_POST['DCity']; ?>" name="DCity">
    <input type="hidden" value="<?php echo $_POST['DState']; ?>" name="DState">
    <input type="hidden" value="<?php echo $_POST['DPostcode']; ?>" name="DPostcode">
    <input type="hidden" value="<?php echo $_POST['DCountry']; ?>" name="DCountry">
    <input type="hidden" value="<?php echo $_POST['DPhone']; ?>" name="DPhone">
</form>
<style>.big-error-msg{width:100%;padding:0px;}</style>
<script type="text/javascript">document.payment_checkout.submit();


var temp_css;
temp_css='<style type="text/css">';
temp_css+="body{padding:10px 0;margin:0;font-size:12px;}";
temp_css+="</style>";
window.onload=function(){
var obj=window.frames["iframePay"];
obj.document.body.innerHTML+=temp_css;
}


$(document).ready(function () {
		$("#iframePay").load(function(){

						var test='<style>.big-error-msg{width:100%;padding:0px;}</style>';

			$("#iframePay").append(test);


		});
		document.getElementById("iframePay").onload=function(){

			$("#iframePay #page #main").css({
			  "width":"100%",
			  "padding":"0px",
			  "font-family":"Arial",
			  "font-size":"20px",
			  "padding":"5px"
			})
			$(".big-error-msg").css({
			  "width":"100%",
			  "padding":"0px",
			})
			$("#iframePay #page #main table td").css({
			  "width":"100%",
			  "float":"left",
			})
			$("#iframePay #page #main table th").css({
			  "width":"100%",
			  "float":"left",
			})
		};

});


</script>

