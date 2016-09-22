<?php
include("bm_functions.php");

//1.POSTでParamを取得
$id = $_POST["id"];
$name = $_POST["name"];
$url = $_POST["url"];
$comment = $_POST["comment"];

/*----------------------------------------
2. DB接続するオブジェクト (外部 bm_functions.php で関数化)
----------------------------------------*/
$pdo = db_con();

/*----------------------------------------
３．UPDATE gs_an_table SET ....; で更新(bindValue)
基本的にbm_insert.phpの処理の流れです。

prepare() と　bindValue
SQLインジェクションを防ぐための書き方

:name　:を付けると受け取ったコードを無効化する
 $nameの値は
 1. bindValue　:nameで無効化
 2. prepareで　:nameの中身を有効化して
 3. nameのカラムに収納される
 4. $status = $stmt->execute();で実行

↓ これもセキュリティ対策の記述 ↓ 
PDO::PARAM_STR 文字列(String)
PDO::PARAM_INT 数値(Integer)の場合はこっちを使う
----------------------------------------*/
$stmt = $pdo->prepare("UPDATE gs_bm_table SET name=:name, url=:url, comment=:comment WHERE id=:id");
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //INT（数値なので)
$status = $stmt->execute();

if($status==false){
    queryError($stmt);
}else{
    header("Location: bm_list_view.php");
    exit;
}



?>
