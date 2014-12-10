var settlementData;

var _address;
var _phone;
var _name;
var nameFlag = 0;
var addressFlag = 0;
var phoneFlag = 0;



// 整理成一个一维数组
var _num = [];
var _oriPrice = new Array();
var _newPrice = new Array();
var _url = new Array();
var _buyUrl = new Array();
var _status = new Array();
var _goodDetailUrl = new Array();
var _optionName = new Array();
var _optionValue = new Array();



var order = new Array(1);
var itemModel= $("<div><li class=\"pure-g-r orderUnpaidItem\"><div class=\"baseInfo pure-u-2-5\"><a href=\"\"><img src=\"test.png\"></a><p><a href=\"\" class=\"title\"></a><br><span class=\"parameter\"></span></p></div><div class=\"newPrice pure-u-1-5\"><span></span></div><div class=\"itemNum pure-u-1-5\"><span>3</span></div><div class=\"priceTotal pure-u-1-5\"><span></span></div></li></div>");
var orderUnpaidList = $(".orderUnpaidList");

var baseInfoImg = $(".baseInfo img");
var baseInfoImgHref = $(".baseInfo a");
var baseInfoTitleHref = $(".baseInfo a");
var baseInfoTitle = $(".title");
var baseInfoParameter = $(".parameter");
var newPrice = $(".newPrice span");
var itemNum = $(".itemNum  span");
var priceTotal = $(".priceTotal span");
var _baseAddress;
var _goodssid=[];
var a = [];
var b = [];
var c = "";
if (window.location.search.substr(1,6)=="bucket") {
	var m = window.location.search.substr(8,window.location.search.length).indexOf("%");
	// var n = window.location.search.substr(m+9, window.location.search.length);
	a = window.location.search.substr(8,m).split("&");
	b = window.location.search.substr(m+9, window.location.search.length).split("&");
	c = "bucketid";
}else{
	var a = window.location.search.split("&")[0].substr(1,window.location.search.split("&")[0].length);
	var b =window.location.search.split("&")[1];
	var c = "goodsid";
};
$.post( "php/settlementfunction.php",{func:"GetInfo",goodsid:a,num:b,buynow:c}, function( data ) {
	var tempdata = data.substr(4,data.length);
	settlementData = JSON.parse(tempdata);


	_address = settlementData.rece.address;
	_phone = settlementData.rece.tel;
	_name = settlementData.rece.realName;
	if (_address!="") {
		addressFlag = 1;
	};
	if (_name!="") {
		nameFlag = 1;
	};
	if (_phone!="") {
		phoneFlag = 1;
	};
	
	//检测收货人是否正确
	if (phoneFlag&&nameFlag&&addressFlag){
			$(".payGo").removeAttr("disabled"); 
	}

	var q = _address.indexOf("校区") + 2;
	var lengthOfAddress = _address.length;
	var  _baseAddress = _address.substr(0,q);
	var _lastAddress = _address.substr(10,lengthOfAddress);
	$("input[name='area']").val("电子科技大学沙河校区");

	$(".baseAddress").text("电子科技大学沙河校区");
	$(".lastAddress").val(_lastAddress);
	$(".realName input").val(_name);
	$(".phone input").val(_phone);

	var method = settlementData.method; 

	if (method==0) {
		$("input[name='address']").val(settlementData.rece.address);
		$("input[name='area']").val("电子科技大学沙河校区");
		$("input[name='name']").val(settlementData.rece.realName);
		$("input[name='phone']").val(settlementData.rece.tel);
		// _goodssid[0] = settlementData.goods.goodssid;
		$("<p><input type=\"text\" name=\"goodsid[]\" /></p>").insertBefore(".payGo");

		$("<p><input type=\"text\" name=\"num[]\" /></p>").insertBefore(".payGo");

		// $("form").append("<p><input type=\"text\" name=\"goodsid[]\" /></p>");
		// $("form").append("<p><input type=\"text\" name=\"num[]\" /></p>");
		$("input[name='buynow']").val("goodssid");
		$("input[name='goodsid[]']").eq(0).val(settlementData.goods.goodssid);
		var tempItemModel = itemModel.html();
		$(".orderUnpaid").append(tempItemModel);
		$(".baseInfo img").attr("src",settlementData.goods.pic.pic1);
		$(".title").text(settlementData.goods.goodsTitle.substr(0,20)+"      ");
		$(".title").attr("href",settlementData.goods.url);

		$(".newPrice span").text("¥"+settlementData.goods.newPrice);
		// $("input[name='_num[]']").eq(0).val(settlementData.goods.num);
		// _num[0] = settlementData.goods.num;
		$("input[name='num[]']").eq(0).val(settlementData.goods.num);
		$(".itemNum span").text(settlementData.goods.num);
		$(".priceTotal span").text("¥"+settlementData.goods.num*settlementData.goods.newPrice);
		var opt="";
		for (var i = 0; i < settlementData.goods.optionName.length; i++) {
			if (settlementData.goods.optionName[i] != "") {
				opt = opt + (settlementData.goods.optionName[i] + ":" + settlementData.goods.optionValue[i]);
			};	
		};
		$(".parameter").text(opt.substr(0,opt.length));
		$(".payInfo span:eq(0)").text(((settlementData.goods.oriPrice-settlementData.goods.newPrice)*settlementData.goods.num).toFixed(2));
		$(".payInfo span:eq(1)").text("¥"+(settlementData.goods.num*settlementData.goods.newPrice).toFixed(2));
	}else{
		$("input[name='buynow']").val("bucketid");
		$("input[name='address']").val(settlementData.rece.address);
		$("input[name='area']").val("电子科技大学沙河校区");
		$("input[name='name']").val(settlementData.rece.realName);
		$("input[name='phone']").val(settlementData.rece.tel);
		
		for (var j = 0; j < settlementData.bucket.length; j++) {
			$("form").append("<p><input type=\"text\" name=\"goodsid[]\" /></p>");
			$("input[name='goodsid[]']").eq(j).val(settlementData.bucket[j].classify[0].goodssid);


			$("form").append("<p><input type=\"text\" name=\"num[]\" /></p>");
			$("input[name='num[]']").eq(j).val(settlementData.bucket[j].goods.num);
			// var tempGoodssid = settlementData.bucket[j].classify[0].goodssid + "&";
			// _goodssid.push(tempGoodssid);
			// _num.push(settlementData.bucket[j].goods.num);
			var tempItemModel = itemModel.html();
			$(".orderUnpaid").append(tempItemModel);
			$(".baseInfo img:eq("+j+")").attr("src",settlementData.bucket[j].goods.pic);
			$(".title:eq("+j+")").text(settlementData.bucket[j].goods.title);
			$(".title:eq("+j+")").attr("href",settlementData.bucket[j].goods.url);
			$(".newPrice:eq("+j+") span").text("¥"+settlementData.bucket[j].classify[0].nowprice);
			$(".itemNum:eq("+j+") span").text(settlementData.bucket[j].goods.num);
			$(".priceTotal:eq("+j+") span").text("¥"+settlementData.bucket[j].goods.num*settlementData.bucket[j].classify[0].nowprice);
			var opt ="";
			for (var i = 0; i < settlementData.bucket[j].goods.optionName.length; i++) {
				if ((settlementData.bucket[j].goods.optionName[i] != "") &&(settlementData.bucket[j].goods.optionName[i] != undefined)){
					var yy = settlementData.bucket[j].goods.optionName[i] + ":" + settlementData.bucket[j].classify[0].class[i];
					opt = opt + yy;
				};	
			};
			$(".parameter").eq(j).text(opt);
			opt="";
		};
		// 
		// $("input[name='goodsid']").val(_goodssid);
		// $("input[name='num']").val(_num);
		var _NewPriceTotal = 0;
		var _OriPriceTotal = 0;
		for (var i = 0; i < settlementData.bucket.length; i++) {
			_OriPriceTotal = _OriPriceTotal + settlementData.bucket[i].classify[0].orgiprice*settlementData.bucket[i].goods.num;
			_NewPriceTotal =  _NewPriceTotal + settlementData.bucket[i].classify[0].nowprice*settlementData.bucket[i].goods.num;
		};
		$(".payInfo span:eq(0)").text("¥"+(_OriPriceTotal - _NewPriceTotal).toFixed(2));
		$(".payInfo span:eq(1)").text("¥"+_NewPriceTotal.toFixed(2));
	};




});

