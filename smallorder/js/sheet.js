(function(){
	$.post("../../php/houtai.php" , {func: 'setSheet'} ,function(data){
		console.log(data);
		var order = $.parseJSON(data);
		for (var i = 0; i < order.length; i++) {
			sheet.addDOM();
			sheet.renderData(order[i],i);
		};
	})
})();

var sheet = (function(){
	return {
		addDOM: function(){
			var dom = "<div class=\"wrap\"><div class=\"main-name\">张兆鑫</div><div class=\"main-phone\">18380421239</div><div class=\"main-date\">2014-10-18</div><div class=\"main-addr\">电子科技大学沙河校区</div><div class=\"main-opt\">asasdasdasdasdadasdad</div><div class=\"main-store\"></div><div class=\"main-ison\">是</div><div class=\"copy-name\">张兆鑫</div><div class=\"copy-phone\">18380421239</div><div class=\"copy-date\">2014-10-18</div><div class=\"copy-opt\">wddsdfsdfdfdsfssdsds</div><div class=\"copy-store\"></div><div class=\"copy-ison\">是</div><div class=\"price\"></div></div>"
			$("body").append(dom);
		},
		renderData: function(data,index){

			var name = data.name,
			    cellphone = data.cellphone,
			    date = data.date,
			    address = data.address,
			    orderid = data.orderid,
			    price = data.price,
			    store = data.store,
			    status = data.status;

			$(".main-name").eq(index).text(name);
			$(".copy-name").eq(index).text(name);
			$(".main-phone").eq(index).text(cellphone);
			$(".copy-phone").eq(index).text(cellphone);
			$(".main-date").eq(index).text(date);
			$(".copy-date").eq(index).text(date);
			$(".main-addr").eq(index).text(address);
			$(".main-opt").eq(index).text(orderid);
			$(".copy-opt").eq(index).text(orderid);
			$(".main-store").eq(index).text(store);
			$(".copy-store").eq(index).text(store);
			$(".price").eq(index).text(price);
			if (status == '0') {
				$(".main-ison").eq(index).text("否");
				$(".copy-ison").eq(index).text("否");
			}else{
				$(".main-ison").eq(index).text("是");
				$(".copy-ison").eq(index).text("是");
				$(".price").eq(index).css('display','block');
			};
		}
	}
})();

