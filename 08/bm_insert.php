<?php
//var_dump($_POST);
//exit;

/*----------------------------------------
3. 外部ファイルの読み込み
 bm_functions.php　が、include()の行に読み込まれる
----------------------------------------*/
include("bm_functions.php");

/*----------------------------------------
4. 入力チェック(受信確認処理追加)
もし内容がカラだったらエラー ParamError 表示
POSTを使った入力値が入ってこない時は不正アクセス'ParamError'を出して処理を止める
----------------------------------------*/
if(
  !isset($_POST["name"]) || $_POST["name"]=="" ||
  !isset($_POST["url"]) || $_POST["url"]=="" ||
  !isset($_POST["comment"]) || $_POST["comment"]==""
){
  exit('ParamError');
}

/*----------------------------------------
//1. POSTデータ取得
----------------------------------------*/
$name = $_POST["name"];
$url = $_POST["url"];
$comment = $_POST["comment"];


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
３．データ登録SQL作成　 

prepare() と　bindValue
SQLインジェクションを防ぐための書き方

:a1　:を付けると受け取ったコードを無効化する
 $nameの値は
 1. bindValue　:a1で無効化
 2. prepareで　:a1の中身を有効化して
 3. nameのカラムに収納される
 4. $status = $stmt->execute();で実行

↓ これもセキュリティ対策の記述 ↓ 
PDO::PARAM_STR 文字列(String)
PDO::PARAM_INT 数値(Integer)の場合はこっちを使う
----------------------------------------*/
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, name, url, comment,
indate )VALUES(NULL, :a1, :a2, :a3, sysdate())");
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);  
$stmt->bindValue(':a2', $url, PDO::PARAM_STR);  
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);  
$status = $stmt->execute();

/*----------------------------------------
４．データ登録処理後（通常表記）
if($status==false){
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
    queryError();
}else{
  header("Location: bm_list_view.php");
  exit;
}
    もし
    SQL実行時にエラーがある場合
    エラーオブジェクト「$error」を取得・表示してphpを終了
    （ここは外部関数queryError()に変更）
    そうでなければ
    ページをリダイレクトさせてphpを終了

header("Location: 　");
    Location: の後ろに必ず半角スペース
    bm_list_view.phpへリダイレクトする命令

関数名queryError()を作り、以下の命令を外部関数化
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);


()の中に$stmtを渡す理由は
YouTube/https://youtu.be/PQ1J8tUuvCE 55:10
bm_functions.php 83行目に連動

----------------------------------------*/
if($status==false){
    //  $error = $stmt->errorInfo();
    //  exit("QueryError:".$error[2]);
    queryError($stmt);
}else{
  header("Location: bm_list_view.php");
  exit;
}


?>