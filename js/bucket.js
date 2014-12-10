var bucketData;
var goods = new Array();
var onGoods = [];
var noGoods = [];

$.post("php/bucketfunction.php",{func:"GetInfo"},function(data) {
	var tempData = data.substr(4, data.length);
	bucketData = JSON.parse(tempData);
	console.log(bucketData);
	for (var i = 0; i < bucketData.length; i++) {
		var tempData = {
			goodsID: bucketData[i].classify[0].goodssid,
			numbers: bucketData[i].goods.num,
			oriPrice: bucketData[i].classify[0].orgiprice,
			newPrice: bucketData[i].classify[0].nowprice,
			optionName: bucketData[i].goods.optionName,
			optionValue: bucketData[i].classify[0].class,
			url: bucketData[i].goods.url,
			status: bucketData[i].goods.status,
			title: bucketData[i].goods.title,
			pic: bucketData[i].goods.pic
		}
		goods.push(tempData);
	};
	for (var i = 0; i < goods.length; i++) {
		if (goods[i].status == 1) {
			onGoods.push(goods[i]);
		} else if (goods[i].status == 0) {
			noGoods.push(goods[i]);
		};
	};
	creatDom();
	changeAcount();
	countTotal();
	attackCheckbox();
	selectAll();
	deleteTr();
	batDel();
	judgeIsNull();
	finish();
});


function creatDom() {

	//处理未下架商品

	var item = "<tr class=\"on-goods\"><td><div class=\"bucket-img\"><input type=\"checkbox\" checked=\"\"><a href=\"#\"><img src=\"\" width=\"60px\" height=\"60px\"></a><p><a href=\"#\" target=\"_blank\"><b></b></a><br><span class=\"detail-s\"></span></p></div></td><td><p>拼单价：<span class=\"pd-price\"></span></p><p>淘宝价：<span class=\"tb-price\"></span></p></td><td class=\"count-box\"><a href=\"javascript:;\" class=\"J_minus\">-</a><input type=\"text\" value=\"\" disabled=\"disabled\" class=\"J_input\"><a href=\"javascript:;\" class=\"J_add\">+</a></td><td><strong class=\"total\">￥218.00 </strong></td><td><button>删除</button></td></tr>";

	// 创建dom

	var $parents = $(".bucket-goods tbody");

	for (var i = 0; i < onGoods.length; i++) {

		$parents.append(item);

	};

	//数据插入dom

	for (var i = 0; i < onGoods.length; i++) {
		var img = onGoods[i].pic;
		var title = onGoods[i].title;
		var oriPrice = "￥" + onGoods[i].oriPrice;
		var newPrice = "￥" + onGoods[i].newPrice;
		var option = new Array();
		var url = onGoods[i].url;

		//添加参数

		for (var j = 0; j < onGoods[i].optionName.length; j++) {
			if(onGoods[i].optionName[j] != "" ){
				option[j] = onGoods[i].optionName[j] + "：" + onGoods[i].optionValue[j] + " ";
				$(".on-goods .detail-s:eq(" + i + ")").append(option[j]);
			}
		};

		$(".on-goods .bucket-img img:eq(" + i + ")").attr('src', img);
		$(".on-goods .bucket-img b:eq(" + i + ")").text(title);
		$(".on-goods .tb-price:eq(" + i + ")").text(oriPrice);
		$(".on-goods .pd-price:eq(" + i + ")").text(newPrice);
		$(".J_input:eq(" + i + ")").attr('value', onGoods[i].numbers);
		$(".on-goods .bucket-img p a:eq("+i+")").attr('href',url);

		setTotal(i);
	};

	//处理已下架商品

	var noItem = "<tr class=\"no-goods\"><td><div class=\"bucket-img\"><img src=\"\" width=\"60px\" height=\"60px\"><p><b>VISIBLE Space Storm满版绣花POLO衫</b><br><span class=\"detail-s\">颜色：黑色  尺码：M</span></p></div></td><td><p>拼单价：<span class=\"pd-price\"></span></p><p>淘宝价：<span class=\"tb-price\"></span></p></td><td></td><td></td><td><b>此商品已下架</b><p><button>删除</button></p></td></tr>"

	for (var i = 0; i < noGoods.length; i++) {

		$parents.append(noItem);

	};

	//添加数据

	for (var i = 0; i < noGoods.length; i++) {
		var img = noGoods[i].pic;
		var title = noGoods[i].title;
		var oriPrice = "￥" + noGoods[i].oriPrice;
		var newPrice = "￥" + noGoods[i].newPrice;
		var option = new Array();

		//添加参数

		for (var j = 0; j < noGoods[i].optionName.length; j++) {
			option[j] = noGoods[i].optionName[j] + "：" + noGoods[i].optionValue[j] + " ";
			$(".no-goods .detail-s:eq(" + i + ")").append(option[j]);
		};

		$(".no-goods .bucket-img img:eq(" + i + ")").attr('src', img);
		$(".no-goods .bucket-img b:eq(" + i + ")").text(title);
		$(".no-goods .tb-price:eq(" + i + ")").text(oriPrice);
		$(".no-goods .pd-price:eq(" + i + ")").text(newPrice);

	};

}

