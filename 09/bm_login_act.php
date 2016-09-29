<?php
/*--------------------------------
//３．session  サーバー側に変数を残す

session_id()関数　ブラウザに割る振られるキー(cookie）
cookieは更新しない限り変わらない・更新すると新しいキーが発行される
session_start();　sessionを扱うときは最初に書く!!約束事!!


--------------------------------*/
session_start();
include("bm_functions.php");

/*--------------------------------
パラメータチェック
isset　POST経由で正当に入力されているかチェック
! isset  「！」があるので「issetされてなければ」否定の意味
--------------------------------*/
if(
  !isset($_POST["lid"]) || $_POST["lid"]=="" ||
  !isset($_POST["lpw"]) || $_POST["lpw"]==""
  )
{
  header("Location: bm_login.php");
  exit();
}

//1. 接続します
$pdo = db_con();

/*--------------------------------
//３．データ登録SQL作成

lid ID / lpd パスワード
AND life_flg=0" 退会者[１]を排除　アクティブユーザー[0]のみ選択するための記述
$res = $stmt->execute();　bind変数の処理を実行する命令
$res　処理を実行した値に対してエラーが起きると$resにfalseの値が返る
--------------------------------*/
$sql="SELECT * FROM gs_user_table WHERE lid=:lid AND lpw=:lpw AND life_flg=0";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $_POST["lid"]);
$stmt->bindValue(':lpw', $_POST["lpw"]);
$res = $stmt->execute();
//SQL実行時にエラーがある場合は $resにfalseの値が返る　
if($res==false){
    queryError($stmt);
}

/*--------------------------------
//５．抽出データ数を取得

$val = $stmt->fetch();  1レコードだけ取得する方法 
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
--------------------------------*/
$val = $stmt->fetch(); 


/*--------------------------------
//6. 該当レコードがデータベースにあればSESSIONに値を代入

$val["id"] != "" 　　 != "" カラと等しくない＝何か値が入っている状態
 (この場合何か値が戻っていているなら、それはIDである)
 -->ログイン認証を許可する
 
$_SESSION["schk"] = session_id();   
    session_id();　自動的にセッションキーを割り当てる関数
    認証OKだった時はそのIDを　$_SESSION["schk"] に渡す
 
$_SESSION["name"]=$val["name"];
     $val["name"]データベースが持っているname値
     $_SESSION["name"]= session変数に$val["name"]を渡す
--------------------------------*/
if( $val["id"] != "" ){
  $_SESSION["schk"] = session_id();
  $_SESSION["name"]=$val["name"];
  $_SESSION["kanri_flg"]=$val["kanri_flg"];
  header("Location: bm_list_view.php");
}else{
  //logout処理を経由して前画面へ
  header("Location: bm_login.php");
}

exit();



?>

