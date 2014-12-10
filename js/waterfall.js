/*ajax请求*/


/*整理数据函数*/

/*虚拟数据*/

// var item = [{
// 	pic : "img/001.jpg"
// },{
// 	pic : "img/002.jpg"
// },{
// 	pic : "img/003.jpg"
// },{
// 	pic : "img/004.jpg"
// },{
// 	pic : "img/005.jpg"
// },{
// 	pic : "img/006.jpg"
// },{
// 	pic : "img/007.jpg"
// },{
// 	pic : "img/008.jpg"
// },{
// 	pic : "img/009.jpg"
// },{
// 	pic : "img/010.jpg"
// },{
// 	pic : "img/011.jpg"
// },{
// 	pic : "img/012.jpg"
// },{
// 	pic : "img/013.jpg"
// },{
// 	pic : "img/014.jpg"
// },{
// 	pic : "img/015.jpg"
// },{
// 	pic : "img/016.jpg"
// },{
// 	pic : "img/017.jpg"
// },{
// 	pic : "img/018.jpg"
// },{
// 	pic : "img/019.jpg"
// },{
// 	pic : "img/020.jpg"
// }];

var count = 0;  //监控整个页面上的产品数量

var item = null;
$.post("php/waterfall.php",{page : count},function(data){
	var tempdata = data.substr(1,data.length);
	item = JSON.parse(tempdata);
	console.log(item);
	addDom();
	initSmallBlock();
});

var compareArray = [];

/*使用数据初始化每一小块函数*/

function initSmallBlock() {

	var index0 = count - item.length ;

	var num = item.length;  //当前刷新时要添加的数量

	for (var i = 0; i < item.length; i++) {

		var img = $("#main .pin .box .box-img img").eq(index0);
		var price = $(".z-price").eq(index0);
		var like = $(".z-love span").eq(index0);
		var title = $("#z-title span").eq(index0);
		/*修改价格*/
		var fPrice = "￥" + item[i].curprice;
		price.text(fPrice);

		/*修改like数量*/
		like.text(item[i].sellnum);
		title.text(item[i].name);

		/*渲染评论开始*/

		for (var j = 0; j < item[i].comment.length; j++) {
			/*渲染评论*/
			var name = $(".who-comment span").eq(index0);
			var commt = $(".comment-what span").eq(index0);

			name.text(item[i].comment[j].username);
			commt.text(item[i].comment[j].detail);


		};


		img.attr("src", item[i].imgurl);
		img.load(function(){
			num--;
			if (!num){
					initOrderImg();
					var index1 = count - item.length;
					for (var i = 0; i < item.length; i++) {
						var box = $(".box").eq(index1);
						// var img = $("#main .pin .box .box-img img").eq(index1);
						// img.css({opacity: 1});
						box.css({opacity:1});
						index1++;
					};
			}
		});
		index0++;
	};
	return false;
}

/*将每一小块加入dom的函数*/

function addDom() {
	//每一小块代码
	var sBlock = "<div class=\"pin\"><div class=\"box\"><div class=\"box-img\"><img src=\"\"></div><div id=\"z-like\"><span class=\"z-price\">￥100</span><span class=\"z-love\"><img src=\"img/love.png\"/><span>100</span></span></div><div id=\"z-title\"><img src=\"img/qianyin.png\"><span>向超然是个大傻逼你知道吗，好吧你好像不知道</span><img src=\"img/houyin.png\"> </div><div id=\"divide-line\"><img src=\"img/z-line.png\"></div><div id=\"comment\"><div class=\"sub-comment\"><div class=\"who-comment\"><span>向超然</span></div><div class=\"comment-what\"><span>我是个大傻逼</span></div></div></div></div></div>";
	// var $parent = $("#main"); //获取父级对象
	for (var i = 0; i < item.length; i++) {
		var sb = $(sBlock);
		$("#main").append(sb);
		count++;
	};
}

/*初始化排序*/

function initOrderImg(){
	var $parent = $("#main"); //获取父级对象
	var aPin = $("#main .pin");
	var num = 4;
	var index = count - item.length;
	for (var i = 0; i < item.length; i++) {

		if (index < num ) {
			//第一行元素
			compareArray[index] = aPin[index].offsetHeight;
		}
		else{
			handleReceivedImg(index);
		};
		index++;
	}
	
}

/*為剛加入的item準備排序*/
// function initAddOrder(){

// 	var index = count -15;
// 	for (var i = 0; i < item.length; i++) {

// 		handleReceivedImg(index);
// 		index++;

// 	};
// }

/*排序计算*/

function handleReceivedImg(n){
	var $parent = $("#main"); //获取父级对象
	var aPin = $("#main .pin");
	var num = 4;
	//获取成行元素中最低的
	var minHeight = Math.min.apply('',compareArray);
	//alert(compareArray + ",min=" + minHeight);
	//获取最低的那个的元素索引
	var minHkey = getMinHeightKey(compareArray,minHeight);
	//为新增瀑布定位
	aPin[n].style.position = "absolute";
	aPin[n].style.top = minHeight +"px";
	aPin[n].style.left = aPin[minHkey].offsetLeft +'px';
	compareArray[minHkey] += aPin[n].offsetHeight;
}
function getMinHeightKey(arr, minH) {
	for (key in arr) {
		if (arr[key] == minH) {
			return key;
		}
	}
}

function checkScrollSite() {

	var aPin = $("#main .pin");

	//加载数据依赖最后一个瀑布流块变化
	var lastPinHeight = aPin[aPin.length - 1].offsetTop + Math.floor(aPin[aPin.length - 1].offsetHeight / 2);
	var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	//浏览器高度
	var documentH = document.documentElement.clientHeight;

	if (lastPinHeight < documentH + scrollTop) {
 		var $loading = $("#loading");
 		var loadHeight = aPin[aPin.length-1].offsetTop + aPin[aPin.length - 1].offsetHeight +'px';
 		$loading.css("top",loadHeight);
 		$loading.css("display","block");
		return true;
	}
	return false;
}

function requestItem(){
	$(window).unbind();
	$.post("php/waterfall.php",{page : count},function(data){
			var tempdata = data.substr(1,data.length);
			item = JSON.parse(tempdata);
			console.log(item);
			$("#loading").css("display","none");
			addDom();
			initSmallBlock();
			$(window).scroll(onScroll);
		})
}

function onScroll(){
	checkScrollSite();
	if(checkScrollSite()==true){
		requestItem();
	}
}

$(window).scroll(onScroll);


