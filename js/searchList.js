var listType=3;
var searchList;
var pageTotal;
var nowPage = 1;
_keyword = decodeURIComponent(window.location.search.substr(1,window.location.search.length));
$("title").text(_keyword+"-拼单团");
searchF();
$(".listHeaderSearch input").val(_keyword);
$(".listHeaderSearch input").keypress(function (e) {
	_keyword = $(".listHeaderSearch input").val();
	if (_keyword=="") {
		return;
	};
	var key = e.which; 
	if (key == 13) {
		window.location.href="searchList.php?"+$(".listHeaderSearch input").val();
	}
});

$(".listHeaderSearch img").click(function(){
	window.location.href="searchList.php?"+$(".listHeaderSearch input").val();
});

$(".listFilter a:eq(0)").click(function(){
	nowPage = 1;
	searchF(0);
});

var pri = 1;
$(".listFilter a:eq(1)").click(function(){
	nowPage = 1;
	pri++;
	var a = pri%2;
	if (a==0) {
		searchF(1);
	}else{
		searchF(2);
	};
	
});




$(".page").click(function(){
	nowPage = parseInt($(this).find("a").text());

	searchF(0);
});
$(".nextPage").click(function(){

	nowPage = nowPage + 1;
	searchF(0);
});
$(".prePage").click(function(){

	nowPage = nowPage - 1;
	searchF(0);
});


function searchF(e){
			$.post( "php/searchList.php",{key:_keyword,page:nowPage,order:e} ,function( data ) {
		  		var tempdata = data.substr(1,data.length);
				searchData = JSON.parse(tempdata);
				$(".noResult").css("display","none");
				if (searchData[0]==0) {
					$(".listGoods li").hide();

					$(".noResult").css("display","block");
				}else{

					if (searchData[0]%40 != 0) {
						pageTotal = parseInt(searchData[0]/40) + 1; 
					}else{
						pageTotal = searchData[0]/40;
					};
					$(".listGoods li").show();
					for (var i =(searchData.length-1); i < 40; i++) {
						$(".listGoods li:eq("+i+")").hide();
					};

				};

				$(".listFilterBox h2").text(_keyword);
				
				for (var i = 0; i < (searchData.length -1); i++) {

					// console.log("ok");
					$(".listGoodsItem h3 a:eq("+i+")").attr("href",searchData[i+1].url);
					$(".listGoodsItem h3 a:eq("+i+")").text(searchData[i+1].title);
					$(".listGoodsItemImg:eq("+i+")").attr("href",searchData[i+1].url);
					$(".listGoodsItemImg img:eq("+i+")").attr("data-original",searchData[i+1].pic.pic1);
					$(".listGoodsItem:eq("+i+")").innerText = searchData[i+1].title;

					$(".nowprice span:eq("+i+")").text("¥"+searchData[i+1].newPrice);
					$(".oriprice span:eq("+i+")").text("¥"+searchData[i+1].oriPrice);
					$(".sales span:eq("+i+")").text(searchData[i+1].sales);

				};

				$("img.lazy").lazyload({effect: "fadeIn"});
				pageF();
			});
			$('body,html').animate({scrollTop:0},600);
		}