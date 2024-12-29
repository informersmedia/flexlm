$(document).ready(function() {

  // up server
  $('.btn-success').on('click', function(event) {
    event.preventDefault();

    // form elements
    const uuid = $('#uuid').val();
    const sname = $('#sname').val();
    const slabel = $('#slabel').val();
    const svendor = $('#svendor').val();
    const sactive = $('#sactive').is(':checked') ? 1 : 0; // checkbox is checked

    // input validation 
    if ($('#sname').val() == "") {
      alert("Введите имя сервера.");
      return;
    }

    // input validation 
    if ($('#slabel').val() == "") {
      alert("Введите метку сервера.");
      return;
    }
    
    $.ajax({
      url: '../api/edit.php', // file for user creation
      type: 'POST',
      data: { uuid: uuid, sname: sname, slabel: slabel, svendor: svendor, sactive: sactive},
      success: function(response) {
        alert("Данные обновлены.");
        const url = '/admin'; 
        window.open(url, '_self'); 
      },
      error: function(xhr, status, error) {
        alert('Ошибка запроса: ' + error);
        console.error("error:", xhr, status, error);
      }
    });
  });

  $('.btn-cancel').on('click', function(event) {
      event.preventDefault();
      const url = '/admin'; // replace file path
      window.open(url, '_self'); 
  
    });

  $('.btn-remove').on('click', function(event) {
    event.preventDefault();

    // form elements
    const uuid = $('#uuid').val();

    if (confirm("Вы уверены, что хотите удалить сервер?")) { // сonfirmation
        $.ajax({
            url: '../api/remove.php',
            type: 'POST',
            data: { uuid: uuid },
            success: function(response) {
                alert("Сервер удален.");
                const url = '/admin';
                window.open(url, '_self');
            },
            error: function(xhr, status, error) {
                alert('Ошибка запроса: ' + error);
                console.error("error:", xhr, status, error);
            }
        });
    }
  });

});