<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>大家喜欢</title>
  <meta name="author" content="frankxin">

  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- CSS Reset -->

  <!-- Global CSS for the page and tiles -->
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" type="text/css" href="css/waterfall.css">
  <link type="text/css" rel="stylesheet" href="css/pure-min.css">
  <link type="text/css" rel="stylesheet" href="css/header.css">
  <style type="text/css">
  .pin a{
    text-decoration: none;
  }
  </style>
</head>

<body>

  <?php include 'header.php';?>
  <div id="container" style="margin-top:100px;">
    <div id="main" role="main">

      <ul id="tiles">
        <!-- These are our grid blocks -->
        
        <!-- End of grid blocks -->
      </ul>

    </div>
  </div>
  <div id="loading">
        <p>
            <img src="img/loading.gif">
        </p>
  </div> 
  <?php include 'footer.php';?> 

  <!-- include jQuery -->
  <script src="js/jquery-1.11.1.min.js"></script>

  <!-- Include the imagesLoaded plug-in -->
  <script src="js/jquery.imagesloaded.js"></script>

  <!-- Include the plug-in -->
  <script src="js/jquery.wookmark.js"></script>

  <!-- Once the page is loaded, initalize the plug-in. -->
  <script type="text/javascript">
    // (function ($){
      var $tiles = $('#tiles'),
          $handler = $('li', $tiles),
          $main = $('#main'),
          $window = $(window),
          $document = $(document),
          count = 0,
          thing,
          options = {
            autoResize: true, // This will auto-update the layout when the browser window is resized.
            container: $main, // Optional, used for some extra CSS styling
            offset: 20, // Optional, the distance between grid items
            itemWidth: 250 // Optional, the width of a grid item
          };

      /**
       * Reinitializes the wookmark handler after all images have loaded
       */
      function addDom() {
        //每一小块代码
        var sBlock = "<li><div class=\"pin\"><a href=\"www.baidu.com\" target=\"_blank\"><div class=\"box\"><div class=\"box-img\"><img src=\"\" width=\"249px\" height=\"249px\"></div><div id=\"z-like\"><span class=\"z-price\">￥100</span></div><div id=\"z-title\"><s class=\"qianyin\"></s><span>向超然是个大傻逼你知道吗，好吧你好像不知道</span><s class=\"houyin\"></s></div><div id=\"divide-line\"><s></s></div><div id=\"comment\"><div class=\"sub-comment\"><div class=\"who-comment\"><span></span></div><div class=\"comment-what\"><span></span></div></div></div></div></a></div></li>";
        for (var i = 0; i < thing.length; i++) {
          var sb = $(sBlock);
          $("#tiles").append(sb);
          count++;
        };
      }
      function initSmallBlock() {

        var index0 = count - thing.length ;

        var num = thing.length;  //当前刷新时要添加的数量

        for (var i = 0; i < thing.length; i++) {

          var img = $("#tiles li .pin .box .box-img img").eq(index0);
          var price = $(".z-price").eq(index0);
          var like = $(".z-love span").eq(index0);
          var title = $("#z-title span").eq(index0);
          var url = $(".pin a").eq(index0);
          /*修改价格*/
          var fPrice = "￥" + thing[i].curprice;
          price.text(fPrice);

          /*修改like数量*/
          like.text(thing[i].sellnum);
          title.text(thing[i].name);

          url.attr("href",thing[i].url);

          console.log(thing[i].url);

          /*渲染评论开始*/

          for (var j = 0; j < thing[i].comment.length; j++) {
            /*渲染评论*/
            var name = $(".who-comment span").eq(index0);
            var commt = $(".comment-what span").eq(index0);

            name.text(thing[i].comment[j].username);
            commt.text(thing[i].comment[j].detail);

          };
          img.attr("src", thing[i].imgurl);

          index0++;
        };
        return false;
      }

      function applyLayout() {
        $tiles.imagesLoaded(function() {
          // Destroy the old handler
          if ($handler.wookmarkInstance) {
            $handler.wookmarkInstance.clear();
          }

          // Create a new layout handler.
          $handler = $('li', $tiles);
          $handler.wookmark(options);
        });
      }

      /**
       * When scrolled all the way to the bottom, add more tiles
       */
      function onScroll() {
        var $loading = $("#loading");
        var winHeight = window.innerHeight ? window.innerHeight : $window.height(), 

            closeToBottom = ($window.scrollTop() + winHeight > $document.height() - 200);

        if (closeToBottom) {
          // Get the first then things from the grid, clone them, and add them to the bottom of the grid
          // var $things = $('li', $tiles),
          //     $firstTen = $items.slice(0, 10);
          $loading.css("display","block"); 
          requestItem();
        }
      };

      function requestItem(){
        $window.unbind();
        $.post("php/waterfall.php",{page : count},function(data){
            var tempdata = data.substr(1,data.length);
            thing = JSON.parse(tempdata);
            if (thing != '') {
              console.log(thing);
              addDom();
              initSmallBlock();
              applyLayout();

            }else{
              $("#loading").css("display",'none');
              $("#main").css("padding-bottom","270px");
              $("#footer").css("display",'block');
            }
          })
      }
      //set loading img position
      function setLoading(){
        var widthL = $(window).width(),
            $loading = $("#loading"),
            leftPosition = widthL/2 - 512;
        $loading.css("left",leftPosition + 'px');
      }
      setLoading();
      // Call the layout function for the first time
      $("#loading").css("display","block");
      $("#footer").css("display","none");
      $.post("php/waterfall.php",{page : count},function(data){
            var tempdata = data.substr(1,data.length);
            thing = JSON.parse(tempdata);
            console.log(thing);
            addDom();
            initSmallBlock();
            applyLayout();
          })
      

      // Capture scroll event.


    // })(jQuery);
  </script>
  <script src="js/header.js"></script>
</body>
</html>
