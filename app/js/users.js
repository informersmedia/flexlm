$(document).ready(function() {
    $.ajax({
        url: 'api/users.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (Array.isArray(data)) { // Check if data is an array
                // JSON Array - Display in a table

                let tableHTML = `<table class='table-flex'>
                                    <thead>
                                        <tr>
                                            <th>Имя пользователя</th>
                                            <th>Электронная почта</th>
                                            <th>Права доступа</th>
                                            <th>Проект</th>
                                            <th>Домен</th>
                                            <th>Операция</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
  
                data.forEach(users => {
                    const permissionText = users.permission === "0" ? "Пользователь" : "Администратор";

                    tableHTML += `<tr>
                                    <td class="icon-server"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M20 22h-2v-2a3 3 0 0 0-3-3H9a3 3 0 0 0-3 3v2H4v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5zm-8-9a6 6 0 1 1 0-12a6 6 0 0 1 0 12m0-2a4 4 0 1 0 0-8a4 4 0 0 0 0 8"/></svg>${users.usr}</td>
                                    <td>${users.uemail}</td>
                                    <td>${permissionText}</td>
                                    <td>${users.uproject}</td>
                                    <td>${users.udomain}</td>
                                    <td><a href="delete/${users.uuid}" class="td-link">Удалить</a></td>
                                </tr>`;
                });
  
                tableHTML += `</tbody></table>`;
                $('#output').html(tableHTML);
            } else if (typeof data === 'object') { //Handle single object (for backward compatibility)
                // Single JSON object (handle as before)
                let tableHTML = `<table class='table-flex'>
                                    <tbody>
                                        <tr>
                                         <th>Имя пользователя</th>
                                            <th>Электронная почта</th>
                                            <th>Права доступа</th>
                                            <th>Проект</th>
                                            <th>Домен</th>
                                            <th>Операция</th>
                                        </tr>
                                        <tr>
                                            <td class="icon-server"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M20 22h-2v-2a3 3 0 0 0-3-3H9a3 3 0 0 0-3 3v2H4v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5zm-8-9a6 6 0 1 1 0-12a6 6 0 0 1 0 12m0-2a4 4 0 1 0 0-8a4 4 0 0 0 0 8"/></svg>${users.usr}</td>
                                            <td>${users.uemail}</td>
                                            <td>${permissionText}</td>
                                            <td>${users.uproject}</td>
                                            <td>${users.udomain}</td>
                                           <td><a href="delete/${users.uuid}" class="td-link">Удалить</a></td>
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

    $('.btn-user').on('click', function(event) {
        event.preventDefault();
        const url = '/create'; // Replace 'server/add.php' with the actual path
        window.open(url, '_self'); 
    
      });
  
  });