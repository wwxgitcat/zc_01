<?php
/**
 * jscript_main
 *
 * @package page
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jscript_main.php 15536 2010-02-20 06:11:54Z drbyte $
 */
?>
<script language="javascript" type="text/javascript"><!--
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
}

function submitonce()
{
  var button = document.getElementById("btn_submit");
  button.style.cursor="wait";
  button.disabled = true;
  setTimeout('button_timeout()', 4000);
  return false;
}
function button_timeout() {
  var button = document.getElementById("btn_submit");
  button.style.cursor="pointer";
  button.disabled = false;
}
$(document).ready(function(){
	$(document).ajaxStart(function(){
		var bg = $('<div></div>').attr({'background':'url(images/big_load.gif);',opacity:0.4,width:$(this).width(),height:$(this).height(),
			position:'absolute',top:0,left:0});
		$('body').append(bg);
		$('#ajaxInfor').html('');
	});
	$('input[name=shipping]').click(function(){
		$.ajax({
			url:'<?php echo zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '&ajax', 'SSL');?>',
			dataType:'json',
			data:'shipping='+$(this).val(),
			type: 'post',
			success: function(obj){
				if (typeof obj.error !== 'undefined')
				{
					$('#ajaxInfor').append('<div class="messageStackError larger">'+obj.error+'</div>');
				}
				if (typeof obj.msg !== 'undefined')
				{
					$('#ajaxInfor').append('<div class="messageStackSuccess larger">'+obj.msg+'</div>');
				}
				$('#orderTotals').html(obj.orderTotal);
			}
		});
	});
});


//--></script>