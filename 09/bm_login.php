<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/main.css" />
<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
    <link type="text/css" rel="stylesheet" href="css/normalize.css" media="all">
    <link href="css/style.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
<title>ログイン</title>
</head>
<body>

<header>
  <nav class="navbar navbar-default">ログイン</nav>
</header>

<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
<form name="form1" action="bm_login_act.php" method="post">

<div class="jumbotron">
<label><p>ID</p><input type="text" name="lid" class="inputArea"/></label><br>
    <label><p>PW</p><input type="password" name="lpw" class="inputArea"/></label>
    
</div><!--END .jumbotron==>

<!--
ID:<input type="text" name="lid" />
PW:<input type="password" name="lpw" />
-->


<input type="submit" value="ログイン" class="submit"/>
</form>


</body>
</html>
