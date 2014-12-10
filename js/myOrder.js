var order;
$(document).ready(function () {
	$.ajax({
		type:'post',
		url:'php/myOrderfunction.php',
		data:{"func":'GetInfo'},
	}).done(function(data) {
		data=data.substring(5,data.length);
		order=$.parseJSON(data);
		if(order[0].status == ''){
			$(".total").css("display","none");
			$(".orderEmpty").css("display","block");
		}	
		else {
			if(order==null){
				$(".orderPre").css("display","none");
			}
			else{
				$(".orderEmpty").css("display","none");
				$(".main").css("padding-bottom","270px");
				var Bnum=order.length;//订单数
				var insertContent;
				for(i=0;i<Bnum;i++){//动态创建订单
					var total=0;
					var insertSmallContent=null;
					Snum=order[i].goods.length;//订单中的物品数
					var operationInsertContent;	
					var storeGoodsNum=0;//小包裹所属计数
					for(x=0;x<Snum;x++)//订单的总价
						total=total+parseFloat(order[i].goods[x].newPrice)*parseFloat(order[i].goods[x].num);
					for(n=0;n<Snum;n++){//动态创建物品
						Mnum=order[i].goods[n].optionName.length;//物品中的参数数
						var option='';
						var storeTotal;//这个订单中的某个店家一共有多少个商品
						var storeGoodsFlag;//确实是否是此订单的此家店的第一个商品
						for(m=0;m<Mnum;m++){//物品的参数
							if(order[i].goods[n].optionName[m]!='')
							option=option+order[i].goods[n].optionName[m]+':'+order[i].goods[n].optionValue[m]+' ';
						};
						/******************************************************************/
						if(n>=storeGoodsNum||n==0){//判断此订单物品之后有多少是属于同一个店家
							for(storeGoodsNum=n+1;storeGoodsNum<Snum;storeGoodsNum++){
								if(storeGoodsNum==Snum){//判断是否已经是最后一个物品
									break;
								}
								if(order[i].goods[storeGoodsNum-1].storeName!=order[i].goods[storeGoodsNum].storeName){//判断是否是属于同一个店家
									break;
								}
							};
							storeTotal=storeGoodsNum-n;
							storeGoodsFlag=1;
						}
						else {
							storeGoodsFlag=0;
						}
						switch(parseInt(order[i].goods[n].status)) {//不同的订单状态对应的不同operate
							case 0:
								operationInsertContent="<form method=\"post\" action=\"php/myOrderfunction.php\"><input type=\"hidden\" name=\"func\" value=\"payment\"><input type=\"hidden\" name=\"orderId\" value=\""+order[i].id+"\"><input type=\"submit\" name=\"submit\" value=\"付款\"></form><p class=\"deleteOrders\">删除</p>";
								if(n==0){
									insertSmallContent="<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td><td rowspan=\""+storeTotal+"\"><p class=\"Goodsdetail\" >"+order[i].goods[n].storeName+"</p></td><td rowspan=\""+Snum+"\"><strong>￥"+total+" </strong></td><td rowspan=\""+Snum+"\">"+operationInsertContent+"</td></tr>";
								}
								else if(storeGoodsFlag&&n!=0){
									insertSmallContent=insertSmallContent+"<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td><td rowspan=\""+storeTotal+"\"><p class=\"Goodsdetail\" >"+order[i].goods[n].storeName+"</p></td></tr>";
								}
								else if(!storeGoodsFlag&&n!=0)
									insertSmallContent=insertSmallContent+"<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td></tr>"
								break;
							case 1:
							    operationInsertContent="<p data=\""+order[i].goods[n].wuliuid+"\"  class=\"orderColor orderShowLogistic\">查看物流信息</p>";
								if(n==0){
									insertSmallContent="<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td><td rowspan=\""+storeTotal+"\"><p class=\"Goodsdetail\" >"+order[i].goods[n].storeName+"</p></td><td rowspan=\""+Snum+"\"><strong>￥"+total+" </strong></td><td rowspan=\""+storeTotal+"\">"+operationInsertContent+"</td></tr>";
								}
								else if(storeGoodsFlag&&n!=0){
									insertSmallContent=insertSmallContent+"<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td><td rowspan=\""+storeTotal+"\"><p class=\"Goodsdetail\" >"+order[i].goods[n].storeName+"</p></td><td>"+operationInsertContent+"</td></tr>";
								}
								else if(!storeGoodsFlag&&n!=0)
									insertSmallContent=insertSmallContent+"<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td></tr>";
								break;
							case 2:
								operationInsertContent="<p data=\""+order[i].goods[n].goodsid+"\" class=\"orderColor orderShowComment\">评论</p>";
								if(n==0){
									insertSmallContent="<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td><td rowspan=\""+storeTotal+"\"><p class=\"Goodsdetail\" >"+order[i].goods[n].storeName+"</p></td><td rowspan=\""+Snum+"\"><strong>￥"+total+" </strong></td><td>"+operationInsertContent+"</td></tr>";
								}
								else if(storeGoodsFlag&&n!=0){
									insertSmallContent=insertSmallContent+"<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td><td rowspan=\""+storeTotal+"\"><p class=\"Goodsdetail\" >"+order[i].goods[n].storeName+"</p></td><td>"+operationInsertContent+"</td></tr>";
								}
								else if(!storeGoodsFlag&&n!=0)
									insertSmallContent=insertSmallContent+"<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td><td>"+operationInsertContent+"</td></tr>";
								break;
							case 3:
								operationInsertContent="<p class=\"deleteOrders\">删除</p>";
								if(n==0){
									insertSmallContent="<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td><td rowspan=\""+storeTotal+"\"><p class=\"Goodsdetail\" >"+order[i].goods[n].storeName+"</p></td><td rowspan=\""+Snum+"\"><strong>￥"+total+" </strong></td><td rowspan=\""+Snum+"\">"+operationInsertContent+"</td></tr>";
								}
								else if(storeGoodsFlag&&n!=0){
									insertSmallContent=insertSmallContent+"<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td><td rowspan=\""+storeTotal+"\"><p class=\"Goodsdetail\" >"+order[i].goods[n].storeName+"</p></td></tr>";
								}
								else if(!storeGoodsFlag&&n!=0)
									insertSmallContent=insertSmallContent+"<tr><td><div class=\"orderImg\"><a href=\""+order[i].goods[n].url+"\"><img src=\""+order[i].goods[n].pic.pic1+"\"></a><p><a href=\""+order[i].goods[n].url+"\"><b>"+order[i].goods[n].goodsTitle+"</b></a><br><span class=\"detail-s\">"+option+"</span></p></div></td><td><p class=\"underline\">￥"+order[i].goods[n].oriPrice+"</p>￥"+order[i].goods[n].newPrice+"</td><td>"+order[i].goods[n].num+"</td></tr>"
								break;
						}					
					};
					 insertContent="<table class=\"orderTable goods\"><tbody><tr class=\"goodsTr\"><th class=\"th1\"><input type=\"checkbox\"  checked=\"checked\" class=\"selAllCommon\"><span>订单号："+order[i].id+"</span></th><th class=\"th2\"></th><th class=\"th3\"></th><th class=\"th4\"></th><th class=\"th5\"></th><th class=\"th6\"></th>"+insertSmallContent+"</tbody></table>";
					 $(".total").before(insertContent);

				};
			};
		};
		$(".orderShowComment").click(function(){
			$(".orderComment").css("display","block");
			var screenWidth=($(window).width()-$(".orderComment").width())/2;
			$(".orderComment").css("left",screenWidth);
			$(".orderCommentHidden").attr("value",$(this).attr("data"));
			var goodsOrderIdHidden=$(this).parents("tbody").find(".goodsTr").children(".th1").children("span").text().substring(4);
			$(".orderIdHidden").attr("value",goodsOrderIdHidden);
		})
		$(".orderShowLogistic").click(function(){
			$(".logistics").css("display","block");
			var screenWidth=($(window).width()-$(".logistics").width())/2;
			$(".logistics").css("left",screenWidth);
			$.ajax({
				type:'post',
				url:'php/myOrderfunction.php',
				data:{"func":'logisticFunc',
					  "wuliuid":$(this).attr("data"),
					  "orderID":$(this).parents("tbody").find(".th1").children("span").text()
				}
			}).done(function(data) {
				data=data.substring(5);
				logistic=$.parseJSON(data);
				/***************************************/
				$(".logOrderContent").text(logistic.orderId);
				if(logistic.comany==""){
					$(".logComContent").text("暂无物流信息");
					$(".logNumContent").text("暂无物流信息");
					$(".logisticsDetail").html("<p>暂无物流信息</p>")
				}
				else{
					$(".logComContent").text(logistic.comany);
					$(".logNumContent").text(logistic.logisticId);
					if(parseInt(logistic.logisticId)==1201359036081||parseInt(logistic.logisticId)==9358551050){
						$(".logisticsDetail").html("<p>已到成都</p>")
					}
					else
						for(i=0;i<logistic.data.length;i++){
							$(".logisticsDetail").append("<p>"+logistic.data[i].time+" "+logistic.data[i].context+"</p>")
						}
					
				}

			})
		})
		$(".orderComment img").click(function(){
			$(".orderComment").css("display","none")
		})
		var shadowHeight=$(window).height();
		var shadowWidth=$(window).width();
		shadowHeight=(shadowHeight-$(".shadowSelect").height())/2;
		shadowWidth=(shadowWidth-$(".shadowSelect").width())/2;
		$(".shadowSelect").css("top",shadowHeight);
		$(".shadowSelect").css("left",shadowWidth);
		$(".selAllCommon").click(function() {
			var x=0,y=0
			for (var i = 0; i < $(".selAllCommon").length; i++) {
				if($(".selAllCommon").eq(i).prop("checked"))
					x++;
				else 
					y++;
			};
			if(x==$(".selAllCommon").length||y==$(".selAllCommon").length)
				$(".total .batch input").click();
		});
		$(".operation").click(function() {//单个订单的付款操作
			var num;
			var numId;
			num=$(this).parents('.orderTable').index()-1;
			numId=order[num].id+'+';
			/*sendOrder(numId);*/
		});
		$(".total input").click(function() {//全选，付款的前奏
			if($(this).prop("checked"))
				for(i=0;i<order.length;i++){
					if(order[i].status==1){
						$(".goods").eq(i).find(".th1 input").prop("checked",true);
					}
				}
			else
				for(i=0;i<order.length;i++){
					if(order[i].status==1){
						$(".goods").eq(i).find(".th1 input").prop("checked",false);
					}
				};
		});
		$(".allOperation").click(function() {//合并付款
			var num=null;
			for(i=0;i<order.length;i++){
				if($(".goods").eq(i).find(".th1 input").prop("checked")==true){
						num=num+'+'+order[i].id;
				}
			};
			sendOrder(num);
		});
		$(".deleteOrders").click(function() {//删除单个订单
			$(this).parents(".goods").attr("status",true);
			$(".shadow").css("display","block");
			$(".shadowSelect").css("display","block");
			/*deleteMyOrder(numId);*/
		});
		$(".shadowNo").click(function() {
			deleteShadow();
		});
		$(".shadowSelectX").click(function() {
			deleteShadow();
		});
		$(".shadowYes").click(function() {
			var num;
			for (var i = 0 ; i < $(".goods").length; i++) {
				if($(".goods").eq(i).attr("status")){
					$(".goods").eq(i).remove();
					num=order[i].id;
					deleteShadow()
					break;
				}
					
			};
			deleteMyOrder(num);
		});
		$(".logisticsIcon").click(function(){
			$(".logistics").css("display","none");
		});
	});
});
function sendOrder(num){//提交订单
	$.ajax({
		type:'post',
		url:'php/myOrderfunction.php',
		data:{
			'num':num,
			'func':'sendOrder',
		}
	});
};
function deleteMyOrder(num) {//删除订单
	$.ajax({
		type:'post',
		url:'php/myOrderfunction.php',
		data:{
			'num':num,
			'func':'deleteOrder',
		}
	});
};
function deleteShadow() {
	$(".shadowSelect").css("display","none");
	$(".shadow").css("display","none");
};
