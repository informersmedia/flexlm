$(document).ready(function() {
    $('.btn-auth').on('click', function(event) {
      event.preventDefault();
  
      // form elements
      const uemail = $('#uemail').val();
      const upwd = $('#upwd').val();
  
      // input validation
      if ($('#uemail').val() == "") {
        alert("Введите логин.");
        return;
      }

    // input validation
    if ($('#upwd').val() == "") {
        alert("Введите пароль.");
        return;
        }
    
      $.ajax({
        url: 'api/auth.php', // file path
        type: 'POST',
        data: {
            uemail: uemail,
            upwd: upwd
        },
        success: function(response) {
          // success response
          if (response.success == true) {
            alert('Вход в систему выполнен');
            const url = '/account'; 
            window.open(url, '_self'); 
          } else {
            alert('Не подходит логин или пароль');
          }

        },
        error: function(xhr, status, error) {
          // handle errors
          alert('Ошибка запроса: ' + error);
        }
      });
    });


    $('.btn-cancel').on('click', function(event) {
        event.preventDefault();
        const url = '/'; // actual path
        window.open(url, '_self'); 
    
      });

  });