// 插入数据

var flag = 0;
$(".baseAddress").text($(".location a").text());

$(".allAddress a").click(function(){
	$(".baseAddress").text($(this).text());
	_baseAddress = $(this).text();
	// post 当前地址
});



//检测收货地址是否正确

$(".lastAddress").blur(function(){
	if (!$(this).val()) {
		addressFlag = 1;
		return false;
	};
	if ($(this).val().trim().match(/^(\w|[\u4E00-\u9FA5])*$/)){
		addressFlag = 1;
		_address = _baseAddress + $(this).val();
		$("input[name='address']").val( $(".baseAddress").text() + $(".lastAddress").val());
		if (phoneFlag&&nameFlag&&addressFlag){
			$(".payGo").removeAttr("disabled"); 
		}
		addressFlag = 1;
		$(".myAddress img").css("display","inline-block");
		$(".myAddress b").text("");
		return false;
	}else{
		addressFlag = 0;
		$(".myAddress b").text("收货地址只能由中英文、数字组成");
		$(".myAddress img").css("display","none");
		return false;
	};
});

$(".realName input").blur(function(){
	if (!$(this).val()) {
		$(".realName span").text("不能为空");
		return false;
	};
	if ($(this).val().match(/^(\w|[\u4E00-\u9FA5])*$/)){
		nameFlag = 1;
		_name = $(this).val();
		$(".realName span").text("");
		$(".realName img").css("display","inline-block");
		$("input[name='name']").val($(".realName input").val());
		if (phoneFlag&&nameFlag&&addressFlag){
			$(".payGo").removeAttr("disabled"); 
		}
		return false;
	}else{
		nameFlag = 0;
		$(".realName span").text("用户名只能由中英文、数字组成");
		$(".realName img").css("display","none");

		return false;
	};
});