//添加数量

function changeAcount() {
	$(".J_add").click(function() {
		var t = $(".J_input")
		var num = $(this).parent().parent().index()-1;
		t.eq(num).attr("value", parseInt(t.eq(num).attr("value")) + 1);
		onGoods[num].numbers = t.eq(num).attr("value");
		countTotal();
		setTotal(num);
	})
	$(".J_minus").click(function() {
		var t = $(".J_input")
		var anum = $(this).parent().parent().index()-1;
		if(t.eq(anum).attr("value")<=1){
			return false;
		}
		t.eq(anum).attr("value", parseInt(t.eq(anum).attr("value")) - 1);
		onGoods[anum].numbers = t.eq(anum).attr("value");
		countTotal();
		setTotal(anum);
	})
}
function setTotal(index) {
	$(".total:eq(" + index + ")").text("￥" + (parseInt(onGoods[index].numbers) * onGoods[index].newPrice).toFixed(2));
}

//刷新单个商品总价

//计算商品总价

function countTotal() {
	var total = 0;
	var oriTotal = 0;
	if (onGoods.length==0) {
		$(".price span:eq(0)").text("￥" + "0");
		$(".price span:eq(1)").text("￥" + "0");
		$(".price span:eq(2)").text("￥" + "0");
		$(".right p:eq(1) strong").text("￥" + "0");
	};
	for (var i = 0; i < onGoods.length; i++) {
		if(($(".on-goods .bucket-img input:eq("+i+")").prop("checked"))==true){
			oriTotal += parseInt(onGoods[i].numbers) * parseFloat(onGoods[i].oriPrice);
			total += parseInt(onGoods[i].numbers) * parseFloat(onGoods[i].newPrice);
			$(".price span:eq(0)").text("￥" + oriTotal.toFixed(2));
			$(".price span:eq(1)").text("￥" + (oriTotal.toFixed(2) - total.toFixed(2)).toFixed(2));
			$(".price span:eq(2)").text("￥" + total.toFixed(2));
			$(".right p:eq(1) strong").text("￥" + total.toFixed(2));
		}
		var index = 0;
		for (var j = 0; j < onGoods.length; j++) {
			if($(".on-goods .bucket-img input:eq("+j+")").prop("checked")==false){
				 index++;
			}
			if (onGoods.length==index) {
				$(".price span:eq(0)").text("￥" + "0");
				$(".price span:eq(1)").text("￥" + "0");
				$(".price span:eq(2)").text("￥" + "0");
				$(".right p:eq(1) strong").text("￥" + "0");
			};
		};
	};
};

//为checkbox绑定事件

function attackCheckbox(){
	$(".on-goods input:checkbox").click(function(){
		countTotal();
		submitToggle();
	});
}

function submitToggle(){
  var index = 0;
  $(".bucket-img input").each(function(){

  	if($(this).is(":checked")){
  		index += 1;
  	};
  });
  if(index == 0){
  	$(".bucket-submit button").attr("disabled",true);
  }else{
  	$(".bucket-submit button").attr("disabled",false);  	
  };
};


//全选操作

