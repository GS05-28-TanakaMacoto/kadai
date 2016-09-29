<?php

//関数を作る考え方->共通化できるものを関数にする

/*--------------------------------
//ログイン　LoginCheckのための関数

!isset($_SESSION["schk"])  
        // $_SESSION["schk"] = session_id();　
        // ※bm_login_act.php 77行目に記載のコード
    !isset !で否定 
    $_SESSION["schk"]にsession_id()がセットされていなければ
    ログインしてこのページへ来ていない
$_SESSION["schk"]!=session_id()　
    !=　右辺と左辺が等しくなければの意味
    || または
    
exit("Error!!");　（注）本来はエラー表示を出すのはNG ※暫定的に記述

!!セキュリティ対策!! ページを遷移する時はsession_id();を乗り換える
session_regenerate_id();　
    新しいsessionIDを発行する
$_SESSION["schk"]=session_id();　
    $_SESSION["schk"]に新しいsession_id();を代入
    
各ページに記述が必要なので、
function ssidCheck()関数に入れて使いまわす

$_SESSION　スーパーグローバル変数　どこからでも見れるので
ssidCheck()の（）に渡す変数はない
--------------------------------*/
function ssidCheck(){
  if(
     !isset($_SESSION["schk"]) ||
     $_SESSION["schk"]!=session_id()
    ){
    exit("Error!!"); //本来エラー表示しない
  }else{
    session_regenerate_id();
    $_SESSION["schk"]=session_id();
  }
}


/*--------------------------------
DB接続関数（PDO）　定型文
----------------------------------
try 行目から ７行後の } まで
これをdb_con()関数に入れて必要なファイルで流用する

dbname='' id=root pw='' を必要に応じて変更する

PDOに入るDBネーム'gs_db'も関数化して外出しすると
DB名が変更になっても $dbname ='gs_db' を修正すれば良いのでさらに運用が楽になる

!! return 戻り値;  !!
$pdoを呼び出し元のファイルに返すために　return $pdo; する
（$pdoは関数の外に運び出せない > return文で許可する）
$pdo = db_con();　 <-呼び出し元にはこの１行を記述する


--------------------------------*/
function db_con(){
    $dbname ='gs_db'; //実際には変数でなく定数を入れる
    try {
      $pdo = new PDO('mysql:dbname='.$dbname.';charset=utf8;host=localhost','root','');
    } catch (PDOException $e) {
      exit('DbConnectError:'.$e->getMessage());
    }
    return $pdo;
}

/*--------------------------------
SQL処理エラー　（定型文）
SQL実行時にエラーがある場合エラーオブジェクトを実行

関数の外に出す値はないので、変数をreturnする必要はない

1 SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）する命令
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);

2 関数function queryError()に上記命令を入れる

3 function queryError()の()に$stmtを渡す
関数queryErrorの中に$stmtを渡さないと関数が実行されない

!!!!!!!!! ここわからない !!!!!!!!!
()の中に$stmtを渡す理由は　
$errorではだめなの？
YouTube/https://youtu.be/PQ1J8tUuvCE 55:10
bm_insert.php 102行目に連動

--------------------------------*/
function queryError($stmt){
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);   
}



/*--------------------------------
* XSS
　phpを安全にechoさせるための関数
　h()に入れる
 
* @Param:  $str(string) 表示する文字列
* @Return: (string)     サニタイジングした文字列
--------------------------------*/
function h($str){
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}


?>
