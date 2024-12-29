$(document).ready(function() {

    const uuid = $('#uuid').val();
    const outputDiv = $('#output'); // Store the output div element
    const loaderHTML = '<div class="loader">Получаем данные...</div>';
    const initialRows = 20;  // Number of rows to show initially
    let allData = [];
    let initialRendered = false;

    if (!uuid) {
        alert('Please enter a UUID.');
        return;
    }

    outputDiv.html(loaderHTML); // Show loader

     function loadData() {
        $.ajax({
            url: '../api/listing.php',
            type: 'POST',
            dataType: 'json',
            data: { uuid: uuid },
             success: function(data) {
                outputDiv.empty(); // Remove loader
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
        const initialData = allData.slice(0, initialRows);
        let tableHTML = generateTableHTML(initialData);

        outputDiv.html(tableHTML);
        const remainingRows = allData.length - initialRows;
        if(remainingRows > 0) {
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
                            <th>Вендор</th>
                            <th>Общее количество</th>
                            <th>Подробности</th>
                        </tr>
                    </thead>
                    <tbody>`;
        data.forEach(item => {
           tableHTML += `<tr>
                        <td class="icon-server"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M20 22H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1m-1-2V4H5v16zM8 9h8v2H8zm0 4h8v2H8z"/></svg> ${item.name}</td>
                        <td>${item.vendor}</td>
                        <td>${item.total}</td>
                        <td>${item.total} являются постоянными</td>
                    </tr>`;
        });
          tableHTML += "</tbody></table>";
          return tableHTML;
    }

    loadData();
});