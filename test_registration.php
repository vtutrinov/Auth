<html>
<head>
 <title>Регистрация</title>
</head>
<body>
	<form action="" method="get">
		Логин<input type="text" name="login">
		Пароль<input type="password" name="pass">
		<input type="submit" value="Сохранить">
	</form>
<?php
	if ($_GET) {
		echo "Ваш пароль:".$_GET['pass']."<br>";
		echo "Зашифрованный пароль: ".md5($_GET["pass"]);
	}
?>

</body>
</html>
