$(document).ready(function() {
    $.ajax({
        url: 'api/status.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (Array.isArray(data)) { // Check if data is an array
                // JSON Array - Display in a table
                let tableHTML = `<table class='table-flex'>
                                    <thead>
                                        <tr>
                                            <th>Метка</th>
                                            <th>Сервер</th>
                                            <th>Статус</th>
                                            <th>Использование</th>
                                            <th>Лицензии</th>
                                            <th>Статистика</th>
                                            <th>Версия сервера</th>
                                            <th>Последнее обновление</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                data.forEach(server => {
                    var srv = null;

                    if (server.status === "Недоступен") {
                        srv = '<td class="td-off">' + server.status + '</td>';
                    } else {
                        srv = '<td class="td-on">' + server.status + '</td>';
                    }



                    tableHTML += `<tr>
                                    <td class="icon-server"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M5 11h14V5H5zm16-7v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1m-2 9H5v6h14zM7 15h3v2H7zm0-8h3v2H7z"/></svg> ${server.description}</td>
                                    <td>${server.server}</td>
                                    ${srv}
                                    <td><a href="/usage/${server.uuid}" class="td-link">${server.current}</a></td>
                                    <td><a href="/listing/${server.uuid}" class="td-link">${server.available}</a></td>
                                    <td class="icon-server"><a href="/statistics/${server.uuid}" class="td-link"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M9 5v10H6V5zM5 3a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm10 6v6h3V9zm-2-1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1zm8 11H3v2h18z"/></svg></a></td>
                                    <td>${server.version}</td>
                                    <td>${server.update}</td>
                                </tr>`;
                });

                tableHTML += `</tbody></table>`;
                $('#output').html(tableHTML);
            } else if (typeof data === 'object') { //Handle single object (for backward compatibility)
                // Single JSON object (handle as before)
                let tableHTML = `<table class='table-flex'>
                                    <tbody>
                                        <tr>
                                            <th>Метка</th>
                                            <th>Сервер</th>
                                            <th>Статус</th>
                                            <th>Использование</th>
                                            <th>Лицензии</th>
                                            <th>Статистика</th>
                                            <th>Версия сервера</th>
                                            <th>Последнее обновление</th>
                                        </tr>
                                        <tr>
                                            <td class="icon-server"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M5 11h14V5H5zm16-7v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1m-2 9H5v6h14zM7 15h3v2H7zm0-8h3v2H7z"/></svg> ${data.description}</td>
                                            <td>${data.server}</td>
                                            ${srv}
                                            <td><a href="/usage/${server.uuid}" class="td-link">${data.current}</a></td>
                                            <td><a href="/listing/${server.uuid}" class="td-link">${data.available}</a></td>
                                            <td class="icon-server"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M9 5v10H6V5zM5 3a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm10 6v6h3V9zm-2-1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1zm8 11H3v2h18z"/></svg></a></td>
                                            <td>${data.version}</td>
                                            <td>${data.update}</td>
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
});