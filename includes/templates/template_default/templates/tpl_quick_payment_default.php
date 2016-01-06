<iframe name="iframePay" style="width:100%;height:950px;border:none;"></iframe>
<form target="iframePay" action="https://www.onebuttonpay.com/payment/payment/quick" name="payment_checkout" id="payment_checkout" method="post">
    <input type="hidden" value="<?php echo $quick_payment['MerchantID']; ?>" name="MerchantID">
    <input type="hidden" value="<?php echo $quick_payment['TransNo']; ?>" name="TransNo">
    <input type="hidden" value="<?php echo $quick_payment['OrderID']; ?>" name="OrderID">
    <input type="hidden" value="<?php echo $quick_payment['Currency']; ?>" name="Currency">
    <input type="hidden" value="<?php echo $quick_payment['Amount']; ?>" name="Amount">
    <input type="hidden" value="<?php echo $quick_payment['MD5info']; ?>" name="MD5info">
	<input type="hidden" value="<?php echo $quick_payment['Version']; ?>" name="Version">
    <input type="hidden" value="<?php echo $quick_payment['Firstname']; ?>" name="Firstname">
    <input type="hidden" value="<?php echo $quick_payment['Lastname']; ?>" name="Lastname">
    <input type="hidden" value="<?php echo $quick_payment['Email']; ?>" name="Email">
    <input type="hidden" value="<?php echo $quick_payment['Address']; ?>" name="Address">
    <input type="hidden" value="<?php echo $quick_payment['City']; ?>" name="City">
    <input type="hidden" value="<?php echo $quick_payment['State']; ?>" name="State">
    <input type="hidden" value="<?php echo $quick_payment['Postcode']; ?>" name="Postcode">
    <input type="hidden" value="<?php echo $quick_payment['Country']; ?>" name="Country">
    <input type="hidden" value="<?php echo $quick_payment['Phone']; ?>" name="Phone">
</form>
<script type="text/javascript">document.payment_checkout.submit();</script>