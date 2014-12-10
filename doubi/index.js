var _height = $(document).height();
$("body").css("height",_height);
$("#go").click(function(){
	$("#welcome").css("display","none");
	$("#a").css("display","block");
});
var step = 0;
var pionts = new Array(6);
var _question = new Array(5);
_question[1] = new Array(4);
_question[1][0] = "他们活的怎么样？";
_question[1][1] = "寄居在大家打击之中";
_question[1][2] = "每天开心像傻逼一样，一点都像逗比";
_question[1][3] = "活的一般般啦";

_question[2] = new Array(5);
_question[2][0] = "你的身边缺少一个逗比的话，你会怎么办？";
_question[2][1] = "把最要好的小伙伴改造成逗比";
_question[2][2] = "我不入地狱谁入地狱，成为那个逗逼，恶心自己、娱乐大众吧";
_question[2][3] = "去淘宝上看看有木有";
_question[2][4] = "知足吧，你不会体会到一个身边全是逗逼的人的痛苦的";


_question[3] = new Array(5);
_question[3][0] = "怎么让自己不逗比？";
_question[3][1] = "使周围的人都成逗比";
_question[3][2] = "浮生若梦，为欢几何 况阳春召我以烟景，大块假我以文章。人活得逗比是大自然的规律啊！不要抗拒，follow your heart";
_question[3][3] = "我也很想知道答案";
_question[3][4] = "如题,别逗就行了"



_question[4] = new Array(3);
_question[4][0] = "你如何评价逗比？";
_question[4][1] = "逗比是一种美好的存在";
_question[4][2] = "一个人二出了喜剧效果";
_question[4][3] = "对亲近的二货的爱称";


_question[5] = new Array(3);
_question[5][0] = "如果你是逗比，你怎么和不是那么逗的人相处？";
_question[5][1] = "逗呗";
_question[5][2] = "作为一个真·逗逼 我从不考虑怎么和不那么逗的人相处";
_question[5][3] = "自逗即可";




var answerModle = "<li><div class=\"button\"><\/div><p class=\"content\"><\/p></\li>";
var but = $(".button");

$(".button").click(function () {

	// $(this).css("background","black");
	pionts[step] = $(".button").index($(this));
	
	step = step + 1;
	$("#answer").html("");
	// console.log(step);
	for (var i = 0; i < (_question[step].length-1); i++) {
		$("#answer").append(answerModle);
		$("#question").text(_question[step][0]);
		$(".content:eq("+i+")").text(_question[step][i+1]);
	}
	$(".button").click(function () {

		$(this).css("background","white");
		pionts[step] = $(".button").index($(this));
		
		step = step + 1;
		$("#answer").html("");
		// console.log(step);
		for (var i = 0; i < (_question[step].length-1); i++) {
			$("#answer").append(answerModle);
			$("#question").text(_question[step][0]);
			$(".content:eq("+i+")").text(_question[step][i+1]);
		}
		$(".button").click(function () {

			$(this).css("background","white");
			pionts[step] = $(".button").index($(this));
			
			step = step + 1;
			$("#answer").html("");
			// console.log(step);
			for (var i = 0; i < (_question[step].length-1); i++) {
				$("#answer").append(answerModle);
				$("#question").text(_question[step][0]);
				$(".content:eq("+i+")").text(_question[step][i+1]);
			}
			$(".button").click(function () {

				$(this).css("background","white");
				pionts[step] = $(".button").index($(this));
				
				step = step + 1;
				$("#answer").html("");
				// console.log(step);
				for (var i = 0; i < (_question[step].length-1); i++) {
					$("#answer").append(answerModle);
					$("#question").text(_question[step][0]);
					$(".content:eq("+i+")").text(_question[step][i+1]);
				}
				$(".button").click(function () {
					$(this).css("background","white");
					pionts[step] = $(".button").index($(this));
					
					step = step + 1;
					$("#answer").html("");
					// console.log(step);
					for (var i = 0; i < (_question[step].length-1); i++) {
						$("#answer").append(answerModle);
						$("#question").text(_question[step][0]);
						$(".content:eq("+i+")").text(_question[step][i+1]);
					}
					$(".button").click(function () {

						$(this).css("background","white");
						pionts[step] = $(".button").index($(this));
						
						step = step + 1;
						// $("#answer").html("");
						// // console.log(step);
						// for (var i = 0; i < (_question[step].length-1); i++) {
						// 	$("#answer").append(answerModle);
						// 	$("#question").text(_question[step][0]);
						// 	$(".content:eq("+i+")").text(_question[step][i+1]);
						// }
						$("#a").css("display","none");
						$("#result").css("display","block");
						var num =1+(pionts[0]*1)+(pionts[1]+1)+(pionts[2]*2)+(pionts[3]+1)+pionts[4]+pionts[5]
						$("span").text(num+"个")
						$("title").text("我的朋友圈里有"+num+"个大逗比,其中就有你，哈哈");
					});
				});
			});
		});
	});
});








