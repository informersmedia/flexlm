<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>License Management Server</title>
		<link rel="stylesheet" href="/css/flex.css" />
		<script src="/js/jquery.min.js"></script>
		<script src="/js/delete.js"></script>
	</head>

	<body>
		<!-- main-->
		<main class="content-box-center">

			<?php
			include 'templates/navbar.php';
			include 'config/sql.php';

			$uuid = explode('/delete/', $uri)[1];

			$user = $connect->getDelUser($uuid); // fetch user data 
			if ($user->num_rows > 0) { 
				$string = $user->fetch_assoc(); 
				} 
			?>

			<div class="content-box-data">
				<div class="description-box">
					<h1>Удаление пользователя</h1>
					<p>Вы собираетесь удалить пользователя <code class="code-default"><?php echo $string['usr'] ?></code> из системы. <br> Подтвердите удаление пользователя.</p>
				</div>

				<div class="content-box-lmutil">
					<div class="edit-form-box">
						<div class="edit-form-input-box">
							<div class="edit-form-block">
								<input type="hidden" id="uuid" class="edit-form-input" autocomplete="off" value="<?php echo $string['uuid'] ?>" />
							</div>
					
							</div>

							<div class="edit-form block">
							<button type="button" class="btn-cancel">Отменить</button>
							<button type="button" class="btn-remove btn-delete">Удалить пользователя</button>
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
