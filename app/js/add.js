$(document).ready(function() {
    $('.btn-success').on('click', function(event) {
      event.preventDefault();
  
      // form elements
      const sname = $('#name').val();
      const slabel = $('#label').val();
      const svendor = $('#vendor').val();
      const sactive = $('#is_active').is(':checked') ? 1 : 0; // checkbox is checked
  
      // input validation
      if ($('#name').val() == "") {
        alert("Введите имя сервера.");
        return;
      }
      
      $.ajax({
        url: 'api/add.php', // file path
        type: 'POST',
        data: {
            sname: sname,
            slabel: slabel,
            svendor: svendor,
            sactive: sactive
        },
        dataType: 'json',
        success: function(response) {
          console.log(response);
          // success response
          if (response.status === "error") {
            alert("Сервер уже добавлен.");
          } else {
            alert("Сервер успешно добавлен.");
          window.open('/admin', '_self'); 
          }
       
   
        },
        error: function(xhr, status, error) {
          // Handle errors
          alert('Ошибка отправки запроса: ' + error);
        }
      });
    });


    $('.btn-cancel').on('click', function(event) {
        event.preventDefault();
        const url = '/admin'; // actual path
        window.open(url, '_self'); 
    
      });

  });