
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>KindEditor PHP</title>
	<link rel="stylesheet" href="../themes/default/default.css" />
	<link rel="stylesheet" href="../plugins/code/prettify.css" />
	<script charset="utf-8" src="../kindeditor.js"></script>
	<script charset="utf-8" src="../lang/zh_CN.js"></script>
	<script charset="utf-8" src="../plugins/code/prettify.js"></script>
	<script>
		KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="content1"]', {
				cssPath : '../plugins/code/prettify.css',
				uploadJson : '../php/upload_json.php',
				fileManagerJson : '../php/file_manager_json.php',
				allowFileManager : true,
				afterCreate : function() {
					var self = this;
					K.ctrl(document, 13, function() {
						self.sync();
						K('form[name=example]')[0].submit();
					});
					K.ctrl(self.edit.doc, 13, function() {
						self.sync();
						K('form[name=example]')[0].submit();
					});
				}
			});
			prettyPrint();
		});
	</script>
</head>
<body>
	
	<form name="example" method="post" action="../../php/houtai.php" >

		<textarea name="content1" style="width:700px;height:200px;visibility:hidden;">
		</textarea>
		<br />
		<input type="text" name="title" style="width:500px" placeholder="标题"/>
		<br />
		<input type='hidden' name="func"  value="AddArticle">
		<br />
		<input type="text" name="date" style="width:500px" placeholder="日期，以-分开">
		<br />
		<input type="text" name="goodsTit" style="width:500px" placeholder="商品栏标题">
		<br />
		<input type="text" name="goodsId" style="width:500px" placeholder="商品id，以&分开">
		<br />
		<input type="submit" name="button"  value="提交内容" /> 
	</form>
	<form method="post" action="../../php/uploadart.php" enctype="multipart/form-data">
		<input type='file' name="picture" >
		<br />
		<input type="submit" name="button"  value="提交内容" />
	</form>
</body>
</html>

