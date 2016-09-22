<?php

//var_dump($_POST);
//exit;

/*----------------------------------------
0. 外部ファイルの読み込み
 bm_functions.php　が、include()の行に読み込まれる
----------------------------------------*/
include("bm_functions.php");


/*----------------------------------------
1. DB接続するオブジェクト
関数db_con() にして別ファイル「bm_function.php」に移動
    try {
      $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');  
    } catch (PDOException $e) {
      exit('DbConnectError:'.$e->getMessage());
    }
----------------------------------------*/
$pdo = db_con();


//２．データ登録SQL作成
//問題： 最新の5件のみ表示するSQLに変更してブラウザで表示してみてね
//gs_an_tableをリネーム
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table ORDER BY indate DESC");
$status = $stmt->execute();


/*----------------------------------------
//３．データ表示

URLの後ろにID名を加えてデータを渡す
$view .= '<a href="bm_detail.php?id='.$result["id"].'">';

！！！「変数」をHTMLに書き出すときのセキュリティ（重要）　！！！
$view .= $result["name"]."[".$result["indate"]."]";
　↓　下のように書き換える
$view .= h($result["name"])."[".h($result["indate"])."]";
h()に入力内容を入れ、内容を無効化することでセキュリティを担保
（※db_function.phpに h の関数あり）
idは数値を運ぶだけなので h しなくても良い
----------------------------------------*/
$view="";
if($status==false){
    // execute（SQL実行時にエラーがある場合）
    // $error = $stmt->errorInfo();
    // exit("ErrorQuery:".$error[2]);
     queryError($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
      $view .= '<li class="list_row">';
      $view .= '<a href="bm_detail.php?id='.$result["id"].'"><span class="list_title">';
//    $view .= $result["name"]."[".$result["indate"]."]";　//次のように書きなおす
      $view .= h($result["name"]).'<span class="list_date">　詳細を表示　></span></span></br><span class="list_date">'.h($result["indate"]).'</span>';
      $view .= '</a>　'; //リンクと削除の間にスペースを作る
      $view .= '<a href="bm_delete.php?id='.$result["id"].'" class="list_btn">';
      $view .= '削除';
      $view .= '</a>';
      $view .= '</li>';     
  }
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
 <link type="text/css" rel="stylesheet" href="css/normalize.css" media="all">
  <link href="css/style.css" rel="stylesheet">
<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
 <link type="text/css" rel="stylesheet" href="css/normalize.css" media="all">
  <link href="css/style.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="bm_insert_view.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><ul><?=$view?></ul></div>　
    
    <div>
        
        
    </div>
    <!-- ここで無効化 h($view?) をするとエラーが起きる場合あり
    その場合は56行目　文字を作るところでhをかける-->
</div>
<!-- Main[End] -->

</body>
</html>