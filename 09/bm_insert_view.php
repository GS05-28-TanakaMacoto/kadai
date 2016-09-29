<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
<!--  <link href="css/bootstrap.min.css" rel="stylesheet">-->
 <link type="text/css" rel="stylesheet" href="css/normalize.css" media="all">
  <link href="css/style.css" rel="stylesheet">
  
<!--    <link type="text/css" rel="stylesheet" href="css/style.css" media="all" />-->
    
  <style>div{padding: 10px;font-size:16px;}</style>
</head>

<body>
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="bm_list_view.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<!--<form method="post" action="bm_list_view.php">-->
<form method="post" action="bm_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>以下の項目に入力してください</legend>
     <label><p>書籍名</p><input type="text" name="name" class="inputArea"></label><br>
     <label><p>URL</p><input type="text" name="url" class="inputArea"></label><br>
     <label><p>コメント</p><textArea name="comment" rows="4" cols="40" class="textArea"></textArea></label><br>
     
     <input type="submit" value="送信" class="submit">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>