<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>License Management Server</title>
		<link rel="stylesheet" href="/css/flex.css" />
		<script src="/js/jquery.min.js"></script>
		<script src="/js/add.js"></script>
	</head>

	<body>
		<!-- main-->
		<main class="content-box-center">
			<?php
        include 'templates/navbar.php';

    ?>
			<div class="content-box-data">

				<div class="description-box">
					<h1>Добавить сервер</h1>
					<p>Вы можете добавить сервер указав имя <code class="code-default">port@domain</code><code class="code-default">port@host</code><code class="code-default">port@ipv4</code><br> Порт является необязательным.</p>
				</div>
	
				<div class="content-box-lmutil">
				<div class="edit-form-box">
				<div class="edit-form-input-box">
						<div class="edit-form-block">
							<label for="name">Имя сервера</label>
							<input type="text" name="name" id="name" class="edit-form-input" autocomplete="off" />
						</div>
						<div class="edit-form-block">
							<label for="label">Метка сервера</label>
							<input type="text" name="label" id="label" class="edit-form-input" autocomplete="off" />
						</div>
						<div class="edit-form-block">
							<label for="label">Вендор</label>
							<input type="text" name="label" id="vendor" class="edit-form-input" autocomplete="off" />
						</div>
						</div>

						<div class="edit-form block">
							<input type="checkbox" name="is_active" id="is_active" class="edit-form" checked="" />
							<label for="is_active">Сервер активен</label>
						</div>
						<div class="edit-form block">
							<button type="button" class="btn-cancel">Отменить</button>
							<button type="button" class="btn-success">Добавить</button>
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
