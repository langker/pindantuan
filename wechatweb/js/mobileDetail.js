$(document).ready(function () {
	$("#detail").fadeIn();
	var href=window.location.href;
	var hrefNum=href.indexOf("=")+1;
	href=href.substr(hrefNum);
	$.ajax({
		type:"post",
		url:"../php/weinxinstore.php",
		data:{
			"func":"mobileDetail",
			"page":href
		}
		}).done(function(data){
			
			data=data.substr(2);
			var detailGoods=$.parseJSON(data);
			var  url="setopt.html?"+detailGoods.id;
			if(detailGoods.page=='end'){
				$(".next").click(function(){
					alert("没有商品了，如果不能满足你，请去www.pindantuan.cn!");
					return false;
				});

			}
			var page="moblieDetail.html?page="+detailGoods.page;
			$(".goodsTitle").text(detailGoods.title);
			$(".goodsPDPriceDetail").text(detailGoods.PDPrice);
			$(".goodsTBPriceDetail").text(detailGoods.TBPrice);
			$(".nowBuy").attr("href",url);
			$(".next").attr("href",page)
			for(var i=0,n=0;i<4;i++,n++){
				if(n==detailGoods.pic.length){
					n=0;
				}
				var src="../"+detailGoods.pic[n];
				$("#slides2").find("img").eq(i).attr("src",src)
			}
			
			
		})
})