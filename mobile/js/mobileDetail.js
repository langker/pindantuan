	
$(document).ready(function () {
	$(".swiperBox").css({
		"position":"fixed",
		"top":0,
		"left":0,
		"width":$(window).width(),
		"background-color":"#FFF"
	});
	var indexUrl=window.location.href;
	urlNum=indexUrl.indexOf("=");
	urlNum++;
	var articleId=indexUrl.substr(urlNum);
	$.ajax({
		type:'post',
		url:'php/articleDetail.php',
		data:{"func":'init',
			"id":articleId}
	}).done(function(data) {
		data=data.substr(1);
		value=$.parseJSON(data);
		if(value){
			$(".header ul li p").text(value.article.title);
			$(".header ul li img").attr("src",value.article.pic);
			var content=base64decode(value.article.content); 
			content=utf8to16(content)
			$(".content-detail").html(content);
			/*var goodsLength=value.goods.length;//$(selector).append(content)
			for(var i=0 ; i<goodsLength; i++){
				var insertContent="<div class=\"swiper-slide\"><div class=\"carouselPic\"><a href=\""+value.goods[i].url+"\"><img src=\""+value.goods[i].pic+"\"></a><div class=\"carouselDetail\"><p class=\"carouselTit\">"+value.goods[i].title+"</p><div class=\"carouselPri\"><p class=\"carouselPrice\">"+value.goods[i].TBprice+"</p><p>¥</p></div></div></div></div>";
				$(".swiper-wrapper").append(insertContent);
			};*/
			
		};
	});
	var base64DecodeChars = new Array( 
		-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 
		-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 
		-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63, 
		52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1, 
		-1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 
		15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1, 
		-1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 
		41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1); 
	function base64decode(str) { 
		var c1, c2, c3, c4; 
		var i, len, out; 
		len = str.length; 
		i = 0; 
		out = ""; 
		while(i < len) { 
		/* c1 */ 
		do { 
		c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff]; 
		} while(i < len && c1 == -1); 
		if(c1 == -1) 
		break; 
		/* c2 */ 
		do { 
		c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff]; 
		} while(i < len && c2 == -1); 
		if(c2 == -1) 
		break; 
		out += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4)); 
		/* c3 */ 
		do { 
		c3 = str.charCodeAt(i++) & 0xff; 
		if(c3 == 61) 
		return out; 
		c3 = base64DecodeChars[c3]; 
		} while(i < len && c3 == -1); 
		if(c3 == -1) 
		break; 
		out += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2)); 
		/* c4 */ 
		do { 
		c4 = str.charCodeAt(i++) & 0xff; 
		if(c4 == 61) 
		return out; 
		c4 = base64DecodeChars[c4]; 
		} while(i < len && c4 == -1); 
		if(c4 == -1) 
		break; 
		out += String.fromCharCode(((c3 & 0x03) << 6) | c4); 
		} 
		return out; 
	} 
	//utf-16转utf-8 
	function utf8to16(str) { 
		var out, i, len, c; 
		var char2, char3; 
		out = ""; 
		len = str.length; 
		i = 0; 
		while(i < len) { 
		c = str.charCodeAt(i++); 
		switch(c >> 4) 
		{ 
		case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7: 
		// 0xxxxxxx 
		out += str.charAt(i-1); 
		break; 
		case 12: case 13: 
		// 110x xxxx 10xx xxxx 
		char2 = str.charCodeAt(i++); 
		out += String.fromCharCode(((c & 0x1F) << 6) | (char2 & 0x3F)); 
		break; 
		case 14: 
		// 1110 xxxx 10xx xxxx 10xx xxxx 
		char2 = str.charCodeAt(i++); 
		char3 = str.charCodeAt(i++); 
		out += String.fromCharCode(((c & 0x0F) << 12) | 
		((char2 & 0x3F) << 6) | 
		((char3 & 0x3F) << 0)); 
		break; 
		} 
		} 
		return out; 
	} 
	$(".swiper-slide").css("height",$(".swiper-slide").height());
		var mySwiper = new Swiper('.swiper-container',{
		    pagination: '.pagination',
		    loop:true,
		    grabCursor: true,
		    paginationClickable: true,
		    calculateHeight: true,
		    slidesPerView: 3,
		    centeredSlides: true,
		 });
	
	$(".contentLike p").attr("status",0);
	
	
	$(".contentLike").click(function(){
		if(!parseInt($(".contentLike p").attr("status"))){
			$.ajax({
				type:'post',
				url:'php/articleDetail.php',
				data:{"func":'like',
					"id":articleId
				}
			}).done(function(data) {
				data=data.substr(1);
				status=$.parseJSON(data);
				if(status){
					$(".contentLike p").text("已赞").attr("status",1)
				}
			});
		}
		else{
			alert("已赞")
		}	
	});
	
});