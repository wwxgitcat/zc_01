//tealium universal tag - utag.164 ut4.0.201410031727, Copyright 2014 Tealium.com Inc. All Rights Reserved.
var __s2tQ=__s2tQ||[];if(typeof utag.ut=="undefined"){utag.ut={};}
utag.ut.libloader2=function(o,a,b,c,l){a=document;b=a.createElement('script');b.language='javascript';b.type='text/javascript';b.async=true;b.src=o.src;if(o.id){b.id=o.id}
if(typeof o.cb=='function'){b.hFlag=0;b.onreadystatechange=function(){if((this.readyState=='complete'||this.readyState=='loaded')&&!b.hFlag){b.hFlag=1;o.cb();}};b.onload=function(){if(!b.hFlag){b.hFlag=1;o.cb();}};}
l=o.loc||'head';c=a.getElementsByTagName(l)[0];if(c){if(l=='script'){c.parentNode.insertBefore(b,c);}else{c.appendChild(b);}
utag.DB("Attach to "+l+": "+o.src);}};try{(function(id,loader){var u=utag.o[loader].sender[id]={};u.ev={'view':1,'link':1};u.initialized=false;u.map={"basket_product_id":"basket_product_id","basket_product_name":"basket_product_name","basket_product_quantity":"basket_product_quantity","basket_product_sku":"basket_product_sku","basket_product_unit_price":"basket_product_unit_price","customer_address1":"customer_address1","customer_address2":"customer_address2","customer_address3":"customer_address3","customer_address4":"customer_address4","customer_city":"customer_city","customer_country":"customer_country","customer_email":"customer_email","customer_first_name":"customer_first_name","customer_id":"customer_id","customer_landline":"customer_landline","customer_last_name":"customer_last_name","customer_mobile":"customer_mobile","customer_optout1":"customer_optout1","customer_optout2":"customer_optout2","customer_postcode":"customer_postcode","customer_state":"customer_state","customer_title":"customer_title","customer_zip":"customer_zip"};u.extend=[function(a,b){if(typeof b['customer_title']!='undefined'){utag.loader.SC('utag_main',{'customerTitle':b['customer_title']+';exp-session'});b['cp.utag_main_customerTitle']=b['customer_title'];}},function(a,b){if(typeof b['customer_first_name']!='undefined'){utag.loader.SC('utag_main',{'customerFirstName':b['customer_first_name']+';exp-session'});b['cp.utag_main_customerFirstName']=b['customer_first_name'];}},function(a,b){if(typeof b['customer_last_name']!='undefined'){utag.loader.SC('utag_main',{'customerLastName':b['customer_last_name']+';exp-session'});b['cp.utag_main_customerLastName']=b['customer_last_name'];}},function(a,b){if(typeof b['customer_address1']!='undefined'){utag.loader.SC('utag_main',{'customerAddress1':b['customer_address1']+';exp-session'});b['cp.utag_main_customerAddress1']=b['customer_address1'];}},function(a,b){if(typeof b['customer_address2']!='undefined'){utag.loader.SC('utag_main',{'customerAddress2':b['customer_address2']+';exp-session'});b['cp.utag_main_customerAddress2']=b['customer_address2'];}},function(a,b){if(typeof b['customer_address3']!='undefined'){utag.loader.SC('utag_main',{'customerAddress3':b['customer_address3']+';exp-session'});b['cp.utag_main_customerAddress3']=b['customer_address3'];}},function(a,b){if(typeof b['customer_address4']!='undefined'){utag.loader.SC('utag_main',{'customerAddress4':b['customer_address4']+';exp-session'});b['cp.utag_main_customerAddress4']=b['customer_address4'];}},function(a,b){if(typeof b['customer_postcode']!='undefined'){utag.loader.SC('utag_main',{'customerPostcode':b['customer_postcode']+';exp-session'});b['cp.utag_main_customerPostcode']=b['customer_postcode'];}},function(a,b){if(typeof b['customer_email']!='undefined'){utag.loader.SC('utag_main',{'customerEmail':b['customer_email']+';exp-session'});b['cp.utag_main_customerEmail']=b['customer_email'];}},function(a,b){if(typeof b['customer_landline']!='undefined'){utag.loader.SC('utag_main',{'customerLandline':b['customer_landline']+';exp-session'});b['cp.utag_main_customerLandline']=b['customer_landline'];}},function(a,b){if(typeof b['customer_mobile']!='undefined'){utag.loader.SC('utag_main',{'customerMobile':b['customer_mobile']+';exp-session'});b['cp.utag_main_customerMobile']=b['customer_mobile'];}},function(a,b){if(typeof b['customer_optout1']!='undefined'){utag.loader.SC('utag_main',{'customerOptout1':b['customer_optout1']+';exp-session'});b['cp.utag_main_customerOptout1']=b['customer_optout1'];}},function(a,b){if(typeof b['customer_optout2']!='undefined'){utag.loader.SC('utag_main',{'customerOptout2':b['customer_optout2']+';exp-session'});b['cp.utag_main_customerOptout2']=b['customer_optout2'];}},function(a,b){if(typeof b['customer_country']!='undefined'){utag.loader.SC('utag_main',{'customerCountry':b['customer_country']+';exp-session'});b['cp.utag_main_customerCountry']=b['customer_country'];}}];u.send=function(a,b){if(u.ev[a]||typeof u.ev.all!="undefined"){var c,d,e,f,i;u.data={};for(c=0;c<u.extend.length;c++){try{d=u.extend[c](a,b);if(d==false)return}catch(e){}};for(d in utag.loader.GV(u.map)){if(typeof b[d]!='undefined'){e=u.map[d].split(',');for(f=0;f<e.length;f++){u.data[e[f]]=b[d];}}}
u.myCallback=function(a){u.initialized=true;for(d in utag.loader.GV(u.map)){if(typeof b[d]!="undefined"&&b[d]!=""){e=u.map[d].split(",");for(f=0;f<e.length;f++){u.data[e[f]]=b[d];}}else{h=d.split(":");if(h.length==2&&b[h[0]]==h[1]){g=""+u.event_lookup[u.map[d]];if(g!=""){b._cevent=g}}}}
var s2={};if(b.event_type=="Sub2Store"){s2={};if(b.customer_title){s2.Title=b.customer_title;}
if(b.customer_first_name){s2.Forename=b.customer_first_name;}
if(b.customer_last_name){s2.Surname=b.customer_last_name;}
if(b.customer_email){s2.Email=b.customer_email;}
if(b.customer_mobile){s2.Mobile=b.customer_mobile;}
if(Object.keys(s2).length!==0){__s2tQ.push(['store',s2]);}}
if((b.page_type=="checkout"&&b.page_name.match(/Shopping Basket/i)||b.event_type=="add-to-cart")){if(b.basket_product_id){var basket='';for(var i=0;i<b.basket_product_id.length;i++){basket+='<Product>';if(b.basket_product_sku&&b.basket_product_sku[i]){basket+='<SKU>'+b.basket_product_sku[i]+'</SKU>';}
if(b.basket_product_name&&b.basket_product_name[i]){basket+='<Product_Name>'+b.basket_product_name[i]+'</Product_Name>';}
if(b.basket_product_unit_price&&b.basket_product_unit_price[i]){basket+='<Unit_Price>'+b.basket_product_unit_price[i]+'</Unit_Price>';}
if(b.basket_product_quantity&&b.basket_product_quantity[i]){basket+='<Quantity>'+b.basket_product_quantity[i]+'</Quantity>';}else{basket+='<Quantity>'+'1'+'</Quantity>';}
basket+='</Product>';}
if(basket!==''){basket='<Store>'+basket+'</Store>';}else{basket='<Store></Store>';}
__s2tQ.push(['sendBasket',basket]);}}
if(b.page_type=="checkout"&&b.page_name.match(/confirmation/)){s2={};if(b.order_id){s2.OrderID=b.order_id;}
if(b.affiliate_id){s2.Affiliation=b.affiliate_id;}
if(b.order_total){s2.Total=b.order_total;}
if(b.order_tax){s2.Tax=b.order_tax;}
if(b.order_shipping){s2.Shipping=b.order_shipping;}
if(b.customer_city||b["cp.utag_main_customerAddress3"]){s2.City=b.customer_city||b["cp.utag_main_customerAddress3"];}
if(b.customer_county){s2.County=b.customer_county;}
if(b.customer_country||b["cp.utag_main_customerCountry"]){s2.Country=b.customer_country||b["cp.utag_main_customerCountry"];}
if(Object.keys(s2).length!==0){__s2tQ.push(['addOrder',s2]);}
if(b.product_id){for(var i=0;i<b.product_id.length;i++){s2={};if(b.order_id){s2.OrderID=b.order_id;}
if(b.product_sku&&b.product_sku[i]){s2.SKU=b.product_sku[i];}
if(b.product_id&&b.product_id[i]){s2.Product_ID=b.product_id[i];}
if(b.product_name&&b.product_name[i]){s2.Product_Name=b.product_name[i];}
if(b.product_category&&b.product_category[i]){s2.Category=b.product_category[i];}
if(b.product_unit_price&&b.product_unit_price[i]){s2.Unit_Price=b.product_unit_price[i];}
if(b.product_quantity&&b.product_quantity[i]){s2.Quantity=b.product_quantity[i];}else{s2.Quantity=1;}
if(Object.keys(s2).length!==0){__s2tQ.push(['addItem',s2]);}}}
s2={};if(b.customer_title||b["cp.utag_main_customerTitle"]){s2.Title=b.customer_title||b["cp.utag_main_customerTitle"];}
if(b.customer_first_name||b["cp.utag_main_customerFirstName"]){s2.Forename=b.customer_first_name||b["cp.utag_main_customerFirstName"];}
if(b.customer_last_name||b["cp.utag_main_customerLastName"]){s2.Surname=b.customer_last_name||b["cp.utag_main_customerLastName"];}
if(b.customer_address1||b["cp.utag_main_customerAddress1"]){s2.Address1=b.customer_address1||b["cp.utag_main_customerAddress1"];}
if(b.customer_address2||b["cp.utag_main_customerAddress2"]){s2.Address2=b.customer_address2||b["cp.utag_main_customerAddress2"];}
if(b.customer_address3||b["cp.utag_main_customerAddress3"]){s2.Address3=b.customer_address3||b["cp.utag_main_customerAddress3"];}
if(b.customer_address4||b["cp.utag_main_customerAddress4"]){s2.Address4=b.customer_address4||b["cp.utag_main_customerAddress4"];}
if(b.customer_postcode||b["cp.utag_main_customerPostcode"]){s2.Postcode=b.customer_postcode||b["cp.utag_main_customerPostcode"];}
if(b.customer_email||b["cp.utag_main_customerEmail"]){s2.Email=b.customer_email||b["cp.utag_main_customerEmail"];}
if(b.customer_landline||b["cp.utag_main_customerLandline"]){s2.Landline_Number=b.customer_landline||b["cp.utag_main_customerLandline"];}
if(b.customer_mobile||b["cp.utag_main_customerMobile"]){s2.Mobile_Number=b.customer_mobile||b["cp.utag_main_customerMobile"];}
if(b.customer_optout1||b["cp.utag_main_customerOptout1"]){s2.Optout1P=b.customer_optout1||b["cp.utag_main_customerOptout1"];}
if(b.customer_optout2||b["cp.utag_main_customerOptout2"]){s2.Optout3P=b.customer_optout2||b["cp.utag_main_customerOptout2"];}
if(Object.keys(s2).length!==0){__s2tQ.push(['match',s2]);}}
};var license_key="4ad39d00-b47d-448e-baa4-44294bbe58af";if(!u.initialized){utag.ut.libloader2({src:"//webservices.sub2tech.com/CodeBase/LIVE/Min/sub2.js?LICENSEKEY="+license_key+"&trackPage=Y",cb:function(){u.myCallback(a);}});}else{u.myCallback(a);}
}};utag.o[loader].loader.LOAD(id);})('164','deckers.ugg-uk');}catch(e){}