//检测收货电话是否正确
$(".phone input").blur(function(){
	if (!$(this).val()) {
	$(".phone span").text("不能为空");
		return false;
	};
	if ($(this).val().match(/^0?(13[0-9]|15[012356789]|18[0236789]|14[57])[0-9]{8}$/)) 
	{
		phoneFlag = 1;
		_phone= $(this).val();
		$(".phone span").text("");
		$(".phone img").css("display","inline-block");
		$("input[name='phone']").val($(".phone input").val());
		if (phoneFlag&&nameFlag&&addressFlag){
			$(".payGo").removeAttr("disabled"); 
		}
		return false;
	}else{
		phoneFlag = 0;
		$(".phone span").text("请输入正确的手机号码");
		$(".phone img").css("display","none");
		return false;
	};
	
});

var payFlag = 1;

// var goodsidTemp = "<p><input type=\"text\" name=\"goodsid\"/></p>";

// for (var i = 0; i < Things.length; i++) {
// 	Things[i]
// };


$("input[name='func']").val("BuyNow");
$(".payGo").click(function(){
	if (phoneFlag&&nameFlag&&addressFlag) {
		// var tempAddress = $(".baseAddress").text()+ $(".lastAddress").val();
		if (payFlag) {
			payFlag = 0;
			$("#afterPay").css("display","block");
			// $(".payGo").attr("disabled","disabled");
			// $.post( "php/settlementfunction.php", {func:"BuyNow",goodsid:_goodssid,num:_num},function( data ) {
			// 	,cellphone:_phone,realname:_name,address:tempAddress
			// 	$(".payGo a").attr("href","http://www.zhifubao.com");
			// });
		};
		
	}else{
		$(".payGo span").text("收货信息有误");
		$('body,html').animate({scrollTop:0},1000);
	};
});

$(".lastAddress").focus(function () {
	$(".payGo span").text("");
});
$(".realName input").focus(function () {
	$(".payGo span").text("");
});
$(".phone input").focus(function () {
	$(".payGo span").text("");
});



$(".payOver").click(function(){
	$("#afterPay").css("display","none");
});
$(".pagAgain").click(function(){
	location.reload();
});
