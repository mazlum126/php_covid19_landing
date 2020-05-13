<?php

	/* Database connection settings */
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'statsday_db';
	$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

	$countries_bar 			= '';
	$total_cases_bar 		= '';
	$total_deaths_bar 		= '';
	$total_recovered_bar 	= '';
	$active_cases_bar 		= '';

	//query to get data from the table
	$sql = "SELECT * FROM `countries` LIMIT 7";
  $result = mysqli_query($mysqli, $sql);
  $count = 0;
	while ($row = mysqli_fetch_array($result)) {
		$countries_bar 			= $countries_bar . '"'. $row['country_name_en'].'",';
		$total_cases_bar 		= $total_cases_bar . '"'. $row['total_cases'] .'",';
		$total_deaths_bar 		= $total_deaths_bar . '"'. $row['total_deaths'] .'",';
		$total_recovered_bar 	= $total_recovered_bar . '"'. $row['total_recovered'] .'",';
    $active_cases_bar 		= $active_cases_bar . '"'. $row['active_cases'] .'",';
    $country_flags[$count] =  $row['country_flags'];
    $count++;
  }

	$countries_bar 			= trim($countries_bar,",");
	$total_cases_bar 		= trim($total_cases_bar,",");
	$total_deaths_bar 		= trim($total_deaths_bar,",");
	$total_recovered_bar 	= trim($total_recovered_bar,",");
  $active_cases_bar 		= trim($active_cases_bar,","); 
  
  $sql = "SELECT sum(total_cases) as all_cases, sum(serious_critical) as all_serious, sum(total_deaths) as all_deaths, sum(total_recovered) as all_revovered FROM `countries`";
  $result = mysqli_query($mysqli, $sql);
  $row = mysqli_fetch_array($result);

  $all_cases = $row['all_cases'];
  $all_serious = $row['all_serious'];
  $all_serious = $row['all_deaths'];
  $all_revovered = $row['all_revovered'];

  $daily_cases = array();
  $daily_serious = array();
  $daily_deaths = array();
  $daily_recovered = array();

  $cases_sql = $con->prepare("SELECT sum(total_cases) as all_cases FROM `countries_backup` where DATEDIFF((select MAX(DATE(date_backup)) from countries_backup), DATE(date_backup)) < 10 group by DATE(date_backup)");
  $cases_sql->execute();
  $daily_cases = $cases_sql->fetchall();

  $serious_sql = $con->prepare("SELECT sum(serious_critical) as all_serious FROM `countries_backup` where DATEDIFF((select MAX(DATE(date_backup)) from countries_backup), DATE(date_backup)) < 10 group by DATE(date_backup)");
  $serious_sql->execute();
  $daily_serious = $serious_sql->fetchall();

  $deaths_sql = $con->prepare("SELECT sum(total_deaths) as all_deaths FROM `countries_backup` where DATEDIFF((select MAX(DATE(date_backup)) from countries_backup), DATE(date_backup)) < 10 group by DATE(date_backup)");
  $deaths_sql->execute();
  $daily_deaths = $deaths_sql->fetchall();

  $recovered_sql = $con->prepare("SELECT sum(total_recovered) as all_recovered FROM `countries_backup` where DATEDIFF((select MAX(DATE(date_backup)) from countries_backup), DATE(date_backup)) < 10 group by DATE(date_backup)");
  $recovered_sql->execute();
  $daily_recovered = $recovered_sql->fetchall();

  $date_sql = $con->prepare("SELECT DATE(date_backup) as date FROM `countries_backup` where DATEDIFF((select MAX(DATE(date_backup)) from countries_backup), DATE(date_backup)) < 10 group by DATE(date_backup)");
  $date_sql->execute();
  $lb_date = $date_sql->fetchall();

?>
<script>

var daily_cases = [];
var daily_serious = [];
var daily_deaths = [];
var daily_recovered = [];
var lb_date = [];

var daily_cases_view = [];
var daily_serious_view = [];
var daily_deaths_view = [];
var daily_recovered_view = [];
var lb_date_view = [];

daily_cases = <?php echo json_encode($daily_cases)?>;
daily_serious = <?php echo json_encode($daily_serious)?>;
daily_deaths = <?php echo json_encode($daily_deaths)?>;
daily_recovered = <?php echo json_encode($daily_recovered)?>;

lb_date = <?php echo json_encode($lb_date)?>;

country_flags = <?php echo json_encode($country_flags)?>;
console.log(country_flags);
var htm = "";
for(var i = 0; i < country_flags.length; i++){
    //  htm + = "<img name='image' class='img-responsive mt-0 img-line' alt='' src='img/flags/"+ country_flags[i] +".png'>"
}
$('#flags').html(htm);

