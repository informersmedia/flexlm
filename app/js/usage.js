$(document).ready(function() {

    const uuid = $('#uuid').val();
    const udomain = $('#udomain').val();

    const outputDiv = $('#output');
    const loaderHTML = '<div class="loader">Получаем данные...</div>';
    const rowsPerPage = 20;
    let allData = [];
    let initialRendered = false;

    if (!uuid) {
        alert('Please enter a UUID.');
        return;
    }

    outputDiv.html(loaderHTML);

    function loadData() {
        $.ajax({
            url: '../api/usage.php',
            type: 'POST',
            dataType: 'json',
            data: { uuid: uuid },
            success: function(data) {
                outputDiv.empty();
                if (data && Array.isArray(data) && data.length > 0) {
                    allData = data;
                     renderInitialTable();

                } else if (data && data.error) {
                     outputDiv.html(`<p class="error">Error: ${data.error}</p>`);
                } else {
                    outputDiv.html('<p>No data found for this UUID.</p>');
                }
            },
             error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                 outputDiv.empty(); // Remove loader on error
                outputDiv.html('<p class="error">Error fetching data.</p>');
            }
        });
    }

    function renderInitialTable() {
        const initialData = allData.slice(0, rowsPerPage);
        let tableHTML = generateTableHTML(initialData);

        outputDiv.html(tableHTML);
        const remainingRows = allData.length - rowsPerPage;
         if (remainingRows > 0) {
                const showMoreLink = $(`<div class="more-load"><a class="btn-more" href="#">Показать все</a></div>`);
                showMoreLink.find('a').click(function(e) {
                    e.preventDefault();
                    renderFullTable();
                    $(this).parent().remove();
                });
                outputDiv.append(showMoreLink);
            }
          initialRendered = true;
        }

        function renderFullTable() {
            let tableHTML = generateTableHTML(allData);
             outputDiv.html(tableHTML);
        }


    function generateTableHTML(data) {
        let tableHTML = `<table class='table-flex'>
                    <thead>
                        <tr>
                            <th>Лицензия</th>
                            <th>Общее количество</th>
                            <th>Подробности</th>
                            <th>Статистика</th>
                            <th>Использование</th>
                        </tr>
                    </thead>
                    <tbody>`;


                    data.forEach(item => {
                        let usersHTML = '';
                        let reservedHTML = '';
                        let historyHTML = '';

                        let host = '';


                        try {
                            // 1. Парсим строку JSON в JavaScript-объект (массив объектов)
                            const usersArray = item.users;
                            const reservedArray = item.reservations;
                            const historyArray = item.users;
                    
                            // 2. Формируем HTML для отображения данных
                            if (usersArray && usersArray.length > 0) {
                                usersHTML = '<ul class="user-start">'; // Начнем список, если есть пользователи
                                usersArray.forEach(user => {
                                    let firstDotIndex = user.host.indexOf(".");
                                    let domain = user.host.substring(firstDotIndex + 1);
                                    const newUserStart = user.start.replace(/,$/, "");
                                    if (udomain === domain) {
                                        host = domain;
                                        usersHTML += `<li>Пользователь: ${user.user}</li> <li>Домен: ${user.host}</li> <li>Старт: ${formatUserDate(newUserStart) }</li></li><li>` 
                                    } else if (udomain === "admin.ru") {
                                        host = "admin.ru";
                                        usersHTML += `<li>Пользователь: ${user.user}</li> <li>Домен: ${user.host}</li> <li>Старт: ${formatUserDate(newUserStart) }</li></li><li>` 
                                    }
                                });
                                usersHTML += '</ul>';
                            } else {
                                usersHTML = '';
                            }

                            // 2. Формируем HTML для отображения данных
                            if (reservedArray && reservedArray.length > 0) {
                                reservedHTML = '<ul class="user-reserved">'; // Начнем список, если есть пользователи
                                reservedArray.forEach(reserved => {
    
                                    reservedHTML += `<li>Проект: ${reserved.project}</li> <li>В резерве: ${reserved.count}</li>` 
                                });
                                reservedHTML += '</ul>';
                            } else {
                                reservedHTML = '';
                            }


                            // 2. Формируем HTML для отображения истории запуска
                            if (historyArray && historyArray.length > 0) {
                                historyHTML = '<ul class="user-history">';
                                historyArray.forEach(history => {
                                    const newHistory = history.start.replace(/,$/, "");
                                    historyHTML += `<li>${calculateTimePassed(newHistory)}</li><li></li><li></li><li></li>` 
                                });
                                historyHTML += '</ul>';
                            } else {
                                historyHTML = '';
                            }

                        } catch (error) {
                          usersHTML = 'Ошибка обработки данных'; // Если JSON невалидный
                          reservedHTML = 'Ошибка обработки данных'; // Если JSON невалидный
                          historyHTML = 'Ошибка обработки данных'; // Если JSON невалидный
                          console.error("Error parsing or rendering users:", error, item.users);
                          console.error("Error parsing or rendering users:", error, item.reservations);
                        }
                    
                        if (udomain === host) {
                            tableHTML += `<tr>
                                <td class="icon-server"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M20 22H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1m-1-2V4H5v16zM8 9h8v2H8zm0 4h8v2H8z"/></svg> ${item.name}</td>
                                <td>${item.total}</td>
                                <td>Всего ${item.total}, используется ${item.inuse}, в резерве ${item.sum}<br>${usersHTML}${reservedHTML}</td>
                                <td><a href="/chart/${item.uid}" class="td-link">История</a></td>
                                <td>-- <br>${historyHTML}</td>
                            </tr>`;
                        } else if (udomain === "admin.ru") {
                            tableHTML += `<tr>
                            <td class="icon-server"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M20 22H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1m-1-2V4H5v16zM8 9h8v2H8zm0 4h8v2H8z"/></svg> ${item.name}</td>
                            <td>${item.total}</td>
                            <td>Всего ${item.total}, используется ${item.inuse}, в резерве ${item.sum}<br>${usersHTML}${reservedHTML}</td>
                            <td><a href="/chart/${item.uid}" class="td-link">История</a></td>
                            <td>-- <br>${historyHTML}</td>
                        </tr>`;
                        }
                    });

                    tableHTML += "</tbody></table>";


                    function calculateTimePassed(dateString) {
                        if (!dateString) {
                          console.error("Некорректная строка даты: строка пуста");
                          return "--";
                        }
                        const formattedDateString = formatUserDate(dateString);
                        const parts = formattedDateString.match(/(\d{2})-(\d{2})-(\d{4}) (\d{2}):(\d{2})/);
                          
                        if (!parts) {
                          console.error("Некорректный формат строки даты:", formattedDateString);
                          return "--";
                        }
                        
                        const day = parseInt(parts[1], 10);
                        const month = parseInt(parts[2], 10) - 1;
                        const year = parseInt(parts[3], 10);
                        const hours = parseInt(parts[4], 10);
                        const minutes = parseInt(parts[5], 10);
                        const startDate = new Date(year, month, day, hours, minutes);
                      
                        if (isNaN(startDate)) {
                            console.error("Не удалось создать корректный объект Date из строки:", formattedDateString);
                            return "--";
                        }
                      
                        const now = new Date();
                        const diffInMilliseconds = now - startDate;
                        return formatTimeDiff(diffInMilliseconds);
                      }
                      
                      function formatTimeDiff(diff) {
                        const seconds = Math.floor(diff / 1000);
                        const minutes = Math.floor(seconds / 60);
                        const hours = Math.floor(minutes / 60);
                        const days = Math.floor(hours / 24);
                      
                        if (days > 0) {
                          return `${days} дн ${hours % 24} ч ${minutes % 60} мин`;
                        } else if (hours > 0) {
                          return `${hours} ч ${minutes % 60} мин`;
                        } else if (minutes > 0) {
                          return `${minutes} мин ${seconds % 60} сек`;
                        } else {
                          return `${seconds} сек`;
                        }
                      }
                      
                      function formatUserDate(dateString) {
                          const currentDate = new Date();
                          const currentYear = currentDate.getFullYear();
                          const formattedDateString = dateString.replace(/(\d{2})\/(\d{2})\s(\d{1,2}):(\d{2})/, (match, day, month, hours, minutes) => {
                              const formattedHours = hours.padStart(2, '0');
                              return `${month}-${day}-${currentYear} ${formattedHours}:${minutes}`;
                          });

                          const dateRegex = /^(\d{2})-(\d{2})-(\d{4}) (\d{2}):(\d{2})$/;
                          if (!dateRegex.test(formattedDateString)) {
                              console.error("Некорректный формат даты после форматирования:", formattedDateString);
                              return dateString;
                          }
                          return formattedDateString;
                      }
                      

                

        return tableHTML;
    }

    loadData();
});