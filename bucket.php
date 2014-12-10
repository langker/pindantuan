<!DOCTYPE html>
<html>
<head>
     <title>购物车-拼单团</title>
     <meta charset="utf-8"/>
     <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
     <link rel="icon" type="image/x-icon" href="img/favicon.ico">
	 <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
     <link rel="stylesheet" type="text/css" href="css/base-min.css">
     <link rel="stylesheet" type="text/css" href="css/grids-min.css">
     <link rel="stylesheet" type="text/css" href="css/bucket.css">
     <link rel="stylesheet" type="text/css" href="css/header.css">
</head>
<body>
	<!-- 标题部分开始 --> 
	<?php include 'header.php';?>
	<div id="container">
		<div class="pure-g-r bucket-title">
			<div class="pure-u-1-3 bucket-image">
				<s></s>
			</div>
			<div class="pure-u-2-3 bucket-step">
				<ul>
					<li>
						<span class="active">查看购物车</span>
					</li>
					<li>
						<span>填写订单</span>
					</li>
					<li class="end">
						<span>付款</span>
					</li>
				</ul>
			</div>
		</div>
		<!-- 标题部分结束 -->
		<div class="pure-g-r bucket-main">
			<div class="pure-u-1 bucket-main-table">
				<!-- 商品表格开始 -->
				<table class="bucket-table bucket-pre">
					<tbody>
						<tr>
				        	<th class="th1">商品信息</th>
				            <th class="th2">单价（元）</th>
				            <th class="th3">数量</th>
				            <th class="th4">总计（元）</th>
				            <th class="th5">操作</th>
	        			</tr>
					</tbody>
				</table>
				<table class="bucket-table bucket-goods">
					<tbody>
						<tr class="bucket-goods-tr">
				            <th class="th1">
				                <span>普通商品</span>
				            </th>
				            <th class="th2"></th>
				            <th class="th3"></th>
				            <th class="th4"></th>
				            <th class="th5"></th>
				        </tr>
					</tbody>
				</table>

				<!-- 商品总价格栏开始 -->

				<div class="bucket-total">
					<div class="bucket-batch">
						<input type="checkbox" checked="checked">
						<span>全选</span>
						<a href="javascript:;">批量删除</a>
					</div>
					<div class="right">
						<p class="price">商品总价（<span>￥250.00</span>）- 活动（<span>￥32.00</span>）= 商品金额总计（<span>￥218.00</span>）</p>
						<p>
							商品总价（免运费）
							<strong>￥218.00</strong>
							元
						</p>
					</div>
				</div>

				<!-- 提交按钮 -->

				<div class="bucket-submit">
					<button class="my-button">去结算</button>
				</div>
			</div>
		</div>
	</div>
	<?php include 'footer.php';?>

	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/bucket.js"  ></script>
	<script type="text/javascript" src="js/header.js"  ></script>
</body>
</html>