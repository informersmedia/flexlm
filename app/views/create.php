<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>License Management Server</title>
		<link rel="stylesheet" href="css/flex.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/create.js"></script>
	</head>

	<body>
		<!-- main-->
		<main class="content-box-center">
			<?php
        include 'templates/navbar.php';

    ?>
			<div class="content-box-data">

				<div class="description-box">
					<h1>Создать пользователя</h1>
					<p>Вы можете создать нового пользователя указав данные в форме регистрации. <br> Необходимо заполнить поля <code class="code-default">Имя</code><code class="code-default">Почта</code><code class="code-default">Пароль</code><code class="code-default">Проект</code></code><code class="code-default">Домен</code></p>
				</div>
	
				<div class="content-box-lmutil">
				<div class="edit-form-box">
				<div class="edit-form-input-box">
				<div class="input-box-one">
						<div class="edit-form-block">
							<label for="name">Имя пользователя</label>
							<input type="text" name="usr" id="usr" class="edit-form-input" autocomplete="off" />
						</div>
						<div class="edit-form-block">
							<label for="label">Электронная почта</label>
							<input type="text" name="uemail" id="uemail" class="edit-form-input" autocomplete="off" />
						</div>
						<div class="edit-form-block">
							<label for="label">Пароль</label>
							<input type="text" name="upwd" id="upwd" class="edit-form-input" autocomplete="off" />
						</div>
						<div class="edit-form-block">
							<label for="label">Проект</label>
							<input type="text" name="uproject" id="uproject" class="edit-form-input" autocomplete="off" />
						</div>
						<div class="edit-form-block">
							<label for="label">Домен</label>
							<input type="text" name="udomain" id="udomain" class="edit-form-input" autocomplete="off" />
						</div>
				</div>
				<div class="input-box-two">
						<div class="edit-form-block">
						<label for="label">Права доступа</label>
							<select class="permission-box" id="permission">
							<option value="0" selected>Пользователь</option>
							<option value="1">Администратор</option>
							</select>
						</div>
				</div>
                </div>

					
						<div class="edit-form block">
							<button type="button" class="btn-cancel">Отменить</button>
							<button type="button" class="btn-success">Создать</button>
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
