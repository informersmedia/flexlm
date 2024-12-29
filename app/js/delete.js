$(document).ready(function() {

  $('.btn-delete').on('click', function(event) {
    event.preventDefault();

    // form elements
    const uuid = $('#uuid').val();

    if (confirm("Вы уверены, что хотите удалить пользователя?")) { // сonfirmation
        $.ajax({
            url: '/api/delete.php',
            type: 'POST',
            data: { uuid: uuid },
            success: function(response) {
                alert("Пользователь удален.");
                const url = '/users';
                window.open(url, '_self');
            },
            error: function(xhr, status, error) {
                alert('Ошибка запроса: ' + error);
                console.error("error:", xhr, status, error);
            }
        });
    }
    });

    $('.btn-cancel').on('click', function(event) {
        event.preventDefault();
        const url = '/users'; // replace file path
        window.open(url, '_self'); 
    
      });

});