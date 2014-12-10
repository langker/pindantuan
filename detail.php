<!DOCTYPE html>
<html lang="zh">
	<head>
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
    	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="基于Pure进行扩展">
    	<title></title>

    	<link rel="icon" type="image/x-icon" href="img/favicon.ico">
    	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/base-min.css">
		<link rel="stylesheet" href="css/grids-min.css">
		<link rel="stylesheet" href="css/header.css">
		<link rel="stylesheet" href="css/detail.css">
		<script src="js/jquery-1.11.1.min.js"></script>


	</head>
	<body>
		<?php include 'header.php';?>
		<!-- <div id="header">
			<div class="headerContainer">
				<div class="logo">
					<img src="img/logo.png">
					<div class="address">
						<div class="location">
							<img src="img/loca.png">
							<a href="">电子科技大学沙河校区</a>

						</div>
						<div class="allAddress">
							<a>电子科技大学沙河校区</a>
							<a>成都理工大学本校区</a>
						</div>
					</div>
				</div>
				<div class="home"><a href="">首页</a></div>
				
				<div class="allLike"><a href="">大家在逛</a></div>
				
				<div class="myCenter">
					<div class="log"><a href="">登录/注册</a><p>退出</p></div>
					<div class="myBucket">
						<a href="bucket.php">
							<p>购物车</p>
							<span class="bucketNum">1</span>
						</a>
						
					</div>
					<div class="myOrderHeader"><a href="">我的订单</a></div>
					<div class="visted">
						<a href="">最近浏览</a>
						<ul class="vistedItems">
			
						</ul>
					</div>
					
				</div>
				<div class="search"><img src="img/search.png"><input></div>
			</div>
			<div id="gotop"><img src="img/gotop.png"></div>
		</div> -->
		<div id="container">
			<div class="itemDetail pure-g-r">
				<div class="pic pure-u-2-5">
					<div class="picCanvas">
						<img src="">
					</div>
					<ul class="thumbnails">
					</ul>
				</div>
				<div class="info pure-u-3-5">
					<h4></h4>
					<div class="priceAndSales">
						<div class="price">
							<div class="nowPrice">
								<span>拼单价</span>
								<p></p>
							</div>
							<div class="oriPrice">
								<span>原价</span>
								<p></p>
								<div><!-- <img src="img/tmall.png"> --><a href="" target="_blank"></a>供货</div>
							</div>
						</div>
						<div class="sales">

							<span>销量</span>
							<p></p>
							<div class="pindan-num">
								<div class="r-num"></div>
							</div>
						</div>
					</div>
					<ul class="parameter">
					</ul>
					<div class="goodsNum">
						<span>数量</span>
						<p>
							<b>-</b>
							<input value="1">
							<b>+</b>
						</p>
						<span class="checkFlag" style="color: red;margin-left: 68px;font-weight: 900;"></span>
					</div>
					<div class="buy">
						<a href="javascript:void(0)" class="addBucket" >加入购物车</a>
						<a href="javascript:void(0)" class="buyNow">立即购买</a>
						<p></p>
					</div>
				</div>
			</div>
			<div class="detailOfItem">
				<div class="service">
					<img src="img/service.jpg">
				</div>
				<a href="" target="_blank">

					<p class="detailGo">查看商品详情</p>
					<p class="store">
						<span></span>
						<!-- <img src="img/tmall.png"> -->
					</p>
					<b>去供货商店</b>
					<img src="img/line-.png" style="margin-left: 10px;margin-top: 0;">
				</a>
				<img src="img/arrow-left.png">
			</div>
			<div class="comment">
				<h4>商品评论</h4>
				<ul>
					
				</ul>
			</div>
		</div>
		<!-- <div id="logpop" align=center> -->
		<!-- <iframe src=https://oauth.taobao.com/authorize?response_type=code&client_id=21784972&redirect_uri=http://pindantuan.cn/php/redirect_url.php&state=1212&view=web style="width:1000px;height:1000px" width=0 height=0>  -->
		<!-- </div> -->
		<?php include 'footer.php';?>
	<script src="js/detail.js"></script>
	<script type="text/javascript">
	//add pindan num aoto
	function pindanNum(){
		var baseNum = 15;
		var addition = Math.floor(Math.random()*15+1);
		var finalNum = baseNum + addition;
		$(".r-num").text(finalNum);
	}
	pindanNum();
	</script>
	</body>
</html>
