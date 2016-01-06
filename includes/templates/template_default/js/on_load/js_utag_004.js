//tealium universal tag - utag.160 ut4.0.201411211605, Copyright 2014 Tealium.com Inc. All Rights Reserved.
try{(function(id,loader){var u={};utag.o[loader].sender[id]=u;if(utag.ut===undefined){utag.ut={};}if(utag.ut.loader===undefined){u.loader=function(o){var a,b,c,l;a=document;if(o.type==="iframe"){b=a.createElement("iframe");b.setAttribute("height","1");b.setAttribute("width","1");b.setAttribute("style","display:none");b.setAttribute("src",o.src);}else if(o.type==="img"){utag.DB("Attach img: "+o.src);b=new Image();b.src=o.src;return;}else{b=a.createElement("script");b.language="javascript";b.type="text/javascript";b.async=1;b.src=o.src;}if(o.id){b.id=o.id;}if(typeof o.cb==="function"){b.hFlag=0;b.onreadystatechange=function(){if((this.readyState==='complete'||this.readyState==='loaded')&&!b.hFlag){b.hFlag=1;o.cb();}};b.onload=function(){if(!b.hFlag){b.hFlag=1;o.cb();}};}l=o.loc||"head";c=a.getElementsByTagName(l)[0];if(c){utag.DB("Attach to "+l+": "+o.src);if(l==="script"){c.parentNode.insertBefore(b,c);}else{c.appendChild(b);}}};}else{u.loader=utag.ut.loader;}
u.ev={'view':1,'link':1};u.initialized=false;u.map={"sociomantic_event":"event_type","sociomantic_product_id":"product_ids","email_hash":"customer_mhash","customer_id":"customer_id"};u.extend=[function(a,b){if(b["dom.url"]=="http://www.uggaustralia.co.uk/"||b["dom.url"]=="http://uggaustralia.co.uk/"||b.pipeline_name.indexOf("Home-Show")>-1||b.pipeline_name.indexOf("Default-Start")>-1){b.sociomantic_event="page";}else if(b.page_type.indexOf("category")>-1){b.sociomantic_event="category";b._ccat=[b.page_category];}else if(b.page_type.indexOf("product")>-1){b.sociomantic_event="product";}else if(b.page_name.indexOf("Cart-Show")>-1||b.pipeline_name.indexOf("Cart-Show")>-1){b.sociomantic_event="basket";}else if(b.page_name.indexOf("confirmation")>-1&&b.pipeline_name.indexOf("COSummary-Submit")>-1){b.sociomantic_event="sale";}},function(a,b){if(1){b['_ccurrency']='GBP'}},function(a,b){if(b.sociomantic_event=="product"){b.sociomantic_product_id=[];if(b._cprod[0].length>4&&b._csku[0].indexOf('-')>-1){b.sociomantic_product_id[0]=b._csku[0].split('-')[0]}}}];u.send=function(a,b){if(u.ev[a]||typeof u.ev.all!="undefined"){var c,d,e,f,i;u.data={"adv_token":"uggaustralia-uk","event_type":"page","region":"eu","base_url":"-sonar.sociomantic.com/js/2010-07-01/adpan/","timestamp":"","sociomantic_prefix":"","order_id":"","order_subtotal":"","currency":"","country":"","product_ids":[],"product_names":[],"product_brands":[],"product_categories":[],"product_quantities":[],"product_prices":[],"product_discounts":[],"product_sale_prices":[],"product_description":"","product_url":"","product_photo_url":"","product_valid":"","product_score":"","confirmed_sale":"","lead_type":"","lead_transaction":"","customer_id":"","customer_mhash":"","customer_targeting":"","customer_agegroup":"","customer_gender":"","customer_education":"","customer_segment":""};for(c=0;c<u.extend.length;c++){try{d=u.extend[c](a,b);if(d==false)return}catch(e){}};for(d in utag.loader.GV(u.map)){if(typeof b[d]!="undefined"&&b[d]!=""){e=u.map[d].split(",");for(f=0;f<e.length;f++){u.data[e[f]]=b[d];}}}
var product=u.data.sociomantic_prefix+"product";window[product]={};var basket=u.data.sociomantic_prefix+"basket";window[basket]={};var sale=u.data.sociomantic_prefix+"sale";window[sale]={};var lead=u.data.sociomantic_prefix+"lead";window[lead]={};var customer=u.data.sociomantic_prefix+"customer";window[customer]={};if(u.data.timestamp===""){u.data.timestamp=new Date().getTime();}
if(u.data.order_id===""&&b._corder!==undefined){u.data.order_id=b._corder;}
if(u.data.order_subtotal===""&&b._csubtotal!==undefined){u.data.order_subtotal=b._csubtotal;}
if(u.data.currency===""&&b._ccurrency!==undefined){u.data.currency=b._ccurrency;}
if(u.data.customer_id===""&&b._ccustid!==undefined){u.data.customer_id=b._ccustid;}
if(u.data.country===""&&b._ccountry!==undefined){u.data.country=b._ccountry;}
if(u.data.product_ids.length===0&&b._cprod!==undefined){u.data.product_ids=b._cprod.slice(0);}
if(u.data.product_names.length===0&&b._cprodname!==undefined){u.data.product_names=b._cprodname.slice(0);}
if(u.data.product_brands.length===0&&b._cbrand!==undefined){u.data.product_brands=b._cbrand.slice(0);}
if(u.data.product_categories.length===0&&b._ccat!==undefined){u.data.product_categories=b._ccat.slice(0);}
if(u.data.product_quantities.length===0&&b._cquan!==undefined){u.data.product_quantities=b._cquan.slice(0);}
if(u.data.product_prices.length===0&&b._cprice!==undefined){u.data.product_prices=b._cprice.slice(0);}
if(u.data.product_discounts.length===0&&b._cpdisc!==undefined){u.data.product_discounts=b._cpdisc.slice(0);}
if(u.data.product_sale_prices.length===0&&u.data.product_prices.length>0&&u.data.product_discounts.length>0){for(i=0;i<u.data.product_prices.length;i++){if(u.data.product_discounts[i]===undefined||u.data.product_discounts[i]===""){u.data.product_discounts[i]="0.00";}
var sale_price=(parseFloat(u.data.product_prices[i])-parseFloat(u.data.product_discounts[i])).toFixed(2);u.data.product_sale_prices.push(sale_price);}}
u.build_data=function(){if(u.data.event_type==="category"){if(u.data.product_categories.length>0){window[product].category=u.data.product_categories;}
}else if(u.data.event_type==="product"){if(u.data.product_ids&&u.data.product_ids[0]){window[product].identifier=u.data.product_ids[0];}
}else if(u.data.event_type==="basket"){window[basket].products=[];for(i=0;i<u.data.product_ids.length;i++){var productObj={};if(u.data.product_ids&&u.data.product_ids.join){productObj.identifier=u.data.product_ids[i];}
if(u.data.product_prices&&u.data.product_prices.join){productObj.amount=u.data.product_prices[i];}
if(u.data.currency){productObj.currency=u.data.currency;}
if(u.data.product_quantities&&u.data.product_quantities.join){productObj.quantity=u.data.product_quantities[i];}
window[basket].products.push(productObj);}
}else if(u.data.event_type==="sale"){window[basket].products=[];for(i=0;i<u.data.product_ids.length;i++){var productObj={};if(u.data.product_ids&&u.data.product_ids.join){productObj.identifier=u.data.product_ids[i];}
if(u.data.product_prices&&u.data.product_prices.join){productObj.amount=u.data.product_prices[i];}
if(u.data.currency){productObj.currency=u.data.currency;}
if(u.data.product_quantities&&u.data.product_quantities.join){productObj.quantity=u.data.product_quantities[i];}
window[basket].products.push(productObj);}
if(u.data.order_id){window[basket].transaction=u.data.order_id;}
if(u.data.order_subtotal){window[basket].amount=u.data.order_subtotal;}
if(u.data.currency){window[basket].currency=u.data.currency;}
if(u.data.confirmed_sale===true||u.data.confirmed_sale==="true"){window[sale].confirmed=true;}
}else if(u.data.event_type==="lead"){if(u.data.lead_type==="a"||u.data.lead_type==="A"){window[lead].transaction=u.data.lead_transaction;}else{window[lead].confirmed=true;}
}else if(u.data.event_type==="crm"){window[customer].identifier=u.data.customer_id;if(u.data.customer_mhash!==""){window[customer].mhash=u.data.customer_mhash;}
if(u.data.customer_targeting!==""){window[customer].targeting=u.data.customer_targeting;}
if(u.data.customer_agegroup!==""){window[customer].agegroup=u.data.customer_agegroup;}
if(u.data.customer_gender!==""){window[customer].gender=u.data.customer_gender;}
if(u.data.customer_education!==""){window[customer].education=u.data.customer_education;}
if(u.data.customer_segment!==""){window[customer].segment=u.data.customer_segment;}}
if(b.user_registered==="true"&&b.user_authenticated==="true"){window[customer].identifier=u.data.customer_id;if(u.data.customer_mhash!==""){window[customer].mhash=u.data.customer_mhash;}}};u.loader_cb=function(){if(window[sale].confirmed===true||window[lead].confirmed===true){sociomantic.sonar.adv[u.data.adv_token].getConfirmed();}
if(!u.initialized){u.initialized=true;}else{sociomantic.sonar.adv[u.data.adv_token].track();}};if(!u.initialized){u.build_data();u.data.base_url="//"+u.data.region+u.data.base_url+u.data.adv_token;u.loader({"type":"script","src":u.data.base_url,"cb":u.loader_cb,"loc":"script","id":'utag_160'});}else{sociomantic.sonar.adv[u.data.adv_token].clear();u.build_data();u.loader_cb();}
}};utag.o[loader].loader.LOAD(id);})('160','deckers.ugg-uk');}catch(e){}
