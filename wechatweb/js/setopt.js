
var _optionName = new Array();
var _optionValue = new Array(5);
var detailData;
var _goodsid = location.search.substr(1,location.search.length);
var price;
$.post( "../php/detailfunction.php", {func:"GetInfo",goodsid:_goodsid},function(data) {
	
	var status;
	var tempdata = data.substr(5,data.length);
	// detailData = tempdata;
	detailData = JSON.parse(tempdata);
	$(".item p").text(detailData.goods.title);
	$(".item img").attr("src","../"+detailData.goods.pic.pic1);
	price = detailData.class[0].nowprice;
	$(".price span").text("价格：¥"+detailData.class[0].nowprice);
	var _optionName=detailData.goods.optionName;
	var _optionValue = new Array(5);
	_optionValue[0] = new Array();
	_optionValue[1] = new Array();
	_optionValue[2] = new Array();
	_optionValue[3] = new Array();
	_optionValue[4] = new Array();
	for (var i = 0; i < detailData.class.length; i++) {
		var _class = [detailData.class[i].class1,detailData.class[i].class2,detailData.class[i].class3,detailData.class[i].class4,detailData.class[i].class5];
		for (var j = 0; j < _optionName.length; j++) {
			if ((jQuery.inArray(_class[j],_optionValue[j])) == -1) {
				_optionValue[j].push(_class[j]);
			};
		};	
	};
	var optionModel = $("<div><ul><p></p></ul></div>");
	var optionDetailModel = $("<div><li></li></div>");

	for (var i = 0; i < _optionName.length; i++) {
		if (_optionName[i]=="") {
			return;
		};
		var tempOptionModel = optionModel.html();
		$(".opt").append(tempOptionModel);
		$(".opt p").eq(i).text(_optionName[i]);
		for (var j = 0; j < _optionValue[i].length; j++) {
			var tempOptionDetailModel = optionDetailModel.html();
			$(".opt ul:eq("+i+")").append(tempOptionDetailModel);
			$(".opt ul:eq("+i+") li:eq("+j+")").text(_optionValue[i][j]);
		};
	};

});
var _goodsNum = 1;
$(".num span:eq(0)").click(function(){
	if (_goodsNum > 1) {

		_goodsNum --;
	}
	$(".num p").text(_goodsNum );
	$(".price").text("价格：¥"+_goodsNum *price);
	
});
$(".num span:eq(1)").click(function(){
	_goodsNum ++;
	$(".num p").text(_goodsNum);
	$(".price").text("价格：¥"+_goodsNum *price);
});
var class1Flag = "testFlag";
var class2Flag = "testFlag";
var class3Flag = "testFlag";
var class4Flag = "testFlag";
var class5Flag = "testFlag";
var youhuo = 0;
var _goodssid ;
var _option = [0,0,0,0,0];

	$(document).on("tap",".opt li",function(){
			$(this).css("background","black");
			$(this).css("color","white");
			$(this).siblings().css("background","white");
			$(this).siblings().css("color","black");
			var _classIndex = $(this).parent().index();
			_option[_classIndex] = 1;

			var optionIndex = $(this).index()-1;
			_goodssid  = detailData.class[0].goodssid.substr(0,24)+"+"+optionIndex;
			// console.log(optionIndex);

			
			// // _optionValue[_classIndex][optionIndex];
		
			// 	switch (_classIndex)
			// 	{
			// 	case 0:
			// 		class1Flag=$(this).text();
			// 		console.log(class1Flag);
			// 		checkItem();
			// 	  break;
			// 	case 1:
			// 	  class2Flag=$(this).text();
			// 	  console.log(class1Flag);
			// 	  checkItem();
			// 	  break;
			// 	case 2:
			// 	  class3Flag=$(this).text();
			// 	  console.log(class1Flag);
			// 	  checkItem();
			// 	  break;
			// 	case 3:
			// 	  class4Flag=$(this).text();
			// 	  console.log(class1Flag);
			// 	  checkItem();
			// 	  break;
			// 	case 4:
			// 	  class5Flag=$(this).text();
			// 	  console.log(class1Flag);
			// 	  checkItem();
			// 	  break;
			// 	}


			// 	function checkItem () {
			// 		for (var i = 0; i < detailData.class.length; i++) {
			// 			if (
			// 				((detailData.class[i].class1 == class1Flag)||(class1Flag=="testFlag"))&&
			// 				((detailData.class[i].class2 == class2Flag)||(class2Flag=="testFlag"))&&
			// 				((detailData.class[i].class3 == class3Flag)||(class3Flag=="testFlag"))&&
			// 				((detailData.class[i].class4 == class4Flag)||(class4Flag=="testFlag"))&&
			// 				((detailData.class[i].class5 == class5Flag)||(class5Flag=="testFlag"))
			// 				) 
			// 			{
			// 				$(".price p").text("有货");
			// 				$(".price span").text("价格：¥"+detailData.class[i].nowprice);
			// 				youhuo = 1;
			// 				break;
			// 			}else{
			// 				$(".price p").text("无货");
			// 				youhuo = 0;
			// 			};
						
			// 		};
			// 	}				
	})
$(".buyNow").click(function(){
	if ($(".opt ul").length != (_option[0]+_option[1]+_option[2]+_option[3]+_option[4])) {
		alert("请选择商品参数")
		return;
	};
	var url="http://www.pindantuan.cn/wechatweb/submit.html"+"?"+_goodssid+"&"+_goodsNum;
	window.open(url,'_blank'); 
})




