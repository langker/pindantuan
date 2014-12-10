var _address;
var headerData;

var vistedThr = "";
var vistedSec = "";
var vistedFir = "";

$(".listD li a").click(function(){
	var _href ="searchList.php?"+$(this).text()
	$(this).attr("href",_href);
});



if (window.location.pathname=="/detail.php") {
	var _nowVisted = window.location.search.substr(4,window.location.search.length);
	if (document.cookie.substr(45,document.cookie.length).length==0) {
		document.cookie = "visted=" + _nowVisted+vistedSec+vistedThr;
	};
	var _cookie = new Array();
	var c_p = document.cookie.indexOf("visted") + 7;
	_cookie[0] = document.cookie.substr(c_p,24);
	_cookie[1] = document.cookie.substr((c_p+24),24);
	_cookie[2] = document.cookie.substr((c_p+48),24);

	var repeatVisted = 0;
	for (var i = 0; i < 3; i++) {
		if (_cookie[i]== _nowVisted) {
			repeatVisted = i+1;
		};
	};

	switch (repeatVisted) {
		case (0):
			vistedFir = _nowVisted;
			vistedSec = _cookie[0];
			vistedThr = _cookie[1];

            break;
        case (1):
        	vistedFir = _cookie[0];
			vistedSec = _cookie[1];
			vistedThr = _cookie[2];

            break;
		case (2):
			vistedFir = _cookie[1];
			vistedSec = _cookie[0];
			vistedThr = _cookie[2];

			break;
		case (3):
			vistedFir = _cookie[2];
			vistedSec = _cookie[1];
			vistedThr = _cookie[0];

			break;
		default:
			vistedFir = "";
			vistedSec = "";
			vistedThr = "";
    };
    document.cookie = "visted=" + vistedFir+vistedSec+vistedThr;

}else{
	
	if (document.cookie.indexOf("visted")==-1) {
		$(".visted1").css("display","block");
		$(".visted1").html("你还没有浏览过商品");

	}else{
		var c_p = document.cookie.indexOf("visted") + 7;
		vistedFir = document.cookie.substr(c_p,24);
		vistedSec = document.cookie.substr((c_p+24),24);
		vistedThr = document.cookie.substr((c_p+48),24);
	};
	
};
var iCount;
var _username = "";
$(".log a").text("QQ登录");
function _header () {
	$.post("php/headerfunction.php",{func:"GetInfo"} ,function( data ) {

		  		var tempdata =data.substr(4,data.length);

		  		headerData = JSON.parse(tempdata);

		  		// 当前地址
		  		_address = headerData.address;
				_bucketNum = headerData.bucketNum;

				var lengthOfAddress = _address.length;
				var  _baseAddress = _address.substr(0,_address.indexOf("校区") + 2);
				$(".location a").text("电子科技大学沙河校区");
				// 购物车
				if (_bucketNum == "") {
					_bucketNum = 0;
				};

				$(".bucketNum").text(_bucketNum);

				// 我的订单
				// if (address=="") {
				// 	$("#chooseAddress")	.css("display","block");
				// };
				$(".myOrderHeader a").attr("href","myOrder.php");
				$(".myBucket a").attr("href","bucket.php");
				// 用户状态
				_username = headerData.username;
	
				if (_username == "") {
					$(".log a").text("QQ登录");
					$(".log a").attr("href","https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=101144437&redirect_uri=http://www.pindantuan.cn/php/callback.php&state=memeda");
				}else{
					
					$(".log a").text(_username);
					$(".log a").attr("href",'javascript:void(0)');
					$(".log").mouseover(function(){
						$(".log p").css("display","block");
					});
					$(".log").mouseout(function(){
						$(".log p").css("display","none");
					});
					// if (window.location.pathname=="/bucket.php"){
						// $(".emptybucket").css("display",none);
						// ajax_cart();
					// };
					// ||(window.location.pathname=="/myOrder.php")
					clearInterval(iCount);
				};
	});
}
_header();


