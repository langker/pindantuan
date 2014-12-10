<!DOCTYPE html>
<html>
	<head>
	     <title></title>
	     <meta charset="utf-8"/>
	     <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	     <link rel="stylesheet" type="text/css" href="css/pure-min.css">
	     <link rel="stylesheet" type="text/css" href="css/myOrder.css">
	     <link rel="stylesheet" type="text/css" href="css/header.css">
	     <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	     <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	     <script type="text/javascript" src="js/myOrder.js"></script>
	    
	</head>
	<body>
		<?php include 'header.php';?>
		<div id="container">
			<div class="shadow"></div>
			<div class="pure-g-r main">
				<div class="pure-u-1 mainTable">
					<!-- 商品表格开始 -->
					<table class="orderTable orderPre">
						<tbody>
							<tr>
					        	<th class="th1">商品信息</th>
					            <th class="th2">单价（元）</th>
					            <th class="th3">数量</th>
					            <th class="th4">店家</th>
					            <th class="th5">总计（元）</th>
					            <th class="th6">操作</th>
		        			</tr>
						</tbody>
					</table>

					<div class="total">
						<div class="batch">
							<input type="checkbox"><span>全选</span>
							<a href="#" class="allOperation"><span>合并付款</span></a>
						</div>
					</div>
				</div>
			</div>
			<div class="shadowSelect">
				<img class="shadowSelectX" src="img/x.png">
				<p class="shadowTit">你确定要永久删除该订单吗？</p>
				<div class="shadowope">
					<button class="shadowYes">确定</button>
					<button class="shadowNo">关闭</button>
				</div>
			</div>
			<div class="orderEmpty">
				<img src="img/myOrder.jpg">
			</div>
			<div class="logistics">
				<div class="logisticsLogo">
					<img class="logisticsCircle" src="img/logisticscircle.png">
					<div class="logisticsIcon">
						<img src="img/cha.png">
					</div>
					<img class="logisticsImg" src="img/logisticLogo.png">
					<p class="logisticsName">物流动态：</p>
				</div>
				<div class="logisticsOther">
					<div class="logisticsOrderNumber">
						<p class="logOrderName">订单编号：</p>
						<p class="logOrderContent logAllContent">LP00021923000805</p>
					</div>
					<div class="logisticsCompany">
						<p class="logComName">物流公司：</p>
						<p class="logComContent logAllContent">天天快递</p>
					</div>
					<div class="logisticsNumber">
						<p class="logNumName">物流编号：</p>
						<p class="logNumContent logAllContent">560122529411</p>
					</div>
				</div>
				<div class="logisticsDetail">
				</div>
				<p class="logistics100">数据由快递100提供<p>
				<img class="logisticsFlagLogo" src="img/car.png">
			</div>
			<div class="orderComment">
				<img src="img/cha.png">
				<form action="php/myOrderfunction.php" method="post" enctype="multipart/form-data">
					<textarea type="text" name="orderContent" placeholder="写点您的使用体验吧" class="orderText"></textarea>
					<input type="hidden" class="orderCommentHidden" name="goodsId" >
					<input type="hidden" name="func" value="orderCommentFunc">
					<input type="hidden" name="orderId" class="orderIdHidden" >
					<input type="submit" class="orderCommentText" value="评价提交">
				</form>
			</div>
		</div>
		<?php include 'footer.php';?>
	</body>
</html>