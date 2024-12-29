<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>License Management user</title>
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
					<h1>Профиль пользователя</h1>
					<p>Личные данные пользователя системы. <br> Информация о пользователе  <code class="code-default">Электронная почта</code> <code class="code-default">Идентификатор</code> и другие данные.</p>
				</div>
				
				<div class="content-box-lmutil">
				<div class="content-box-user">
				<?php
					include 'config/sql.php';

					$user = $connect->getUser($_COOKIE['uuid']); // fetch user data 
					if ($user->num_rows > 0) { 
						$string = $user->fetch_assoc(); 
						} 
						$data = [
							'Имя пользователя' => $string['usr'],
							'Идентификатор' => $string['uuid'],
							'Права доступа' => ($string['permission'] == 0) ? 'Пользователь' : 'Администратор', //Conditional rendering
							'Проект' => $string['uproject'],
							'Домен' => $string['udomain']
						  ];
						  
						  echo '<table class="table-flex">';
						  foreach ($data as $label => $value) {
							echo '<tr><th>' . htmlspecialchars($label) . '</th><td>' . htmlspecialchars($value) . '</td></tr>';
						  }
						  echo '<tr><th>Выход из профиля</th><td><a href="/exit" class="td-link">Выход</a></td></tr>';
						  echo '</table>';
					?>
		
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
