<!DOCTYPE html>
<html>
<head>
	<title>FunEdu.</title>

    <link href="/static/app/style.css" rel="stylesheet">
</head>
<body>

	<div class="container">
		<div class="login-box">
			<?= $this->vars->error ? $this->vars->error : '' ?>
			<form method="POST">
				<input type="text" name="login" placeholder="Логин"><br>
				<input type="password" name="password" placeholder="Пароль">
				<input type="submit" value="Войти">
			</form>
		</div>
	</div>
</body>
</html>
