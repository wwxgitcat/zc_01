<?php
require ('includes/application_top.php');

$title_arr=array(
				"期間限定イベント中！有名ブランド品から人気セットや最新作続々登場、さまざまなカテゴリーのアイテムを豊富に取り揃えています！お見逃しなく！",
				"史上最大のクリアランスセール開催中！店長が厳選したアイテムも数量限定特別価格で大放出！",
				"素敵な商品をあたたかいサービスとともにお客様に届けるよう、スタッフ一同日々努力しています。ぜひご利用ください。",
				"全国様々なお客様のニーズに応える為、品揃え、サービス、ショップ作りにおいて、新しいスタイルをご提供できる店舗です。",
				" 全国より選りすぐりの良品を集めました。人気のブランド・商品がお得に買える！",
				"当店では、 お客様お一人お一人にゆっくり楽しんでいただけるような店作りを目指し、スタッフ一同、 日々努力しております。",
				"いつもお世話になっております！今年もさらに、お客様に喜んでいただける 安心、安全、素敵な皆様にお買い上げいただけますよう努力いたします。"
				);

	$key=array_rand($title_arr,1);
	$title=$title_arr[$key];
	$sql1 = 'UPDATE `' . TABLE_CONFIGURATION . '` SET `configuration_value`= \''.$title. '\' WHERE `configuration_key`=\'HOME_PAGE_TITLE\''  ;	
	$db->Execute($sql1);
	$sql2 = 'UPDATE `' . TABLE_CONFIGURATION . '` SET `configuration_value`= \''.$title. '\' WHERE `configuration_key`=\'HOME_PAGE_META_KEYWORDS\''  ;		
	$db->Execute($sql2);
	$sql3 = 'UPDATE `' . TABLE_CONFIGURATION . '` SET `configuration_value`= \''.$title. '\' WHERE `configuration_key`=\'HOME_PAGE_META_DESCRIPTION\'' ;	
	$b=$db->Execute($sql3);
	if($b){
		echo $title."<br/>";
		echo "更新成功";
	}else{
		echo	 $sql1."<br/>".$sql2."<br/>".$sql3."<br/>";
	};

?> 
