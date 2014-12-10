var listName = "女装";
var activityPic="img/testPoster.jpg"
var _sales = new Array();
var _oriPrice = new Array();
var _newPrice = new Array();
var _title = new Array();
var _url = new Array();
var _pic = new Array();



var listHeaderSearch = $(".listHeaderSearch");
var listHeaderMap = $(".listHeaderMap");
var listHeaderPoster = $(".listHeaderPoster");


$(".listHeaderSearch input").focus(function() {
	// $(".listHeaderSearch div").css("border","5px solid black");
	// $(".listHeaderSearch img").css("background","black");
});
$(".listHeaderSearch input").blur(function() {
	// $(".listHeaderSearch div").css("border","5px solid #f3f3f3");
	// 	$(".listHeaderSearch img").css("background","white");
});

$(".listFilterBox h2").innerText = listName;



// 展示商品结果

var listGoodsItem = $(".listGoodsItem");
var listGoodsItemName = $(".listGoodsItem h3 a");
var listGoodsItemImgHref = $(".listGoodsItemImg");
var listGoodsItemImgSrc = $(".listGoodsItemImg img");
var nowprice = $(".nowprice span");
var oriprice = $(".oriprice span");
var sales = $(".sales span");

function showGoods(){
	for (var i = 0; i < (41-posterData.length); i++) {

		listGoodsItemName[i].href = _url[i];
		listGoodsItemImgHref[i].href = _url[i];
		listGoodsItemImgSrc[i].src = _pic[i];
		listGoodsItemName[i].innerText = _title[i];

		nowprice[i].innerText = "¥"+_newPrice[i];
		oriprice[i].innerText = "¥"+_oriPrice[i];
		sales[i].innerText = _sales[i];
		console.log(i);

	};
}





// 分页

var prePage = $(".prePage");
var nextPage = $(".nextPage");
var pageNum = $(".page a");

// prePage.href="12" + nowPage - 1;
// nextPage.href="12" + nowPage + 1;
function pageF() {


	function pageNumOn (e) {
		$(".page a").css("background","white");
		$(".page a").css("color","black");
		pageNum[e].style.background = "black";
		pageNum[e].style.color = "white";
	}
	if (typeof(pageTotal) =="undefined") {
		nextPage.hide();
		prePage.hide();
		$(".page a").hide();
	};

	if (pageTotal > 5) {

		pageNum[0].innerText = 1;
		pageNum[0].href = "url" + 1;

		if (nowPage < 4) {
			$(".morePgae:eq(0)").hide();
			pageNumOn(nowPage-1);

			for (var i = 1; i < 4; i++) {
				pageNum[i].innerText = i + 1;
				// pageNum[i].href = "url"+ i - 1;
			};
		} else{
			pageNum[1].innerText = nowPage - 1;
			// pageNum[1].href = "url"+ (nowPage - 1);

			pageNum[2].innerText = nowPage;
			// pageNum[2].href = "url"+nowPage;

			pageNum[3].innerText = nowPage + 1;
			// pageNum[3].href = "url"+(nowPage + 1);

			pageNumOn(2);
		};
		if((pageTotal - nowPage) < 3){
			$(".morePgae:eq(1)").hide();
		};
		

		pageNum[4].innerText = pageTotal;
		// pageNum[i].href =  "url" + pageTotal;


	} else{
		$(".morePgae").hide();
		for (var i = 0; i < (5 - pageTotal); i++) {
			var D = 5 - i -1;
			$(".page:eq("+D+")").hide();
		};
		for (var i = 0; i < pageTotal; i++) {
			pageNum[i].innerText = i + 1;
			// pageNum[i].href =  "url"+ i;
		};
		pageNumOn(nowPage-1);
	};
	if (nowPage == 1) {
		prePage.hide();
	};
	if (nowPage == pageTotal) {
		nextPage.hide();
	};
}