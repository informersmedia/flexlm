<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />

		<title>License Management Server</title>
		<link rel="stylesheet" href="/css/flex.css" />
		<script src="/js/jquery.min.js"></script>
		<script src="/js/chart.js"></script>
		<script src="/js/chart.min.js"></script>
	</head>

	<body>
		<!-- main-->
		<main class="content-box-center">
		<?php
			include 'templates/navbar.php';
			include 'config/sql.php';

			$uuid = explode('/chart/', $uri)[1];

			$server = $connect->getLicensesName($uuid); // fetch server data 
			if ($server->num_rows > 0) { 
				$string = $server->fetch_assoc(); 
				} 
			?>
			<div class="content-box-data">

				<div class="description-box">
					<h1>Статистика использования</h1>
					<p>Статистика показывает использование за <code class="code-default">День</code><code class="code-default">Неделю</code><code class="code-default">Месяц</code><code class="code-default">Год</code><br>Данные обновляются каждые 15 минут.</p>
				</div>
	
				<div class="content-box-lmutil">
				<input type="hidden" id="string" class="edit-form-input" autocomplete="off" value="<?php echo $string['luid'] ?>" />
				<input type="hidden" id="licenses" class="edit-form-input" autocomplete="off" value="<?php echo $string['lname'] ?>" />

				<div class="chart-tab">
				<div class="chart-tab-item btn-day">День</div>
				<div class="chart-tab-item btn-week">Неделя</div>
				<div class="chart-tab-item btn-month">Месяц</div>
				<div class="chart-tab-item btn-year">Год</div>
				</div>


				<?php echo 'Лицензия: ' . $string['lname'] ?>
				<div id="chart_div" style="width: 900px; height: 500px;"></div>


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
