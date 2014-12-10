<?php
	include_once "../common/configsql.php";
	$db=ConnectDB("article");

	$goods=array();	
	$row=$db->find(array("id"=>$_GET["id"],));
	foreach($row as $key=>$value)
	{
		$goodsid=$value["goodsid"];
	}
	$db=ConnectDB("goods_shoes");
	for($i=0;$i<count($goodsid);$i++)
	{
		$rows=$db->find(array("goodsid"=>$goodsid[$i],"iskey"=>array('$ne'=>0)));
		foreach($rows as $key=>$value)
		{
			array_push($goods,array("pic"=>"../photo/".$value["goodsid"]."/1.jpg","title"=>$value["goodsname"],"type"=>$value["iskey"]-1,"TBprice"=>$value["origprice"],"PDprice"=>$value["subprice"],"url"=>$value["url"]));
		}

	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>openbox</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/global.css">
	<link rel="stylesheet" type="text/css" href="css/detail.css">
	<link rel="stylesheet" href="dist/idangerous.swiper.css">
	<link rel="stylesheet" type="text/css" href="css/mobileArticle.css">
</head>
<body>
	<div class="swiperBox">
		<p class="swiperTit">相关商品推荐</p>
		<div class="swiper-container">
		<div class="swiper-wrapper">
		  <?php for($i=0;$i<count($goods);$i++){?>
		      <div class="swiper-slide">
		        <div class="carouselPic">
		        	<a href=<?php echo $goods[$i]["url"];?>><img src=<?php echo $goods[$i]["pic"];?>></a>
		        	<div class="carouselDetail">
		        		<p class="carouselTit"><?php echo $goods[$i]["title"];?></p>
		        		<div class="carouselPri">
		        			<p class="carouselPrice"><?php echo $goods[$i]["TBprice"];?></p>
		        			<p>¥</p>
		        		</div>
		        		<div class="clear"></div>
		        	</div>
		        </div>
		      </div>
		      <?php }?>
		  </div>
		
		  <div class="pagination"></div>
		</div>
	</div>
	<div class="headerTit">
		<img src="img/welcome1.jpg">
	</div>
	<div class="header">
		<ul>
			<li><img src="img/logo.png"></li>
			<li class="header-tittle"><p>让人温暖的好看的电影</p></li>
		</ul>
	</div>
	<div class="content">
		<div class="content-detail">
			<p>
				<span style="color:#222222;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:13.3333330154419px;line-height:14.7333335876465px;"><span style="font-family:Pinghei;font-size:14px;">&nbsp;</span><span style="font-family:Pinghei;font-size:14px;">吃得饱饱的带着被治愈的心情来答题，果然冬天里最治愈人心的，还是热腾腾的食物啊。</span></span><span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">可以在冬天看的治愈系日剧日影还挺多的，比如比较生活化的小品剧：</span> 
			</p>
			<p>
				<img src="http://pic2.zhimg.com/bfba52c18823a5e23961e1bbf8422b8a_b.jpg" /> 
			</p>
			<p>
				<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">先拿个压箱底的表示一下诚意：</span><br />
			<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">仓本聪的富野良三部曲：《敬启、父亲大人》、《温柔时刻》、《风之庭院》。</span><br />
			<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">这三部都是讲述平凡人生活的温情作品，不急不缓，娓娓道来。</span> 
			</p>
			<p>
				<img src="http://pic1.zhimg.com/c8cb59a3ad0f472c6cc9999d749579d9_b.jpg" /> 
			</p>
			<p>
				<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">治愈系演员小林聪美的作品：《海鸥食堂》、《面包和汤和猫咪好天气》。</span><br />
			<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">小林聪美很适合演绎这类剧，一举一动中，都能感受到那种从容、随遇而安的人生态度。</span><br />
			<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">光看名字就觉得很治愈了</span> 
			</p>
			<p>
				<img src="http://pic3.zhimg.com/eeab1d87a806f568dc81d98805e7afcb_b.jpg" /> 
			</p>
			<p>
				<br />
			</p>
			<p>
				<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">一大波美食即将袭来之美食类：</span> 
			</p>
			<p>
				<span style="color:#222222;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:13.3333330154419px;line-height:14.7333335876465px;"><br />
			</span> 
			</p>
			<p>
				<img src="http://pic1.zhimg.com/ef0a8d095ba166ceaad49672302c982a_b.jpg" /> 
			</p>
			<p>
				<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">汗，好像答着答着就有些跑题了。</span><br />
			<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">碍于本人“容易被治愈”的体质，以上推荐不能完全算作“治愈系”，仅供参考。如有更多需求，可以去看我的日剧专栏&nbsp;</span><span style="color:#222222;font-size:14px;line-height:14.7333335876465px;"><a href="http://www.zhihu.com/" target="_blank"><span style="color:#006600;background-color:#FFFFFF;"><u>知乎专栏</u></span></a></span><br />
			<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">至于动画和书，暗黑系看得比较多，除了《少年同盟》、《调酒师》、《白兔糖》、《断舍离》（书），暂时想不到可以推荐的，见谅啦。</span><br />
			<span style="color:#222222;font-family:Pinghei;font-size:14px;line-height:14.7333335876465px;">冬天快乐</span> 
			</p>
		</div>
		<div class="contentLike"><p>赞一个</p></div>
	</div>
	<script type="text/javascript" src="lib/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/mobileDetail.js"></script>
	<script src="dist/idangerous.swiper.min.js"></script>
	
</body>
</html>