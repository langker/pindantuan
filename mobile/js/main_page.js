(function(){
	var artHtml = '<div class=\"article-item\"><a class=\"link1\"><img class="artImg" src=\"img/1.jpg\"></a><a class=\"link2\"><p class=\"a-title\">如何找到你合适的短袖衬衫呵呵呵呵呵呵呵呵呵呵呵</p></a><p class=\"time\">2014.10.14</p><div class=\"zan\"><span class=\"phase\">vol.1</span><img src=\"img/zan.png\"><span class=\"like\">21</span></div></div>';
	var underLine = '<div class=\"setLine\"><img src=\"img/line.png\"></div>';
	var article = [];
	$.ajax({
		type : "post",
		url : "php/index.php",
		data : { func : "init" }
	}).done(function(data){
		var temp = data.substr(1);
		var all = $.parseJSON(temp);
		article = all.article;
		addDom();
		renderData();
	})
	// var article = [
	// 	{
	// 		pic : "img/1.jpg",
	// 		tittle : "如何为你的女朋友挑选礼物",
	// 		data : "2014-10-18",
	// 		like : "30",
	// 		url : "http://www.taobao.com",
	// 		phase : "第一期"
	// 	}
	// ];
	function addDom(){
		for (var i = 0; i < article.length; i++) {
			$(".article").append(artHtml);
			$(".article").append(underLine);
		};
	}
	function renderData(){
		for (var i = 0; i < article.length; i++) {
			$(".artImg").eq(i).attr("src" , article[i].pic);
			$(".a-title").eq(i).text(article[i].titile);
			$(".time").eq(i).text(article[i].data);
			$(".like").eq(i).text(article[i].like);
			$(".phase").eq(i).text("vol." + article[i].phase);
			$(".link1").eq(i).attr("href",article[i].url);
			$(".link2").eq(i).attr("href",article[i].url);
		};
	}
})();
