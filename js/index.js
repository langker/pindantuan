
 var t=n=0,count,likeBoxWidth=0,likeSmallBox;
 var welcomeFlag=0;
 function showPic() {
 		n=n>=(count-1)?0:++n;
 		$(".carouselPoint li").eq(n).trigger('click'); 
 };
 $(document).ready(function () {
 	 if (document.cookie.indexOf("first")==-1) {
 	 	document.cookie="first=1";
		$(".welcome").css("display","block");
		welcomeFlag=1;
		$(".welcomeImg").eq(0).attr("src","img/welcome1.jpg");
	};
	$(".closeWelcome").click(function(){
		$(".welcome").fadeOut(1500);
	});
	$(".downWelcome").click(function(){
		welcomeFlag++;
		if(welcomeFlag<=3){
			$(".welcomeImg").eq(welcomeFlag-1).attr("src","img/welcome"+welcomeFlag+".jpg").css({"display":"none"}).fadeIn(2000);
			$(".welcomeImg").eq(welcomeFlag-2).fadeOut(2000);
			
			
		}
		else
			$(".welcome").fadeOut(1500);
		//$(".welcomePic img").eq(0).attr("src","img/welcome1.jpg")
	});
	$(".upWelcome").click(function(){
		welcomeFlag--;
		if(welcomeFlag>=1){
			$(".welcomeImg").eq(welcomeFlag).attr("src","img/welcome"+welcomeFlag+".jpg").css({"display":"none"}).fadeIn(2000);
			$(".welcomeImg").eq(welcomeFlag+1).fadeOut(2000);
			
			
		}
		else{
			welcomeFlag=1;
			$(".upWelcome").css("cursor","")
		}
			
		//$(".welcomePic img").eq(0).attr("src","img/welcome1.jpg")
	});
	var goodsId={};
	for(var i=0;i<4;i++){
		var idNum=$(".recommendRightBottom").eq(i).find("a").attr("href").indexOf("=")+1;
		goodsId[i]=$(".recommendRightBottom").eq(i).find("a").attr("href").substring(idNum);
	} 
	$.ajax({
		type:'post',
		url:'php/indexfunction.php',
		data:{"func":'recommendFunc',
			  "goodsId":goodsId,
		}
	}).done(function(data) {
		/*data=data.substring(1);*/
		goods=$.parseJSON(data);
		for(var i=0 ;i<4;i++){
			$(".recommendRightBottom").eq(i).find(".recommedGoodsTit").text(goods[i].title);
			$(".recommendRightBottom").eq(i).find(".recommendRightBottomMoreDetailTit").text(goods[i].title);
			$(".recommendRightBottom").eq(i).find(".recommendGoodsSale").find("p").eq(1).text(goods[i].sale);
			$(".recommendRightBottom").eq(i).find(".recommedGoodsPrice").find("p").eq(0).text(goods[i].price);
		}
	})
 	count=$("#carouselList a").length;
 	$("#carouselList a:not(:first-child)").hide();
 	/*$(".kindLikesPos").eq(0).css("display","block");*/
 	$(".kindsPos").eq(0).css("display","block");
	$("img").lazyload({

	　　 placeholder : "img/loading.gif",

	　　 effect　　　: "fadeIn"

	});
	 
 	$(".carouselPoint li").click(function() {
 		/*clearInterval(t);*/
 		var i=$(this).text()-1;
 		n=i;
 		if(i >= count)
 			return;
 		$("#carouselList a").filter(":visible").fadeOut(300).parent().children().eq(i).fadeIn(500); 
 		$(this).css({
 			"background-image":"url(img/circle-out.png)",
 			"margin-bottom":"-4px",
 			"position":"relative",
 			"bottom":"0px",
 			'height':'18px',
 			'width':'18px'}).siblings().css({
 				"background-image":"url(img/circle-in.png)",
 				"position":"relative",
 				"bottom":"0px",
 				'height':'18px',
 				"margin-bottom":"0px",
 				'width':'18px'});
 	});
 	t=setInterval("showPic()",4000)
 	$("#carousel").hover(function() {
 		clearInterval(t)
 	},function() {
 		t=setInterval("showPic()",4000)
 	});
 	for (var i =0; i <$(".like1th").length ; i++) {
 		likeBoxWidth+=($(".like1th").eq(i).width()+parseInt($(".like1th").eq(i).css("margin-right")));
 		if(i==(($(".like1th").length/2)-1))
 			likeSmallBox=0-likeBoxWidth;
 	};
 	$(".recommendRightBottom").mouseover(function(){
 		$(this).find(".recommendRightBottomDetail").css("display","none");
 		$(this).find(".recommendRightBottomMoreDetail").css("display","block");
 	});
 	$(".recommendRightBottom").mouseout(function(){
 		$(this).find(".recommendRightBottomDetail").css("display","block");
 		$(this).find(".recommendRightBottomMoreDetail").css("display","none");
 	});
 	$(".likeList").width(likeBoxWidth);
	$(".carouselL").click(function() {
		var now=$(".kindsPos:visible").index()-1;
		var next;
		var kindsBoxWidth=$(".kindsPos").width();
		var marginBox=parseFloat($(".kindsPos").css('margin-top'));
		var kindsBoxHeight=$(".kindsPos").eq(now).height()+marginBox;
		if(now==3){
			next=0;
			$(".kindsPos").eq(next).show();
	 	$(".kindsPos").eq(now).css({
	 		'top':'-'+kindsBoxHeight+'px',
	 	});
	 	$(".kindsPos").eq(next).css({
	 		'z-index':'0'
	 	});
		}	
		else{
			next=now+1;
	 	$(".kindsPos").eq(next).show();
	 	$(".kindsPos").eq(next).css({
	 		'top':'-'+kindsBoxHeight+'px',
	 		'z-index':'0'
	 	});
		};
		$(".kindsPos").eq(now).animate({
			'right':kindsBoxWidth+'px',
			'opacity':0
	 	},500,function() {
	 				$('.kindsPos').eq(now).removeAttr("style");
			 		$(".kindsPos").eq(now).css({
			 			'display':'none'
			 		});
			 		$('.kindsPos').eq(next).removeAttr("style");
			 		$(".kindsPos").eq(next).css({
			 			'display':'block'
			 		});
	 		  }
		);
	});
	$(".carouselR").click(function() {
	 	var now=$(".kindsPos:visible").index()-1;
	 	var next;
	 	var kindsBoxWidth=$(".kindsPos").width();
	 	var marginBox=parseFloat($(".kindsPos").css('margin-top'));
	 	var kindsBoxHeight=$(".kindsPos").eq(now).height()+marginBox;
	 	if(now==0){
	 		next=3;
	 		$(".kindsPos").eq(next).show();
		 	$(".kindsPos").eq(next).css({
		 		'top':'-'+kindsBoxHeight+'px',
		 		'z-index':'0'
		 	});
	 	}	 		
	 	else{
	 		next=now-1;
	 		$(".kindsPos").eq(next).show();
		 	$(".kindsPos").eq(now).css({
		 		'top':'-'+kindsBoxHeight+'px',
		 	});
		 	$(".kindsPos").eq(next).css({
		 		'z-index':'0'
		 	}); 	
	 	}
	 	$(".kindsPos").eq(now).animate({
	 		'left':kindsBoxWidth+'px',
	 		'opacity':0
		 	},500,function() {
		 				$('.kindsPos').eq(now).removeAttr("style");
				 		$(".kindsPos").eq(now).css({
				 			'display':'none'
				 		});
				 		$('.kindsPos').eq(next).removeAttr("style");
				 		$(".kindsPos").eq(next).css({
				 			'display':'block'
				 		});
		 		  }
	 	);
	 	$('.kindsPos').css('left', '');
	 });
	$(".carouselKindsL").click(function() {
		var now=$(".kindLikesPos:visible").index();
		var next;
		var kindsBoxWidth=$(".kindLikesPos").width();
		var marginBox=parseFloat($(".kindLikesPos").css('margin-top'));
		var kindsBoxHeight=$(".kindLikesPos").eq(now).height()+marginBox;

		if(now==3){
			next=0;
			$(".kindLikesPos").eq(next).show();
	 	$(".kindLikesPos").eq(now).css({
	 		'top':'-'+kindsBoxHeight+'px',
	 	});
	 	$(".kindLikesPos").eq(next).css({
	 		'z-index':'0'
	 	});
		}	
		else{
			next=now+1;
	 	$(".kindLikesPos").eq(next).show();
	 	$(".kindLikesPos").eq(next).css({
	 		'top':'-'+kindsBoxHeight+'px',
	 		'z-index':'0'
	 	});
		}

		$(".kindLikesPos").eq(now).animate({
			'right':kindsBoxWidth+'px',
			'opacity':0
	 	},800,function() {
	 				$('.kindLikesPos').eq(now).removeAttr("style");
			 		$(".kindLikesPos").eq(now).css({
			 			'display':'none'
			 		});
			 		$('.kindLikesPos').eq(next).removeAttr("style");
			 		$(".kindLikesPos").eq(next).css({
			 			'display':'block'
			 		});
	 		  }
		);
	})
	var goodsHeight;
	var goodsWidth;
	$(".goodsDiv").bind("mouseenter mouseleave",
	function(e) {

		var w = $(this).width();
		var h = $(this).height();
		var x = (e.pageX - this.offsetLeft-$(this).parents("#kindsWidth")[0].offsetLeft-$(this).parents(".kindsPos")[0].offsetLeft-$(this).parents("#kind")[0].offsetLeft - (w / 2)) * (w > h ? (h / w) : 1);
		var y = (e.pageY-$(this).parents("#kindsWidth")[0].offsetTop-$(this).parents(".kindsPos")[0].offsetTop - this.offsetTop-$(this).parents("#kind")[0].offsetTop - (h / 2)) * (h > w ? (w / h) : 1);
		var direction = Math.round((((Math.atan2(y, x) * (180 / Math.PI)) + 180) / 90) + 3) % 4;
		var eventType = e.type;
		/*var dirName = new Array('上方','右侧','下方','左侧');*/
		if($(this).parent().index()==1){
			goodsWidth=$(".goodsPic").width();
			goodsHeight=$(".goodsPic").height();
		}

		if(e.type == 'mouseenter'){
			
			switch (direction){
				case 0:
				$(this).find(".goodsDetail").show().css({
					'left':"0px",
					'top':'-'+goodsHeight+'px'
				});
				break;
				case 1:
				$(this).find(".goodsDetail").show().css({
					'left':goodsWidth+"px",
					'top':'0px'
				});
				break;
				case 2:
				$(this).find(".goodsDetail").show().css({
					'left':"0px",
					'top':goodsHeight+'px'
				});
				break;
				case 3:
				$(this).find(".goodsDetail").show().css({
					'left':'-'+goodsWidth+"px",
					'top':'0px'
				});
				break;
			};
			$(this).find(".goodsDetail").animate({
				"left":"0%",
				"top":"0px"
			},275);
			
		}else{
			switch (direction){
				case 0:
				$(this).find(".goodsDetail").animate({
					'left':"0px",
					'top':'-'+goodsHeight+'px'
				},200);
				break;
				case 1:
				$(this).find(".goodsDetail").animate({
					'left':goodsWidth+"px",
					'top':'0px'
				},200);
				break;
				case 2:
				$(this).find(".goodsDetail").animate({
					'left':"0px",
					'top':goodsHeight+'px'
				}),200;
				break;
				case 3:
				$(this).find(".goodsDetail").animate({
					'left':'-'+goodsWidth+"px",
					'top':'0px'
				},150);
				break;
			};
		}
		return false;
	});
	$(".carouselKindsR").click(function() {
		var now=$(".kindLikesPos:visible").index();
		var next;
		var kindsBoxWidth=$(".kindLikesPos").width();
		var marginBox=parseFloat($(".kindLikesPos").css('margin-top'));
		var kindsBoxHeight=$(".kindLikesPos").eq(now).height()+marginBox;

		if(now==0){
			next=3;
			$(".kindLikesPos").eq(next).show();
		 	$(".kindLikesPos").eq(next).css({
		 		'top':'-'+kindsBoxHeight+'px',
		 		'z-index':'0'
		 	});
		}	
		else{
			next=now-1;
			$(".kindLikesPos").eq(next).show();
	 	$(".kindLikesPos").eq(now).css({
	 		'top':'-'+kindsBoxHeight+'px',
	 	});
	 	$(".kindLikesPos").eq(next).css({
	 		'z-index':'0'
	 	});
		}
		$(".kindLikesPos").eq(now).animate({
			'left':kindsBoxWidth+'px',
			'opacity':0
	 	},800,function() {
	 				$('.kindLikesPos').eq(now).removeAttr("style");
			 		$(".kindLikesPos").eq(now).css({
			 			'display':'none'
			 		});
			 		$('.kindLikesPos').eq(next).removeAttr("style");
			 		$(".kindLikesPos").eq(next).css({
			 			'display':'block'
			 		});
	 		  }
		);
		$('.kindLikesPos').css('left', '');
	});
	var p=setInterval("likeAuto()",3000);
	$(".likeL").click(function () {
		clearInterval(p);
		var ulWidth=$(".ulBox").width();
		var marginLeft=parseInt($(".likeList").css("margin-left"));
		marginLeft -=ulWidth;
		var bigWidth=marginLeft-$(".ulBox").width();
		for(i=0;i<$(".like1th").length-1;i++){
			/*if(-($(".likevaPic").eq(0).position().left)<(marginLeft+200))
				break;*/
			if(-($(".likevaPic").eq(i).position().left+$(".likevaPic").eq(i).width())>=marginLeft&&(-($(".likevaPic").eq(i+1).position().left+$(".likevaPic").eq(i+1).width()))<marginLeft){
				$(".likeHead").children().children("img").attr("src",$(".likevaPic").eq(i).attr("src"));
			}
			if(-($(".likevaPic").eq(i).position().left)>bigWidth&&(-($(".likevaPic").eq(i+1).position().left))<=bigWidth){
				$(".likeFoot").children().children("img").attr("src",$(".likevaPic").eq(i+1).attr("src"));
				break;
			}	
		};	
		$(".likeList").animate({
			"margin-left":marginLeft
		},500,function() {
			marginLeft=parseInt($(".likeList").css("margin-left"));
			if(marginLeft<=likeSmallBox){
				marginLeft -=likeSmallBox;
				$(".likeList").css("margin-left",marginLeft);
			}
		});
		p=setInterval("likeAuto()",3000);
	});
	$(".likeR").click(function () {
		clearInterval(p);
		var ulWidth=$(".ulBox").width();
		var marginLeft=parseInt($(".likeList").css("margin-left"));
		if(marginLeft>=(0-ulWidth)){
			marginLeft +=likeSmallBox;
			$(".likeList").css("margin-left",marginLeft);
		}
		marginLeft +=ulWidth;
		var bigWidth=marginLeft-$(".ulBox").width();
		for(i=0;i<$(".like1th").length-1;i++){
			/*if(-($(".likevaPic").eq(0).position().left)<(marginLeft+200))
				break;*/
			if(-($(".likevaPic").eq(i).position().left+$(".likevaPic").eq(i).width())>=marginLeft&&(-($(".likevaPic").eq(i+1).position().left+$(".likevaPic").eq(i+1).width()))<marginLeft){
				$(".likeHead").children().children("img").attr("src",$(".likevaPic").eq(i).attr("src"));
			}
			if(-($(".likevaPic").eq(i).position().left)>bigWidth&&(-($(".likevaPic").eq(i+1).position().left))<=bigWidth){
				$(".likeFoot").children().children("img").attr("src",$(".likevaPic").eq(i+1).attr("src"));
				break;
			}
				
		};	

		$(".likeList").animate({
			"margin-left":marginLeft
		},500,function() {
			marginLeft=parseInt($(".likeList").css("margin-left"));
			if(marginLeft>=(0-ulWidth)){
				marginLeft +=likeSmallBox;
				$(".likeList").css("margin-left",marginLeft);
			}
		});
		p=setInterval("likeAuto()",3000);
	})
	$(".goodsLikeDiv").mouseover(function() {
		$(this).children(".goodsLikeTitle").css({
			"background-color":"rgba(0, 0, 0, 0.72)",
			"filter": "progid:DXImageTransform.Microsoft.gradient(startcolorstr=#AF000000,endcolorstr=#AF000000)",  
			"color":"#fff"
			
		});
	});
	$(".goodsLikeDiv").mouseout(function() {
		$(this).children(".goodsLikeTitle").css({
			"background":"rgba(255, 255, 255, 0.67)",
			"filter":"progid:DXImageTransform.Microsoft.gradient(startcolorstr=#AFFFFFFF,endcolorstr=#AFFFFFFF)",  
			"color":"#000"
		});
	});
});
function likeAuto() {
	var marginLeft=parseInt($(".likeList").css("margin-left"));
	/*var likeLength=$(".like1th").length;*/
	
	if((marginLeft-200)<=likeSmallBox){
		marginLeft -=likeSmallBox;
		$(".likeList").css("margin-left",marginLeft);
	}
	
	marginLeft -=200;
	var bigWidth=marginLeft-$(".ulBox").width();
	for(i=0;i<$(".likevaPic").length;i++){
		/*if(-($(".likevaPic").eq(0).position().left)<(marginLeft+200))
			break;*/
		if(-($(".likevaPic").eq(i).position().left+$(".likevaPic").eq(i).width())>=marginLeft&&(-($(".likevaPic").eq(i+1).position().left+$(".likevaPic").eq(i+1).width()))<marginLeft){
			$(".likeHead").children().children("img").attr("src",$(".likevaPic").eq(i).attr("src"));
		}
		if(-($(".likevaPic").eq(i).position().left)>bigWidth&&(-$(".likevaPic").eq(i+1).position().left)<=bigWidth){
			$(".likeFoot").children().children("img").attr("src",$(".likevaPic").eq(i+1).attr("src"));
			break;
		}
			
	};	
	
	
	
	$(".likeList").animate({
		"margin-left":marginLeft
	});	
};