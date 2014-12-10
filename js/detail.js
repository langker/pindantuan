
var itemPic = new Array(4);

var settlementUrl ="settlement.php";
var bucketUrl = "bucket.php";
var _option = new Array(5);

var _optionName = new Array();
var _optionValue = new Array(5);
_optionValue[0] = new Array();
_optionValue[1] = new Array();
_optionValue[2] = new Array();
_optionValue[3] = new Array();
_optionValue[4] = new Array();
var youhuo = 0;
var _goodsid = window.location.search.substr(4,window.location.search.length);
$.post( "php/detailfunction.php", {func:"GetInfo",goodsid:_goodsid},function(data) {
	
	var detailData;
	var status;
	var tempdata = data.substr(5,data.length);
	// detailData = tempdata;
	detailData = JSON.parse(tempdata);

	itemPic[0] = detailData.goods.pic.pic1;
	itemPic[1] = detailData.goods.pic.pic2;
	itemPic[2] = detailData.goods.pic.pic3;
	itemPic[3] = detailData.goods.pic.pic4;
	_itemName = detailData.goods.title;
	_sales = detailData.goods.sales;
	_storeName = detailData.goods.storeName;
	_TaobaoUrl = detailData.goods.url;


	// 图片
	$(".oriPrice p").text("¥"+detailData.goods.oriPrice);
	$(".nowPrice p").text("¥"+detailData.goods.newPrice);
	// var thumbnailsNum = 0;
	// for (var i = 0; i < 4; i++) {
	// 	if (itemPic[i]!="") {
	// 		thumbnailsNum = thumbnailsNum + 1;
	// 	};
	// };
	var thumbnailsModel = $("<div><li><img src=\"\"></li></div>");
	var thumbnails = $(".thumbnails");
	for (var i = 0; i < 4; i++) {
		if ((itemPic[i]!=undefined)&&(itemPic[i]!="")) {
			var tempThumbnails = thumbnailsModel.html();
			thumbnails.append(tempThumbnails);
			$(".thumbnails img:eq("+i+")").attr("src",itemPic[i]);
			if (i == 3){
		    	break;
		  	}
		}
		
	};
	$(".picCanvas img").attr("src",itemPic[0]);
	// 

	$(".info h4").text(_itemName);
	// $(window).bind('beforeunload',function(){
		// $.post( "php/detailfunction.php", {func:"GetInfo",goodsid:_goodsid,goodsname:_itemName},function(data) {});
	// });
	$("title").text(_itemName);
	$(".sales p").text(_sales);
	$(".oriPrice a").text(_storeName);
	$(".oriPrice a").attr("href",_TaobaoUrl);
	$(".thumbnails li").click(function() {

		var a = $(this).children("img").attr("src");
		$(".picCanvas img").attr("src",a);
		$(".thumbnails li").css("border","1px solid white");
		$(this).css("border","1px solid black");
	});

	$(".store span").text(_storeName);
	$(".detailOfItem a").attr("href",_TaobaoUrl);
	status = detailData.goods.status;


	var commentModel = $("<div><li><p class=\"commentName\"></p><p class=\"commemntTime\"></p><p class=\"commentConmtent\"></p></li></div>");
	var commentEmptyModel = $("<div><li>没有评论</li></div>");
	$(".comment h4").text("商品评论（"+detailData[0].length+"）");

	if (detailData[0].length == 0) {
		$(".comment ul").append(commentEmptyModel);
	}else{
		for (var i = 0; i < detailData[0].length; i++) {
			var temp = commentModel.html();
			$(".comment ul").append(temp);
			// var time = detailData[0][i].data.substr(0,4) + "-" + detailData[0][i].data.substr(4,2) + "-" + detailData[0][i].data.substr(6,2);
			$(".commentName:eq("+i+")").text(detailData[0][i].name);
			$(".commemntTime:eq("+i+")").text(detailData[0][i].data);
			$(".commentConmtent:eq("+i+")").text(detailData[0][i].contents);
		};
	};


	for (var i = 0; i < 5; i++) {
		if (detailData.goods.optionName[i]!="") {
			_optionName.push(detailData.goods.optionName[i]);
		};	
	};
	
	for (var i = 0; i < detailData.class.length; i++) {
		var _class = [detailData.class[i].class1,detailData.class[i].class2,detailData.class[i].class3,detailData.class[i].class4,detailData.class[i].class5];
		for (var j = 0; j < _optionName.length; j++) {

			if ((jQuery.inArray(_class[j], _optionValue[j])) == -1) {
				_optionValue[j].push(_class[j]);
			};
		};
		
	};

	var optionModel = $("<div><li class=\"parameterModel\"><span></span><ol></ol></li></div>");
	var optionDetailModel = $("<div><li></li></div>");

	for (var i = 0; i < _optionName.length; i++) {
		var tempOptionModel = optionModel.html();
		$(".parameter").append(tempOptionModel);
		$(".parameterModel:eq("+i+") span").text(_optionName[i]);
		for (var j = 0; j < _optionValue[i].length; j++) {
			var tempOptionDetailModel = optionDetailModel.html();
			$(".parameter ol:eq("+i+")").append(tempOptionDetailModel);
			$(".parameter ol:eq("+i+") li:eq("+j+")").text(_optionValue[i][j]);
		};
	};
	

	var class1Flag = "testFlag";
	var class2Flag = "testFlag";
	var class3Flag = "testFlag";
	var class4Flag = "testFlag";
	var class5Flag = "testFlag";

	$(".parameterModel li").click(function(){
			$(this).siblings().css("background","white");
			$(this).siblings().css("color","black");
			$(this).css("background","black");
			$(this).css("color","white");
			var _classIndex = $(this).parent().parent().index();
			_option[_classIndex] = $(this).text();
			$(".buy p").text("");

			var optionIndex = $(this).index();

			
			_optionValue[_classIndex][optionIndex];
		
				switch (_classIndex)
				{
				case 0:
					class1Flag=$(this).text();
					checkItem();
				  break;
				case 1:
				  class2Flag=$(this).text();
				  checkItem();
				  break;
				case 2:
				  class3Flag=$(this).text();
				  checkItem();
				  break;
				case 3:
				  class4Flag=$(this).text();
				  checkItem();
				  break;
				case 4:
				  class5Flag=$(this).text();
				  checkItem();
				  break;
				}


				function checkItem () {
					for (var i = 0; i < detailData.class.length; i++) {
						if (
							((detailData.class[i].class1 == class1Flag)||(class1Flag=="testFlag"))&&
							((detailData.class[i].class2 == class2Flag)||(class2Flag=="testFlag"))&&
							((detailData.class[i].class3 == class3Flag)||(class3Flag=="testFlag"))&&
							((detailData.class[i].class4 == class4Flag)||(class4Flag=="testFlag"))&&
							((detailData.class[i].class5 == class5Flag)||(class5Flag=="testFlag"))
							) 
						{
							$(".checkFlag").text("有货");
							$(".oriPrice p").text("¥"+detailData.class[i].orgiprice);
							$(".nowPrice p").text("¥"+detailData.class[i].nowprice);
							_goodssid = detailData.class[i].goodssid;
							youhuo = 1;
							break;
						}else{
							$(".checkFlag").text("无货");
							youhuo = 0;
						};
						
					};
				}				
	});






	// 右边商品基本信息
	var _goodsNum = 1;
	$(".goodsNum b:eq(0)").click(function(){
		if (_goodsNum > 1) {
			_goodsNum --;
		}
		$(".goodsNum input").val(_goodsNum);
	});
	$(".goodsNum b:eq(1)").click(function(){
		_goodsNum ++;
		$(".goodsNum input").val(_goodsNum);
	});
	$(".goodsNum input").blur(function(){
		_goodsNum = $(".goodsNum input").val();

		if (!_goodsNum.match(/^[1-9]\d*$/)) {
			_goodsNum = 1;
			$(".goodsNum input").val(_goodsNum);
		};

	});






	var blank_option;
	function checkOption() {	
		for (var i = 0; i < _optionValue.length; i++) {
			if (typeof _option[i] == "undefined") {
				blank_option = i;
				return(i);
				break;
			};
		};
	}

		
	var bucketFlag = 0;
	$(".addBucket").click(function(){
		if (headerData.username == "") {
			$(".dialog").css("display","block");
			return;
		};
		if (status == 0) {

			$(this).text("该商品已下架");
			return;
		};
		if (bucketFlag ==0) {
			checkOption();
			var realOptionLength = 0;
			for (var i = 0; i < 5; i++) {
				if (typeof _option[i] != "undefined") {
					realOptionLength++;
				};
			};
			if ($(".parameterModel").length == realOptionLength) {
				$(".buy p").text("");
				var a = _goodsNum.toString();
				if (youhuo ==1) {
					$.post( "php/detailfunction.php", {func:"AddBucket",goodssid:_goodssid,num:a,buynow:"bucketid"},function(data) {});
				}else{
					$(".buy p").text("该款无货，请重新选择");
					return;
				};
				_header();
				$(this).text("已加入购物车");
				$(this).css("color","red");
				$(this).css("background","black");

				
				
				bucketFlag = 1;
			}else{
				$(".buy p").text("请选择"+_optionName[blank_option]);
			};
		}else{
			$(this).text("已加入购物车");
			$(this).css("color","red");
			$(this).css("background","black");
			$(this).hover(function() {
				$(this).css("color","red");
				$(this).css("background","black");
			});
		};
		
	});
	var buyFlag = 0;
	$(".buyNow").click(function(){
		if (headerData.username == "") {
			$(".dialog").css("display","block");
			return;
		};
		if (status == 0) {
			$(this).text("该商品已下架");
			return;
		};
		if (buyFlag == 0) {
			checkOption();
			var realOptionLength = 0;
			for (var i = 0; i < 5; i++) {
				if (typeof _option[i] != "undefined") {
					realOptionLength++;
				};
			};
			if ($(".parameterModel").length == realOptionLength) {
				$(".buy p").text("");
				if (youhuo ==1) {
					$(".buyNow").attr("href",settlementUrl+"?"+_goodssid+"&"+_goodsNum);
					$.post( "php/detailfunction.php", {func:"BuyNow",goodssid:_goodssid,num:_goodsNum, buynow:"goodsid"},function(data) {});
				}else{
					$(".buy p").text("该款无货，请重新选择");
					return;
				};
				buyFlag =1;
			}else{
				$(".buy p").text("请选择"+_optionName[blank_option]);
			};
		}else{
			
		};
	});

	// 查看详情
	$(".addBucket").mouseover(function(){
		$(".addBucket").css("background","black");
		$(".addBucket").css("color","white");
		$(".buyNow").css("background","#f3f3f3");
		$(".buyNow").css("color","black");
		if (bucketFlag == 1) {
			$(this).text("查看购物车");
			$(this).attr("href",bucketUrl);
			$(".addBucket").css("background","black");
			$(".addBucket").css("color","red");
		};
	})
	$(".addBucket").mouseout(function(){
		if (bucketFlag == 1) {
			$(this).text("已加入购物车");
		};
	});
	$(".buyNow").hover(function(){
		$(".buyNow").css("background","black");
		$(".buyNow").css("color","white");
		if (bucketFlag==1) {
			$(".addBucket").css("background","black");
			$(".addBucket").css("color","red");
		}else{
			$(".addBucket").css("background","#f3f3f3");
			$(".addBucket").css("color","black");
		};
	});
});
