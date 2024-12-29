<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>License Management Server</title>
		<link rel="stylesheet" href="css/flex.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/admin.js"></script>
	</head>

	<body>
		<!-- main-->
		<main class="content-box-center">
			<?php
        include 'templates/navbar.php';

    ?>
			<div class="content-box-data">

				<div class="description-box">
					<h1>Панель администратора</h1>
					<p>Вы можете изменить имя существующего сервера, метку, статус активности или добавить сервер. Имена серверов должны быть уникальными и иметь форму <code class="code-default">port@domain</code><code class="code-default">port@host</code><code class="code-default">port@ipv4</code></p>
				</div>
				
				<div class="com-box">
				<button type="button" class="btn-default btn-server">Добавить сервер</button>
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
