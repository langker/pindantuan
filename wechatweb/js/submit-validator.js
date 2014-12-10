var validate = (function(){
	return {
		// 判断是否为空
		validateNull: function(text){
			if(text){
				return true;
			}else{
				return false;
			};
		},
		//判断是否为手机电话号
		valigatePhone: function(phone){

			var pattern = /^[0-9]{11}$/;

			if(pattern.test(phone)){
				return true;
			}else{
				return false;
			}
		}
	};
})();

function val(){
	var fname = $("#name");
	var fphone = $("#phone");

	fname.blur(function(){
		if(validate.validateNull(fname.val())){
			$(".alertName").css("display","none");
		}else{
			$(".alertName").css("display","block");
		}
		btnDisable();
	})
	fphone.blur(function(){
		if(validate.valigatePhone(fphone.val())){
			$(".alertPhone").css("display","none");
		}else{
			$(".alertPhone").css("display","block");
		}
		btnDisable();
	})
}

function btnDisable(){
	var fname = $("#name");
	var fphone = $("#phone");
	var btn = $(".submit-btn");

	if (validate.validateNull(fname.val())&&validate.valigatePhone(fphone.val())){
		btn.attr("disabled",false);
	}else{
		btn.attr("disabled",true);
	};
};

function btnClick() {
	var btn = $(".submit-btn");
	btn.click(function() {
		send();
	});
}

//分析url

function urlCute() { // 将商品信息分析出来

	var url = window.location.href;
	var markIndex = 1 + url.indexOf('?');
	var urlC = url.substr(markIndex);
	var itemArray = urlC.split('&');

	return itemArray;
}

function send() { //发送给服务器
	var itemArray = urlCute();
	var goodssid = itemArray[0];
	var num = itemArray[1];
	var cellphone = $("#phone").val();
	var name = $("#name").val();

	$.post("../php/weinxinstore.php" , {func : "AddOrder" , goodssid : goodssid , num : num , cellphone : cellphone , name : name},function(){
		top.location.href = "http://www.pindantuan.cn/wechatweb/result.html";
	});

}
val();
btnDisable();
btnClick();