for(var i = 0; i < daily_cases.length; i++) {
  daily_cases_view[i] = daily_cases[i]['all_cases'];
  daily_serious_view[i] = daily_serious[i]['all_serious'];
  daily_deaths_view[i] = daily_deaths[i]['all_deaths'];
  daily_recovered_view[i] = daily_recovered[i]['all_recovered'];
  lb_date_view[i] = lb_date[i]['date'];
}

	// Bar chart
  var options = {
          series: [{
          name: 'cases',
          data: [<?php echo ($total_cases_bar)?>]
        }, {
          name: 'deaths',
          data: [<?php echo ($total_deaths_bar)?>]
        }, {
          name: 'recovered',
          data: [<?php echo ($total_recovered_bar)?>]
        }, {
          name: 'active',
          data: [<?php echo $active_cases_bar?>]
        }],
          chart: {
          type: 'bar',
          height: 350,
          stacked: true,
        },
        plotOptions: {
          bar: {
            horizontal: true,
          },
        },
        stroke: {
          width: 1,
          colors: ['#fff']
        },
        title: {
          text: ''
        },
        xaxis: {
          categories: [<?php echo $countries_bar?>],
          labels: {
            show: false,
            rotate: -45,
            rotateAlways: true,
            minHeight: 0,
            rotate: -45,
            formatter: function (val) {
              return val
            }
          },
        },
        yaxis: {
          title: {
            text: undefined
          },
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val
            }
          }
        },
        fill: {
          opacity: 1
        },
        legend: {
          position: 'top',
          horizontalAlign: 'left',
          offsetX: 40
        }
        };

        var chart = new ApexCharts(document.querySelector("#bar-chart"), options);
        chart.render();

    // Area chart
    var options = {
      series: [{
      name: 'All cases',
      data: daily_cases_view
    }, {
      name: 'All serious',
      data: daily_serious_view
    }, {
      name: 'All deaths',
      data: daily_deaths_view
    }, {
      name: 'All recovered',
      data: daily_recovered_view
    }],
    chart: {
    height: 400,
    toolbar: {
      tools: {
        download: false
      },
      autoSelected: 'zoom' 
    },
    type: 'area'
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'straight'
    },
    xaxis: {
      type: 'date',
      categories: lb_date_view
    },
    legend: {
      position: 'top'
    },
    
    tooltip: {
      x: {
        format: 'dd/MM/yy'
      },
    },
    };

    var chart_grap = new ApexCharts(document.querySelector("#chart"), options);
    chart_grap.render();

    // Total sparklines 1
    var optionsSpark3 = {
      series: [{
      data: daily_cases_view
    }],
      chart: {
      type: 'area',
      height: 80,
      sparkline: {
        enabled: true
      },
    },
    stroke: {
      curve: 'straight'
    },
    fill: {
      opacity: 0.3
    },
    xaxis: {
      crosshairs: {
        width: 1
      },
    }
    // yaxis: {
    //   min: 0,
    //   max: 400000
    // }
    };

    var chartSpark3 = new ApexCharts(document.querySelector("#total1"), optionsSpark3);
    chartSpark3.render();

    // Total sparklines 2
    var optionsSpark3 = {
      series: [{
      data: daily_serious_view
    }],
      chart: {
      type: 'area',
      height: 80,
      sparkline: {
        enabled: true
      },
    },
    stroke: {
      curve: 'straight'
    },
    fill: {
      opacity: 0.3
    },
    xaxis: {
      crosshairs: {
        width: 1
      },
    }
    };

    var chartSpark3 = new ApexCharts(document.querySelector("#total2"), optionsSpark3);
    chartSpark3.render();

    // Total sparklines 3
    var optionsSpark3 = {
      series: [{
      data: daily_deaths_view
    }],
      chart: {
      type: 'area',
      height: 80,
      sparkline: {
        enabled: true
      },
    },
    stroke: {
      curve: 'straight'
    },
    fill: {
      opacity: 0.3
    },
    xaxis: {
      crosshairs: {
        width: 1
      },
    }
    };

    var chartSpark3 = new ApexCharts(document.querySelector("#total3"), optionsSpark3);
    chartSpark3.render();

    // Total sparklines 4
    var optionsSpark3 = {
      series: [{
      data: daily_recovered_view
    }],
      chart: {
      type: 'area',
      height: 80,
      sparkline: {
        enabled: true
      },
    },
    stroke: {
      curve: 'straight'
    },
    fill: {
      opacity: 0.3
    },
    xaxis: {
      crosshairs: {
        width: 1
      },
    }
    };

    var chartSpark3 = new ApexCharts(document.querySelector("#total4"), optionsSpark3);
    chartSpark3.render();

</script>