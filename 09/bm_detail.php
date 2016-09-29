<?php
session_start();

/*----------------------------------------
0. 外部ファイルの読み込み
 bm_functions.php　が、include()の行に読み込まれる
----------------------------------------*/
include("bm_functions.php");

/*----------------------------------------
ログイン手続きを経由してページに来ているかをチェック
bm_funtion.phpから継承
ログイン後に表示するすべてのページに記載が必要
----------------------------------------*/
ssidCheck();

//  Hint!  update.phpをコピペして編集するとラク


/*----------------------------------------
//1.GETでidを取得　　id取得だけなのでPOSTではなくGETを使う
----------------------------------------*/
$id = $_GET["id"];
//echo $id;

/*----------------------------------------
2. DB接続するオブジェクト (外部化)
関数db_con() にして別ファイル「bm_function.php」に移動
    try {
      $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');  
    } catch (PDOException $e) {
      exit('DbConnectError:'.$e->getMessage());
    }
----------------------------------------*/
$pdo = db_con();

/*----------------------------------------
3.　DBからデータを取得する
SELECT * FROM gs_an_table WHERE id=***; を取得（bindValueを使用！）
PDO::PARAM_STR 文字列(String)
PDO::PARAM_INT 数値(Integer)

もしステイタスがfalseならエラー表示
そうでなければ、１レコードを取得する

$status = $stmt->execute();で実行

$row = $stmt->fetch(); 
    fetch　１レコードのみ取得
    （通常はループで取得だが、id値を指定しているので、帰ってくる値は1レコードだけなので）
----------------------------------------*/
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=:id");
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){
    queryError($stmt);
}else{
    $row = $stmt->fetch(); 
}



//4.select.phpと同じようにデータを取得（以下はイチ例）
// while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
//    $name = $result["name"];
//    $email = $result["name"];
//  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>POSTデータ登録</title>
  <link type="text/css" rel="stylesheet" href="css/normalize.css" media="all">
  <link href="css/style.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>



<!-- Head[Start] -->

<!-- PHPでログインユーザ用の表示をだし分けるため記述を変更する
    <header>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand" href="bm_list_view.php">データ一覧</a></div>
     </nav>
    </header>
-->
<?php include("bm_logout_menu.html"); ?>

<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="bm_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>変更箇所を入力してください</legend>
     <label><p>書籍名</p><input type="text" name="name" value="<?=$row["name"]?>" class="inputArea"></label><br>
     <label><p>URL</p><input type="text" name="url" value="<?=$row["url"]?>" class="inputArea"></label><br>
     <label><p>コメント</p><textArea name="comment" rows="4" cols="40" class="textArea"><?=$row["comment"]?>
     </textArea></label><br>
     
     <input type="hidden" name="id" value="<?=$id?>">
     <!--ブラウザー上には表示されないが id値を送る-->
     
     <input type="submit" value="送信" class="submit">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>






