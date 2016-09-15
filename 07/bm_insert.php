<?php
//var_dump($_POST);
//exit;
//1. POSTデータ取得

$name = $_POST["name"];
$url = $_POST["url"];
$comment = $_POST["comment"];


//2. DB接続するオブジェクト$pdp  dbname= id=root pw='' だけ書き換え　コピペでOK
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');  
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成　 SQLインジェクションを防ぐために間にbind変数　:a1に値を渡す
//　PDO::PARAM_STR文字列　INT数字　セキュリティ対策
//　$status = $stmt->execute();で実行　gs_an_table
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, name, url, comment,
indate )VALUES(NULL, :a1, :a2, :a3, sysdate())");
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}else{
    
//５．index.phpへリダイレクト　　header("Location:はリダイレクトの命令 
//    Location: index.php :の後ろに必ず半角スペースを開ける事
    
  header("Location: bm_list_view.php");
  exit;

}
?>