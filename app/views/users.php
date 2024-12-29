<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>License Management Server</title>
		<link rel="stylesheet" href="css/flex.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/users.js"></script>
	</head>

	<body>
		<!-- main-->
		<main class="content-box-center">
			<?php
        include 'templates/navbar.php';

    ?>
			<div class="content-box-data">

				<div class="description-box">
					<h1>Все пользователи</h1>
					<p>Все пользовальтели зарегистрированные в системе. <br> Для входа в профиль используется электронная почта формата <code class="code-default">user@mail.ru</code> и пароль.</p>
				</div>
				
		
				<div class="com-box">
				<button type="button" class="btn-default btn-user">Создать пользователя</button>
                </div>

				<div class="content-box-lmutil">

				<div id="output"></div>
			

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
