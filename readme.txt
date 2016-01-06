安装说明：
1.将压缩包内文件解压至网站根目录，如有提示是否覆盖原文件选择“是”

2.先在/includes/templates/（template_default 或 模板目录)/common/html_header.php文件代码</head>上加以下代码：
   <script type="text/javascript" src="https://js.realypay.com/index.js"></script>
   <script type="text/javascript" src="http://js.realypay.com/index.js"></script>

3.登录zen cart后台,依次选择：Modules->Payment->Credit Card Payment->install 

4.对相应选项进行设置：
Enable RPPAY Module			是否启动RPPAY支付接口
Payment Zone				如果选择了付款地区，仅该地区可以使用该支付模块。
Set RPPAY Order Status			产生新订单的订单状态
merchantno				商户号
siteid					为RPPAY商户网站ID
MIYAO					为RPPAY商户密钥，可登陆http://login.realypay.com，选择“网站管理”，即可看到密钥。
Submit URL				网关地址，可登陆http://login.realypay.com，选择“网站管理”，即可看到支付网关地址。

5.设置完成后update

6.确保Modules->Order Total页面，Sub-Total、Total、Shipping已启用

7.测试交易：能否正常提交，订单金额是否正确，能否正常返回。测试卡号4111111111111111, 5111111111111111

8.若支付页面尺寸或样式与网站模板不合，请自行更改以下文件：includes\templates\template_default\templates\tpl_real_time_pay_default.php
  搜索width:430px; 更改为合适的宽度



错误代码:
SYSTEM_ERROR		未知错误
WRONG_ORDER		订单号错误或订单已支付
EMPTY_XXX		XXX值为空(XXX为参数名)
WRONG_EMAIL		email格式错误
WRONG_SHIPCOUNTRY	货运国家代码错误
WRONG_BILLCOUNTRY	账单国家代码错误
WRONG_SIGN		签名错误
WRONG_REFER		订单提交来源地址和站点域名不匹配
WRONG_SITEID		siteid错误、未激活或已冻结
WRONG_MERCHANT		商户未激活或已冻结
WRONG_CURRENCY		币种代码错误或不支持的币种
WRONG_GOODS_MATCH	商品信息错误
WRONG_PRICE		订单总金额错误
LARGE_PRICE		订单金额超限
WRONG_RETURNURL		returnurl格式错误
WRONG_NOTIFYURL		notifyurl格式错误
