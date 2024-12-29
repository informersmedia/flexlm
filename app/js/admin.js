$(document).ready(function() {
  $.ajax({
      url: 'api/admin.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
          if (Array.isArray(data)) { // Check if data is an array
              // JSON Array - Display in a table
              let tableHTML = `<table class='table-flex'>
                                  <thead>
                                      <tr>
                                          <th>Сервер</th>
                                          <th>Метка</th>
                                          <th>Активность</th>
                                          <th>Статус</th>
                                          <th>Версия сервера</th>
                                          <th>Последнее обновление</th>
                                          <th>Операция</th>
                                      </tr>
                                  </thead>
                                  <tbody>`;

              data.forEach(server => {
                var srv = null;

                if (server.sstat === "Недоступен") {
                    srv = '<td class="td-off">' + server.sstat + '</td>';
                } else {
                    srv = '<td class="td-on">' + server.sstat + '</td>';
                }

                  tableHTML += `<tr>
                                  <td class="icon-server"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M5 11h14V5H5zm16-7v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1m-2 9H5v6h14zM7 15h3v2H7zm0-8h3v2H7z"/></svg> ${server.sname}</td>
                                  <td>${server.slabel}</td>
                                  <td>${server.sactive}</td>
                                  ${srv}
                                  <td>${server.sversion}</td>
                                  <td>${server.sup}</td>
                                <td><a href="/edit/${server.uuid}" class="td-link">Редактировать</a></td>
                              </tr>`;
              });

              tableHTML += `</tbody></table>`;
              $('#output').html(tableHTML);
          } else if (typeof data === 'object') { //Handle single object (for backward compatibility)
              // Single JSON object (handle as before)
              let tableHTML = `<table class='table-flex'>
                                  <tbody>
                                      <tr>
                                          <th>Сервер</th>
                                          <th>Метка</th>
                                          <th>Активность</th>
                                          <th>Статус</th>
                                          <th>Версия сервера</th>
                                          <th>Последнее обновление</th>
                                          <th>Операция</th>
                                      </tr>
                                      <tr>
                                  <td class="icon-server"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M5 11h14V5H5zm16-7v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1m-2 9H5v6h14zM7 15h3v2H7zm0-8h3v2H7z"/></svg> ${server.sname}</td>
                                  <td>${server.slabel}</td>
                                  <td>${server.sactive}</td>
                                  ${srv}
                                  <td>${server.sversion}</td>
                                  <td>${server.sup}</td>
                                <td><a href="/edit/${server.uuid}" class="td-link">Редактировать</a></td>
                                      </tr>
                                  </tbody>
                              </table>`;
              $('#output').html(tableHTML);
          } else if (data.includes("\n")) {
              // Plain text or CSV data handling (remains the same)
              // ... (your existing CSV handling code) ...
          } else {
              // Handle unexpected data
              $('#output').html('<p>Unexpected data received.</p>');
          }
      },
      error: function(xhr, status, error) {
          console.error("AJAX Error:", status, error);
          $('#output').html('<p>Error fetching data.</p>');
      }
  });


  $('.btn-server').on('click', function(event) {
    event.preventDefault();
    const url = '/add'; // Replace 'server/add.php' with the actual path
    window.open(url, '_self'); 

  });




});