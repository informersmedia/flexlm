<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />

    <title>License Management Server</title>
    <link rel="stylesheet" href="/css/flex.css" />
    <script src="/js/jquery.min.js"></script>
    <script src="/js/listing.js"></script>

  </head>

  <body>

    <!-- main-->
    <main class="content-box-center">

    <?php
			include 'templates/navbar.php';
			include 'config/sql.php';

			$uuid = explode('/listing/', $uri)[1];

			$server = $connect->getServer($uuid); // fetch server data 
			if ($server->num_rows > 0) { 
				$string = $server->fetch_assoc(); 
				} 
			?>
    <div class="content-box-data">

    <div class="description-box">
					<h1>Лицензии отдельного сервера</h1>
					<p>В этом списке находятся все <code class="code-default">Лицензии</code> доступные на данном конкретном сервере.</p>
				</div>
        <?php 
        echo '<h3 class="header-server">Сервер: ' . $string['sname'] . '</h3>';
        ?>
    <div class="content-box-lmutil">
    <input type="hidden" id="uuid" class="edit-form-input" autocomplete="off" value="<?php echo $string['uuid'] ?>" />

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