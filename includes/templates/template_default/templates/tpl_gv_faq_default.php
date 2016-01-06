<?php
/**
 * Page Template
 *
 * Displays the FAQ pages for the Gift-Certificate/Voucher system.<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_gv_faq_default.php 4859 2006-10-28 20:11:48Z drbyte $
 */
?>
<div class="centerColumn" id="gvFaqDefault">

<?php
// only show when there is a GV balance
if ($customer_has_gv_balance)
{
	?>
<div id="sendSpendWrapper">
<?php require($template->get_template_dir('tpl_modules_send_or_spend.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_send_or_spend.php'); ?>
</div>
<?php
}
?>

<div class="std">
		<style>
.qabox {
	background-color: #F4F3EC;
	margin: 10px 0;
	padding: 15px 10px
}

.qabox img {
	vertical-align: middle;
	margin-right: 12px
}

.qabox a {
	color: #00AC96;
	text-decoration: none;
}

.qabox a:hover {
	color: #FF6600;
	text-decoration: underline
}

.qa-q {
	color: #FF6600;
	font-weight: bold
}

.qa-a {
	color: #6F3F0F
}
</style>

		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">商品は本物なの？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">当店の商品は海外専属バイヤーが直営店にて買い付けした商品及び、熟練の専属鑑定士が1点1点丹念に検査した鑑定済み商品です。真贋と品質チェックには万全を期しておりますのでご安心してお買い求めください。
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">箱やギャランティカードなどの付属品は付きますか？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">商品により異なります。各商品の付属品については商品ページの「付属品」の欄をご参照くださいませ。
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">売り切れ中の商品の再入荷はありますか？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">商品の性質上、売り切れ中の商品の再入荷予定、再入荷時期は未定となっております。<br>
				海外買付品についても次回買付の際の状況により調達が可能かどうか、お約束できません。各商品とも、入荷があり次第随時サイトへ掲載して参りますので、こちらのホームページをご確認ください。
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">商品の取り置きや予約はできますか？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">当店では入荷情報について、お客様へ個別のご連絡、商品のご予約、お取り置きなどは承っておりません。誠に申し訳ございませんが、ご了承くださいますようよろしくお願い申し上げます。」
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">故障した時は修理はしてくれますか？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">誠に申し訳ございませんが、当店では修理は行っておりません。各ブランドの正規代理店のサービスセンター等へお問合せくださいませ。
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">支払方法を教えて下さい。
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">当店では「<strong>銀行振込</strong>」のお支払方法がご利用いただけます。
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">今日注文したらいつ頃届きますか？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif"><strong>お支払い方法が銀行振り込みの場合</strong><br>
				お客様からの入金確認後が出来次第、随時発送となります。<br> （ご入金は在庫確認メールをお受け取りいただいた後にお願い申し上げます。）<br>
				<br>
				※ご注文が混みあっている場合は、もう少しお時間をいただく場合がございますが、発送が完了次第、発送完了メールを送らせていただいておりますので、そちらをご確認ください。
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">配送日時の指定はできますか？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">日にちのご指定がない場合は、最短での発送（基本的に翌営業日以降）となります。
				<br> ご希望の配送日時がございましたら、ご注文の際、指定日・時間をお選びいただければ、できる限り対応させて頂きます。<br>
				※大阪府からの発送となりますので、お客様のお住まいの地域によっては、ご希望到着日にお届け出来ない場合がございます。<br>
				※交通事情や時期（夏季や冬季など）によっては到着が遅れる場合もございます。
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">送料はいくらですか？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">全国一律送料無料。
			</p>
		</div>

		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">査定料はかかるの？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">査定料は無料となっております。
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">宅配買取って何？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">ご自宅から査定品を梱包して送るだけで買取ができるカンタン＆安心の査定サービスです。梱包に必要なダンボールや緩衝材、発送時の着払い伝票などは当店がご用意します！
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">無料宅配キットって何？
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">宅配買取時に必要なダンボール箱（クッション封筒）、緩衝材、買取申込書、案内書、着払い伝票などが同封された梱包セットです。
			</p>
		</div>
		<div class="qabox">
			<p class="qa-q">
				<img src="includes/templates/14/images/qa-q.gif">注文確認などのメールが届かないんですが・・・。
			</p>
			<p class="qa-a">
				<img src="includes/templates/14/images/qa-a.gif">メールが届かない場合は<strong>登録のアドレスが間違っている、携帯アドレスをご登録の場合、メール受信の設定で「ドメイン指定受信」、「携帯電話メールのみの受信」などの設定をされている等の要因が考えられます</strong>ので一度ご確認くださいませ。<br>
				<br> ※携帯電話のメールアドレスをご指定のお客様へ
			</p>
		</div>
	</div>
	<br class="clearBoth" />


	<form
		action="<?php echo zen_href_link(FILENAME_GV_REDEEM, '', 'NONSSL', false); ?>"
		method="get">
<?php echo zen_draw_hidden_field('main_page',FILENAME_GV_REDEEM) . zen_draw_hidden_field('goback','true') . zen_hide_session_id(); ?>
<fieldset>
			<legend><?php echo TEXT_GV_REDEEM_INFO; ?></legend>
			<label class="inputLabel" for="lookup-gv-redeem"><?php echo TEXT_GV_REDEEM_ID; ?></label>
<?php echo zen_draw_input_field('gv_no', $_GET['gv_no'], 'size="18" id="lookup-gv-redeem"');?>
</fieldset>
		<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_REDEEM, BUTTON_REDEEM_ALT); ?></div>
	</form>

</div>