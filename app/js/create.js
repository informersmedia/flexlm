$(document).ready(function() {

  // User creation (new code)
  $('.btn-success').on('click', function(event) {
    event.preventDefault();
    const permission = $('#permission').val();
    const usr = $('#usr').val();
    const uemail = $('#uemail').val();
    const upwd = $('#upwd').val();
    const uproject = $('#uproject').val();
    const udomain = $('#udomain').val();

    // Basic Input Validation (add more robust checks as needed)
    if (usr === "" || uemail === "" || upwd === "") {
      alert("Пожалуйста, заполните все поля.");
      return;
    }


    $.ajax({
      url: 'api/create.php', //  New PHP file for user creation
      type: 'POST',
      data: { permission: permission, usr: usr, uemail: uemail, upwd: upwd, uproject: uproject, udomain: udomain },
      success: function(response) {
        alert("Пользователь успешно добавлен.");
        // Optionally, reload the page or update the UI
        const url = '/users'; 
        window.open(url, '_self'); 
      },
      error: function(xhr, status, error) {
        alert('Ошибка отправки запроса: ' + error);
        console.error("AJAX error:", xhr, status, error);
      }
    });
  });

  $('.btn-cancel').on('click', function(event) {
      event.preventDefault();
      const url = '/users'; 
      window.open(url, '_self'); 
    });
});