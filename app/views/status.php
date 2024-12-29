<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />

    <title>License Management Server</title>
    <link rel="stylesheet" href="css/flex.css" />
    <script src="js/jquery.min.js"></script>
    <script src="js/status.js"></script>

  </head>

  <body>

    <!-- main-->
    <main class="content-box-center">

    <?php
        include 'templates/navbar.php';

    ?>
    <div class="content-box-data">

    <div class="description-box">
  <h1>Состояние всех серверов</h1>
    <p>Чтобы получить информацию о текущем использовании для отдельного сервера, нажмите на ссылку <code class="code-default">Сведения</code> рядом с сервером. <br> Ссылка <code class="code-default">Просмотр</code> предоставит информацию о доступных функциях сервера.</p>
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