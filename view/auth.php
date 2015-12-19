<!DOCTYPE html>
<html>
<head>
	<title>FunEdu.</title>
</head>
<body>
<?= $this->vars->error ? $this->vars->error : '' ?>
<form method="POST">
<input type="text" name="login" placeholder="Логин">
<input type="password" name="password" placeholder="Пароль">
<input type="submit" value="Войти">
</form>

</body>
</html>
