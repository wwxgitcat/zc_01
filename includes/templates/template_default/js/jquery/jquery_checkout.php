<?php
/**
 * jscript_main
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_main.php 106 2010-03-14 20:55:15Z numinix $
 */
?>
<script type="text/javascript"><!--//
var selected;
var submitter = null;

function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}
function couponpopupWindow(url) {
  window.open(url,'couponpopupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
}
function submitFunction($gv,$total) {
  if ($gv >=$total) {
    submitter = 1;	
  }
  $('div#checkout form').attr({
    name: 'checkout_payment',
    onsubmit: 'return true;',
    action: '<?php echo $form_action_url;?>'
  }); 
}

function methodSelect(theMethod) {
  if (document.getElementById(theMethod)) {
    document.getElementById(theMethod).checked = 'checked';
  }
}

function updateForm() {
  if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){
    var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
    if (ieversion <= 7) {
      document.forms['checkout_payment'].action = "index.php?main_page=checkout&fecaction=update";
      document.forms['checkout_payment'].submit();             // Submit the page
    } else {
      nonIEupdateForm();
    }
  } else {
	  nonIEupdateForm();
  }
}

function nonIEupdateForm() {
  $('div#checkout form').attr({
    name: 'checkout_payment',
    onsubmit: 'return true;',
    action: 'index.php?main_page=checkout&fecaction=update'
  });
  $('div#checkout form').submit();
}
//--></script>