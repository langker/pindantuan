var posterData;
var tempdata;


var pageTotal;
var nowPage = 1;
var _class = location.search.substr(7,location.search.length);
posterList(0);
$(".page").click(function(){
	nowPage = parseInt($(this).find("a").text());
	posterList(1);
});
$(".nextPage").click(function(){

	nowPage = nowPage + 1;
	posterList(1);
});
$(".prePage").click(function(){

	nowPage = nowPage - 1;
	posterList(1);
});
if (_class=="ele") {
	$(".listFilterBox h2").text("电子设备");
	$("title").text("电子设备-拼单团");
	$(".listHeaderPoster img").attr("data-original","img/carousel2.jpg");
};
if (_class=="food") {
	$(".listFilterBox h2").text("吃货福利");
	$("title").text("吃货福利-拼单团");
	$(".listHeaderPoster img").attr("data-original","img/carousel1.jpg");
};
if (_class=="dorm") {
	$(".listFilterBox h2").text("寝室神器");
	$("title").text("寝室神器-拼单团");
	$(".listHeaderPoster img").attr("data-original","img/carousel3.jpg");
};
function posterList(e){
	$.post( "php/posterListfunction.php", {class:e,page:nowPage,classify:_class},function( data ) {
		var tempdata = data.substr(1,data.length);
		posterData = JSON.parse(tempdata);

		if (posterData[0]%40 != 0) {
			pageTotal = parseInt(posterData[0]/40) + 1; 
		}else{
			pageTotal = posterData[0]/40;
		};
		$(".listGoods li").show();
		for (var i =(posterData.length-1); i < 40; i++) {
			$(".listGoods li:eq("+i+")").hide();
		};



		for (var i = 0; i < (posterData.length -1); i++) {

			$(".listGoodsItem h3 a:eq("+i+")").attr("href",posterData[i+1].url);
			$(".listGoodsItemImg:eq("+i+")").attr("href",posterData[i+1].url);
			$(".listGoodsItemImg img:eq("+i+")").attr("data-original",posterData[i+1].pic.pic1);
			$(".listGoodsItem h3 a:eq("+i+")").text(posterData[i+1].title);

			$(".nowprice span:eq("+i+")").text("¥"+posterData[i+1].newPrice);
			$(".oriprice span:eq("+i+")").text("¥"+posterData[i+1].oriPrice);
			$(".sales span:eq("+i+")").text(posterData[i+1].sales);

		};
		$("img.lazy").lazyload({effect: "fadeIn"});
		// showGoods();
		pageF();
		$('body,html').animate({scrollTop:0},600);
		  		// searchlist的回调函数
		  		// 0:销量
		  		// 1:价格低到高
		  		// 2:高到低
	});
}



$(".listFilter a:eq(0)").click(function(){
	nowPage = 1;
	posterList(0);
});

var pri = 1;
$(".listFilter a:eq(1)").click(function(){
	nowPage = 1;
	pri++;
	var a = pri%2;
	if (a==0) {
		posterList(1);
	}else{
		posterList(2);
	};
	
});





