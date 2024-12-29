<div class="item-menu-box">
<div class="item-menu-box-center">
<div class="item-menu-wrapper">
      <div class="item-menu"><a class="flex-icon" href="/status">Менеджер Flex LM</a></div>
      <div class="item-menu"><a class="flex-menu" href="/status">Статус</a></div>
      <?php
        if ($_COOKIE['permission'] == 1) {
          echo '<div class="item-menu"><a class="flex-menu" href="/users">Пользователи</a></div>';
          echo '<div class="item-menu"><a class="flex-menu" href="/admin">Серверы</a></div>';
        } 
		  ?>
    </div>
    <div class="account-wrapper">
    <div class="item-menu">
      <a class="flex-menu" href="/auth">Профиль</a>
    </div>
    </div>
    </div>
</div>