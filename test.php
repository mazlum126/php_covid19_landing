<!DOCTYPE html>
<html>
<head>
	<title></title>
	
</head>
<body>
	<div id="spark1"></div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
	     var options = {
          series: [{
          data: [31, 40, 28, 51, 42, 109, 100]
        }],
          chart: {
          type: 'area',
          height: 160,
          sparkline: {
            enabled: true
          },
        },
        stroke: {
          curve: 'straight'
        },
        fill: {
          opacity: 0.3,
        },
        yaxis: {
          min: 0
        },
        colors: ['#DCE6EC'],
        title: {
          text: '$424,652',
          offsetX: 0,
          style: {
            fontSize: '24px',
          }
        },
        subtitle: {
          text: 'Sales',
          offsetX: 0,
          style: {
            fontSize: '14px',
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#spark1"), options);
        chart.render();
</script>
</body>
</html>
