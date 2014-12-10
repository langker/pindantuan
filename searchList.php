<!DOCTYPE html>
<html lang="zh">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="基于Pure进行扩展">
    	<title>searchList</title>

		<link rel="stylesheet" href="css/base-min.css">
		<link rel="stylesheet" href="css/grids-min.css">
		<link rel="stylesheet" href="css/list.css">
		<link rel="icon" type="image/x-icon" href="img/favicon.ico">
    	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="css/header.css">
		<script src="js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js/jquery.lazyload.js"></script>

	</head>
	<body>
		<?php include 'header.php';?>
		<div id="container">
			<!-- 海报 -->
		<!-- 	<section class="listHeaderPoster" >
				<img src="../img/testPoster.jpg">
			</section> -->

			<!-- 分类地图 -->
			<!-- <ul class="listHeaderMap pure-g-r">
				<li class="list_nav_1 pure-u-1-3">
					<dl>
						<dt>女人广场</dt>
						<dd><a href="">上衣</a></dd>
						<dd><a href="">夏装</a></dd>
						<dd><a href="">包袋</a></dd>
						<dd><a href="">鞋子</a></dd>
						<dd><a href="">配饰</a></dd>
					</dl>
				</li>
				<li class="list_nav_2 pure-u-1-3">
					<dl>
						<dt>男人广场</dt>
						<dd><a href="">上衣</a></dd>
						<dd><a href="">夏装</a></dd>
						<dd><a href="">包袋</a></dd>
						<dd><a href="">鞋子</a></dd>
						<dd><a href="">配饰</a></dd>
					</dl>
				</li>
				<li class="list_nav_3 pure-u-1-3">
					<dl>
						<dt>电脑周边</dt>
						<dd><a href="">鼠标</a></dd>
						<dd><a href="">电脑包</a></dd>
						<dd><a href="">散热器</a></dd>
						<dd><a href="">鼠标垫</a></dd>
						<dd><a href="">内胆包</a></dd>
					</dl>
				</li>
				<li class="list_nav_3 pure-u-1-3">
					<dl>
						<dt>电脑周边</dt>
						<dd><a href="">鼠标</a></dd>
						<dd><a href="">电脑包</a></dd>
						<dd><a href="">散热器</a></dd>
						<dd><a href="">鼠标垫</a></dd>
						<dd><a href="">内胆包</a></dd>
					</dl>
				</li>
				<li class="list_nav_1 pure-u-1-3">
					<dl>
						<dt>女人广场</dt>
						<dd><a href="">上衣</a></dd>
						<dd><a href="">夏装</a></dd>
						<dd><a href="">包袋</a></dd>
						<dd><a href="">鞋子</a></dd>
						<dd><a href="">配饰</a></dd>
					</dl>
				</li>
				<li class="list_nav_1 pure-u-1-3">
					<dl>
						<dt>女人广场</dt>
						<dd><a href="">上衣</a></dd>
						<dd><a href="">夏装</a></dd>
						<dd><a href="">包袋</a></dd>
						<dd><a href="">鞋子</a></dd>
						<dd><a href="">配饰</a></dd>
					</dl>
				</li>
			</ul> -->

			<!-- 搜索结果 -->
			<SECTION class="listHeaderSearch">
				<div>
					<input value="">
					<img src="img/search.png">
				</div>
			</SECTION>


			<section class="listFilterBox">
				<h2></h2>
				<div class="listFilter">
					<a href="javascript:void(0)">销量</a><img src="img/down.png">
					<a href="javascript:void(0)">价格</a><img src="img/updown.png">
				</div>
			</section>

			<section id="listContent">

				<ul class="listGoods pure-g-r">
					<img class="noResult" src="img/noResult.png" style="display:none">
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href="">脊椎动物 简约印花休闲T恤 圆领短袖Tee 基础打底衫 男装</a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href="">脊椎动物 简约印花休闲T恤 圆领短袖Tee 基础打底衫 男装</a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href="">脊椎动物 简约印花休闲T恤 </a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""> 圆领短袖Tee 基础打底衫 男装</a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href="">脊椎动物 简约印花休闲T恤 圆领短袖Tee 基础打底衫 男装</a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href="">脊椎动物 简约印花休闲T恤 圆领短袖Tee 基础打底衫 男装</a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href="">脊椎动物 简约印花休闲T恤 </a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""> 圆领短袖Tee 基础打底衫 男装</a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
					<li class="pure-u-1-4">
						<div class="listGoodsItem">
							<a class="listGoodsItemImg" href=""><img class="lazy" src="img/loading.gif" data-original="img/3.jpg"></a>
							<h3><a href=""></a></h3>
							<div class="listGoodsItemDetail">
								<div class="nowprice">拼单价<span>¥20</span></div>
								<div class="oriprice">淘宝价<span>¥25</span></div>
								<div class="sales">销量<span>30</span></div>
							</div>
						</div>	
					</li>
				</ul>

				<ul class="listPages">
					<li class="prePage"><a href="javascript:void(0)">上一页</a></li>
					<li class="page"><a href="javascript:void(0)">a</a></li>
					<li class="morePgae">...</li>
					<li class="page"><a href="javascript:void(0)">b</a></li>
					<li class="page"><a href="javascript:void(0)">c</a></li>
					<li class="page"><a href="javascript:void(0)">d</a></li>
					<li class="morePgae">...</li>
					<li class="page"><a href="javascript:void(0)">e</a></li>
					<li class="nextPage" ><a href="javascript:void(0)">下一页</a></li>
				</ul>
			</section>
		</div>
		<?php include 'footer.php';?>
		<script src="js/list.js"></script>
		<script src="js/searchList.js"></script>
		
	</body>
</html>