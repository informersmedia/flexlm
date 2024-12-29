<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>License Management Server</title>
		<link rel="stylesheet" href="/css/flex.css" />
		<script src="/js/jquery.min.js"></script>
		<script src="/js/edit.js"></script>
	</head>

	<body>
		<!-- main-->
		<main class="content-box-center">

			<?php
			include 'templates/navbar.php';
			include 'config/sql.php';

			$uuid = explode('/edit/', $uri)[1];

			$server = $connect->getServer($uuid); // fetch server data 
			if ($server->num_rows > 0) { 
				$string = $server->fetch_assoc(); 
				} 
			?>

			<div class="content-box-data">
				<div class="description-box">
					<h1>Редактировать сервер</h1>
					<p>Вы можете изменить данные сервера имя <code class="code-default">port@domain</code> и другую информацию. <br> Или удалить сервер из системы.</p>
				</div>

				<div class="content-box-lmutil">
					<div class="edit-form-box">
						<div class="edit-form-input-box">
							<div class="edit-form-block">
								<label for="name">Имя сервера</label>
								<input type="hidden" id="uuid" class="edit-form-input" autocomplete="off" value="<?php echo $string['uuid'] ?>" />
								<input type="text" id="sname" class="edit-form-input" autocomplete="off" value="<?php echo $string['sname'] ?>" />
							</div>
							<div class="edit-form-block">
								<label for="label">Метка сервера</label>
								<input type="text" id="slabel" class="edit-form-input" autocomplete="off" value="<?php echo $string['slabel'] ?>" />
							</div>
							</div>

							<div class="edit-form block">
								<input type="checkbox" id="sactive" class="edit-form" checked="" />
								<label for="sactive">Сервер активен</label>
							</div>
							<div class="edit-form block">
							<button type="button" class="btn-cancel">Отменить</button>
							<button type="button" class="btn-success">Сохранить</button>
							<button type="button" class="btn-remove">Удалить сервер</button>
						</div>
					</div>
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
