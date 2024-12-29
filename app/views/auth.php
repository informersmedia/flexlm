<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>License Management Server</title>
		<link rel="stylesheet" href="css/flex.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/auth.js"></script>
	</head>

	<body>
		<!-- main-->
		<main class="content-box-center">
			<?php
        include 'templates/navbar.php';

    ?>
			<div class="content-box-data">

				<div class="description-box">
					<h1>Вход в систему</h1>
					<p>Только для зарегистрированных в системе. <br> Для входа в профиль используется электронная почта формата <code class="code-default">user@mail.ru</code> и пароль.</p>
				</div>
				


				<div class="content-box-lmutil">

				<div class="edit-form-box">
				<div class="edit-form-input-box">
						<div class="edit-form-block">
							<label for="name">Электронная почта</label>
							<input type="text" id="uemail" class="edit-form-input" autocomplete="off" />
						</div>
						<div class="edit-form-block">
							<label for="label">Пароль</label>
							<input type="password" id="upwd" class="edit-form-input" autocomplete="off" />
						</div>
						</div>
						<div class="edit-form block">
							<button type="button" class="btn-cancel">Отменить</button>
							<button type="button" class="btn-success btn-auth">Вход в систему</button>
						</div>
					</div>

				</div>
			</div>
		</main>

		<!-- footer -->
		<footer class="footer-box-center">
    <?php
        include 'templates/build.php';
    ?>
    </footer>
	</body>
</html>
