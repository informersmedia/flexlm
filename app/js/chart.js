$(document).ready(function() {
  
  const licenses = $('#licenses').val();
  const chart = $('#chart_div');
  const string = $('#string').val();

  google.charts.load('current', {'packages':['corechart']});

  $.ajax({
    url: '../api/chart.php',
    type: 'POST',
    dataType: 'json',
    data: {age: "day", string: string, licenses: licenses},
    success: function(json) {
      google.charts.setOnLoadCallback(() => drawChart(json, string, chart));
    },
    error: function(xhr, text, thrown) {
      console.error('error', text, thrown);
      console.log(xhr);
    }
  });

  $('.btn-day').on('click', function() {
    fetchData("day");
  });

  $('.btn-week').on('click', function() {
    fetchData("week");
  });

  $('.btn-month').on('click', function() {
    fetchData("month");
  });

  $('.btn-year').on('click', function() {
    fetchData("year");
  });

  function fetchData(period) {
    $.ajax({
      url: '../api/chart.php',
      type: 'POST',
      dataType: 'json',
      data: {age: period, string: string, licenses: licenses},
      success: function(json) {
        google.charts.setOnLoadCallback(() => drawChart(json, string, chart));
      },
      error: function(xhr, text, thrown) {
        console.error('error', text, thrown);
        console.log(xhr);
      }
    });
  }

  function drawChart(json, string, chart) {
    const data = new google.visualization.DataTable();

    json.cols.forEach(col => {
      data.addColumn(col.type, col.label);
    });

    json.rows.forEach(row => {
      const parts = row.split(',');
      const time = parts[0];
      const count = parseFloat(parts[1]);
      data.addRow([time, count]);
    });

    var options = {
      vAxis: {minValue: 0},
      chartArea:{
        left: 120,
        bottom: 100
      }, 
      'legend.position': "right", 
      width: 1000, 
      height: 400,
      curveType: 'none',
      pointSize: 0 
    };

    var lineChart = new google.visualization.LineChart(chart[0]); 
    lineChart.draw(data, options);
  }
});