$(".log").click(function(){
	iCount = setInterval(_header,1000);	
	if (_username == "") {
					$(".log a").text("QQ登录");
					$(".log a").attr("href","https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=101144437&redirect_uri=http://www.pindantuan.cn/php/callback.php&state=memeda");
				}
	// if ((window.location.pathname=="/bucket.php")||(window.location.pathname=="/myOrder.php")){
	// 	location.reload();
	// };
	// var _url = window.location.href;
	// $.post( "php/headerfunction.php",{func:"backurl",url:_url} ,function( data ) {
		// window.location.href="https://oauth.taobao.com/authorize?response_type=code&client_id=21784972&redirect_uri=http://pindantuan.cn/pindantuan/php/redirect_url.php&state=1212&view=web";
	// });
});
var vistedModel = $("<li></li>");
var vistedNothing = $("<li>你还没有浏览过商品</li>")
$(".visted").mouseover(function(){
	$(".vistedItems").css("display","block");
});
$("._visted").mouseover(function(){
	var _detailData;
	if (vistedFir.length) {
		$.post( "php/detailfunction.php", {func:"GetInfo",goodsid:vistedFir},function(data) {
			$(".visted1").css("display","block");
			var tempdata = data.substr(5,data.length);
			_detailData = JSON.parse(tempdata);
			$(".visted1 a").attr("href","http://www.pindantuan.cn/detail?id="+vistedFir);
			$(".visted1 span").text(_detailData.goods.title);
			$(".visted1 img").attr("src",_detailData.goods.pic.pic1);
		});
	}else{
		$(".visted1").css("display","block");
		$(".visted1").html("你还没有浏览过商品");
	};
	if (vistedSec.length) {
		$.post( "php/detailfunction.php", {func:"GetInfo",goodsid:vistedSec},function(data) {
				$(".visted2").css("display","block");
				var tempdata = data.substr(5,data.length);
				_detailData = JSON.parse(tempdata);
				$(".visted2").css("height","60px");
				$(".visted2 a").attr("href","http://www.pindantuan.cn/detail?id="+vistedSec);
				$(".visted2 span").text(_detailData.goods.title);
				$(".visted2 img").attr("src",_detailData.goods.pic.pic1);
		});
	};
	if (vistedThr.length) {
		$.post( "php/detailfunction.php", {func:"GetInfo",goodsid:vistedThr},function(data) {
				$(".visted3").css("display","block");
				var tempdata = data.substr(5,data.length);
				_detailData = JSON.parse(tempdata);
				$(".visted3").css("height","60px");
				$(".visted3 a").attr("herf","http://www.pindantuan.cn/detail?id="+vistedThr);
				$(".visted3 span").text(_detailData.goods.title);
				$(".visted3 img").attr("src",_detailData.goods.pic.pic1);
			});
	};
});
$(".visted").mouseout(function(){
	$(".vistedItems").css("display","none");
});

// function vistedF () {
// 	vistedItems.children().remove();
// 	if (vistedNum == 0) {
// 		if (headerData.username=="") {
// 			// 未登录状态下得最近浏览
// 			// vistedItems.append(_visted);
// 		}else{
// 			vistedItems.append(vistedNothing);
// 		};
// 	} else{
// 		var Name = [headerData.lastvisited[0].name1,headerData.lastvisited[0].name2,headerData.lastvisited[0].name3];
// 		var Web = [headerData.lastvisited[0].web1,headerData.lastvisited[0].web2,headerData.lastvisited[0].web3];
// 		var Photo = [headerData.lastvisited[0].photo1,headerData.lastvisited[0].photo2,headerData.lastvisited[0].photo3];
// 		for (var i = 0; i < vistedNum; i++) {
// 			var temp = vistedModel.html();
// 			vistedItems.append(temp);

			
// 			$(".vistedItems span:eq("+i+")").text(Name[i]);
// 			$(".vistedItems a:eq("+i+")").attr("href",Web[i]);
// 			$(".vistedItems img:eq("+i+")").attr("src",Photo[i]);
// 		};
// 	};
// }




// 切换地址
// $(".allAddress a").click(function(){

// 	$(".location a").text($(this).text()+" 切换");
// 	var _newAddress = $(this).text();
// 	$.post( "php/headerfunction.php", { func: "ChangeAddress", newAddress:_newAddress} ,function( data ) {
// 	});
// });


var inputBar = $(".search input");
var notInputBar = $(".headerContainer>div").not(".search");


inputBar.focus(function(){

	inputBar.css("border","none");
	notInputBar.css("display","none");
	$(".search").css("border","none");
	$(".search").animate({"margin-left":"10px"},300);
	$(".search").css("width","80%");
});

inputBar.blur(function(event){

	$(".search").animate({"margin-left":"483px"},0);
  	notInputBar.css("display","block");
 	$(".search").css("border","");
 	inputBar.css("border-bottom","1px solid white");
 	$(".search").css("width","199px");
});

// $(".address").mouseover(function(){
//  	$(".allAddress").css("display","block");
// });

// $(".address").mouseout(function(){
//  	$(".allAddress").css("display","none");
// });




var _keyword ="";

$(".search input").keypress(function (e) {
	_keyword = $(".search input").val();
	if (_keyword=="") {
		return;
	};
	var key = e.which; 
	if (key == 13) {
		window.location.href="searchList.php?"+$(".search input").val();
	}
});
$(".search img").click(function(){
	window.location.href="searchList.php?"+$(".search input").val();
});

function goTop(){
      $(window).scroll(function(e) {

          //若滚动条离顶部大于100元素
          if($(window).scrollTop()>300)
           $("#gotop").fadeIn(1000);//以1秒的间隔渐显id=gotop的元素
          else
              $("#gotop").fadeOut(1000);//以1秒的间隔渐隐id=gotop的元素
     });
 };
 $(function(){
     //点击回到顶部的元素
     $("#gotop").click(function(e) {
             //以1秒的间隔返回顶部
             $('body,html').animate({scrollTop:0},600);
    });
     $("#gotop").mouseover(function(e) {
         $(this).css("background","url(images/backtop2013.png) no-repeat 0px 0px");
     });
     $("#gotop").mouseout(function(e) {
         $(this).css("background","url(images/backtop2013.png) no-repeat -70px 0px");
     });
     goTop();//实现回到顶部元素的渐显与渐隐
 });
