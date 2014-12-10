<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="基于Pure进行扩展">
    	<title>收货信息-拼单团</title>

		<link rel="stylesheet" href="css/base-min.css">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
    	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/grids-min.css">
		<link rel="stylesheet" href="css/header.css">
		<link rel="stylesheet" href="css/settlement.css">
		<script src="js/jquery-1.11.1.min.js"></script>
	</head>
	<body>
		<?php include 'header.php';?>
		<div id="container">
			<div class="recvInfo">
				<div id="baseRecvInfo">
					<h3>收货信息</h3>
					<div class="myAddress">地址：
						<span class="baseAddress">电子科技大学沙河校区</span>
						<input class="lastAddress" value="">
						<b></b>
						<img src="img/ok.png">
					</div>
					<div class="realName">收货人：<input value=""><span></span><img src="img/ok.png"></div>
					<div class="phone">收货电话：<input value=""><span></span><img src="img/ok.png"></div>
				</div>
				<div class="payment">
					<h3>付款方式</h3>
					<span><img src="img/zhifubao.png"></span>
				</div>
				<div class="express">
					<h3>物流服务</h3>
					<span><b>全场包邮</b><b>隔日到货</b><p>下午四点之后的订单，记入下一天订单</p></span>
				</div>
			</div>
			<div class="orderConfirm">
				<h3>订单确认</h3>
				<div>
					<ul class="statusBar pure-g-r">
						<li class="pure-u-2-5">商品信息</li>
						<li class="pure-u-1-5">拼单价</li>
						<li class="pure-u-1-5">数量</li>
						<li class="pure-u-1-5">总计</li>
					</ul>
					<ul class="orderUnpaid">
						<h4><span></span></h4>

					</ul>
					<ol class="orderUnpaidList">
					</ol>
				</div>
			</div>

			
			<!-- 立即付款 -->
			<div class="payInfo">
				<!-- <h4><input type="checkbox"class="all">全选</h4> -->
				<p>为您节省了<span>¥20</span>实际应付:<span>¥40</span></p>
			</div>

			

			<!-- <div class="payGo">
				<a href="javascript:void(0)" >立即结算</a>
				<span></span>
			</div> -->
		</div>
		<div id="afterPay">
			<ul>
				<li class="payOver"><a href="http://www.pindantuan.cn/myOrder.php">已完成付款</a></li>
				<li class="pagAgain"><a href="http://www.pindantuan.cn/myOrder.php">重新支付</a></li>
			</ul>
		</div>
		<form action="php/settlementfunction.php" method="post" target= "_blank">
		  <p><input type="text" name="func" /></p>
		  <p><input type="text" name="area" /></p>
		  <p><input type="text" name="buynow" /></p>
		  <p><input type="text" name="phone" /></p>
		  <p><input type="text" name="name" /></p>
		  <p><input type="text" name="address" /></p>
		  <input class="payGo" type="submit" disabled="disabled" value="立即结算"/>
		</form>
		<?php include 'footer.php';?>
	<script src="js/settlement.js"></script>
	</body>
</html>