// function selectAll() {
// 	$(".bucket-total input:checkbox").click(function() {
// 		//切换开关复选框
// 		var $toggle = $(this);
// 		//其他复选框
// 		var $checkboxes = $(".on-goods input:checkbox");
// 		//监听切换开关的change事件
// 		$toggle.change(function() {
// 			if ($(this).is(":checked")) {
// 				$checkboxes.prop('checked', true);
// 			} else {
// 				$checkboxes.prop('checked', false);
// 			}
// 		})
// 		//监听每个单独复选框的change事件
// 		$checkboxes.change(function() {
// 			if ($(this).is(":checked")) {
// 				if ($checkboxes.length == $checkboxes.filter(function() {
// 					return $checkboxes.is(":checked");
// 				}).length) {
// 					$toggle.prop("checked", true);
// 				} else {
// 					$toggle.prop("checked", false);
// 				}
// 			};
// 		}).eq(0).trigger('change');
// 	});
// }

function selectAll(){
	$(".bucket-total input:checkbox").click(function(){
		var $toggle = $(this);
		var $checkboxes = $(".on-goods input:checkbox");
		if($toggle.prop("checked")){
			$checkboxes.prop('checked', true);
		}
		else{
			$checkboxes.prop('checked', false);
		}
		countTotal();
		submitToggle();
	})
}

// function tellBack(num){
// 	onGoods[num]
// 	$.post("php/bucketfunction.php",{func:"deleteGoods",""})
// }

//基本删除操作

function deleteTr() {
	$(".on-goods button").click(function() {
		var num = $(this).parent().parent().index();
		var goodsID = [];
		goodssID = onGoods[num-1].goodsID;
		goodsID.push(goodssID);
		$(this).parent().parent().remove();
		onGoods.splice(num - 1, 1);
		$.post("php/bucketfunction.php",{func:"deleteGoods",goodssid:goodsID},function(){
			_header();
		});
		countTotal();
		judgeIsNull();
	})
	$(".no-goods button").click(function() {
		var num1 = ($(this).parent().parent().parent().index()) - (onGoods.length);
		var goodsID = [];
		goodssID = noGoods[num1-1].goodsID;
		goodsID.push(goodssID);
		$(this).parent().parent().parent().remove();
		noGoods.splice(num1 - 1, 1);
		$.post("php/bucketfunction.php",{func:"deleteGoods",goodssid:goodsID});
		judgeIsNull();
	})
}


//批量删除操作

function batDel() {
	$(".bucket-batch a").click(function() {
		var $checkboxes = $(".on-goods input:checkbox");
		var index = 0;
		var goodssid = [];
		$checkboxes.each(function() {
			if ($(this).is(":checked")) {
				index += 1;
			};
		})
		if (index == 0) {
			alert("请选择您要删除的物品");
		} else {
			if (confirm("您是否确定删除这" + index + "个商品")) {
				$checkboxes.each(function() {
					if ($(this).is(":checked")) {
						var num = $(this).parent().parent().parent().index();
						var goodsID = onGoods[num-1].goodsID;
						$(this).parent().parent().parent().remove();
						onGoods.splice(num - 1, 1);
						goodssid.push(goodsID);
						countTotal();
						judgeIsNull();
					};
				})
			} else {
				return false;
			};
		};
		$.post("php/bucketfunction.php",{func:"deleteGoods",goodssid:goodssid},function(){
			_header();
		});
	})
}

//判断购物车是否为空，显示图片
function judgeIsNull(){
	var $brother = $(".bucket-goods-tr");
	var $parent = $(".bucket-goods");
	var $btn = $(".my-button");
	var pic = "<div class=\"emptybucket\"><img src=\"img/emptybucket.jpg\"></div>";
	if($brother.siblings().size()==0){
		$parent.append(pic);
		$btn.css("display","none");
		$(".bucket-total").css("display","none");
		$(".bucket-goods tbody").css("display","none");
	}
}

function finish(){
	$(".my-button").click(function(){
		var goodsID = [];
		var num = [];
		$(".bucket-submit button").attr("disabled",true);
		$(".bucket-submit button").text("正在提交..");
		for (var i = 0; i < onGoods.length; i++) {
			if (($(".on-goods .bucket-img input:eq("+i+")").prop("checked"))==true) {
				goodsID.push(onGoods[i].goodsID);
				num.push(onGoods[i].numbers);
			};
		};
		goodsID = goodsID.join('&');
		num = num.join('&');
		var res = "settlement.php?bucket@" + goodsID + "%" + num;
		window.location.href=res;
	});
}


/*通过域名没有ajax请求的情况下进入购物车时*/

setTimeout(function(){
	if($(".log a").text() == '淘宝登录'){
  $(".dialog").css("display","block");
  judgeIsNull();
}else{
	return true;
}
},500);