goTop();


$(".log p").click(function () {
	$.post( "php/headerfunction.php",{func:"quit"} ,function( data ) {
		window.location.reload();
	});
});

$(".myOrderHeader a").click(function () {
	if (headerData.username == "") {
		$(this).attr("href","javascript:void(0)");
		$(".dialog").css("display","block");
		return;
	}else{
		$(this).attr("href","myOrder.php");
	};
})
$(".dialog a").click(function () {
	iCount = setInterval(_header,1000);	
	$(".dialog").css("display","none");
})
$(".myBucket a").click(function () {
	if (headerData.username == "") {
		$(this).attr("href","javascript:void(0)");
		$(".dialog").css("display","block");
		return;
	}else{
		$(this).attr("href","bucket.php");
	};
})
$(".dialog p").click(function (){
	$(".dialog").css("display","none");
});
$("#serviceBar").click(function(){
	$("#service").animate({height:window.screen.availHeight+"px"});
	$("#service").animate({width:"200px"});
});
$(window).resize(function(){
	$("#service").animate({height:window.screen.availHeight+"px"});
});
$("#service span").click(function(){
	$("#service").animate({width:"0px"});
});
var scrollFlag = 1;
var navFlag = 1;
if ((window.location.pathname=="/index.php")||(window.location.pathname=="/") ){
	$("#nav").css("top","33px");
}else{
	$("#nav").css("top","-235px");
	// scrollFlag = 1;
	navFlag = 0;
};
$('body,html').css("scrollTop",0);

$("#navSwitch").click(function(){
	$("#nav").animate({top:(33+(navFlag%2)*(-270))+"px"});
	$("#carousel").animate({top:"33px"});
	$(".carouselPoint").animate({height:"0px"});
	if (scrollFlag) {
		scrollFlag = 0;
	};
	navFlag++;
});

 var scrollFunc = function (e) {  
 	if (navFlag%2) {
        e = e || window.event;  
        if (e.wheelDelta) {  //判断浏览器IE，谷歌滑轮事件               
            if (e.wheelDelta > 0) { //当滑轮向上滚动时  
                navFlag = 0; 
                return;
            }  
            if (e.wheelDelta < 0) { //当滑轮向下滚动时  
                $("#nav").animate({top:"-235px"},500);
		 	 	$("#carousel").animate({top:"33px"},500);
				$(".carouselPoint").animate({height:"0px"},500);
				setTimeout(function(){
					if (scrollFlag) {
						$('body,html').animate({scrollTop:0},300);
						scrollFlag = 0;
					};
				}, 500);
				navFlag = 0;
				return;
            }  
        } else if (e.detail) {  //Firefox滑轮事件  
	            if (e.detail> 0) { //当滑轮向上滚动时  
	            	$("#nav").animate({top:"-235px"},500);
			 	 	$("#carousel").animate({top:"33px"},500);
					$(".carouselPoint").animate({height:"0px"},500);
					setTimeout(function(){
						if (scrollFlag) {
							$('body,html').animate({scrollTop:0},300);
							scrollFlag = 0;
						};
					}, 500);
					navFlag = 0;
	                // navFlag = 0; 
	                // return;
	            }  
	            if (e.detail< 0) { //当滑轮向下滚动时  

	                $("#nav").animate({top:"-235px"},500);
			 	 	$("#carousel").animate({top:"33px"},500);
					$(".carouselPoint").animate({height:"0px"},500);
					setTimeout(function(){
						if (scrollFlag) {
							$('body,html').animate({scrollTop:0},300);
							scrollFlag = 0;
						};
					}, 500);
					navFlag = 0;
					return;
	            }  
	        }  
    	}
    }  
    //给页面绑定滑轮滚动事件  

	if (document.addEventListener) {//firefox  

	    document.addEventListener('DOMMouseScroll', scrollFunc, false);  
	}  
	    //滚动滑轮触发scrollFunc方法  //ie 谷歌  
	window.onmousewheel = document.onmousewheel = scrollFunc;


	//临时占用

	function setSave(){
			$(".saveM").mouseenter(function(){
				$(".left-arrow").fadeIn();
				$(".popover").fadeIn();
			})
			$(".saveM").mouseleave(function(){
				$(".popover").fadeOut();
				$(".left-arrow").fadeOut();
			})
		}
	setSave();

	(function(){
		$.post("php/headerfunction.php",{ func : "GetSaveMoney"},function(data){
			var s = '￥' + data;
			$(".saveM strong").text(s);
			$(".popover-money").text(s);
		})	
	})(); 



