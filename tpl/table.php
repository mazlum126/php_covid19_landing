<?php
    $date = !isset($_REQUEST['date']);
    $table_sql = "";
    $sql = "";
    if ($date) {
        $sql = "SELECT * FROM `countries_backup` where DATE(date_backup) like '".$date."'";
        $table_sql = $con->prepare($sql);
    } else {
        $table_sql = $con->prepare("SELECT * FROM `countries_backup` where DATE(date_backup) like (select MAX(DATE(date_backup)) from countries_backup)");
    }
    $table_sql = $con->prepare("SELECT * FROM `countries`");
    $table_sql->execute();
    $data_table_tmp = $table_sql->fetchall();
?>

<script>

var continent_cons = {'africa' : 1,'europe' : 2,'asia' : 3,'nor_amireca' : 4,'sth_amirica' : 5,'australia' : 6,'aciana' : 7,'all' : 8, 'arabic' : 1}
        
var data_table_temp = [];
var data_table = [];
var data_countries = [];
data_table_tmp = <?php echo json_encode($data_table_tmp) ?>;


function insert_data(){
    for(var i = 0; i < data_table_tmp.length; i++) {
        data_table[i] = [];
        
        data_countries[i] = data_table_tmp[i]['country_name_en']; 

        data_table[i][0] = data_table_tmp[i]['country_flags'];
        data_table[i][1] = data_table_tmp[i]['country_name_en'];
        data_table[i][2] = data_table_tmp[i]['total_cases'];
        data_table[i][3] = data_table_tmp[i]['new_cases'];
        data_table[i][4] = data_table_tmp[i]['total_deaths'];
        data_table[i][5] = data_table_tmp[i]['new_deaths'];
        data_table[i][6] = data_table_tmp[i]['total_recovered'];
        data_table[i][7] = data_table_tmp[i]['active_cases'];
        data_table[i][8] = data_table_tmp[i]['serious_critical'];
        data_table[i][9] = data_table_tmp[i]['tot_cases_1m_pop'];
        data_table[i][10] = data_table_tmp[i]['deaths_1m_pop'];
        data_table[i][11] = data_table_tmp[i]['1st_case'];
        data_table[i][12] = data_table_tmp[i]['continent'];
        data_table[i][13] = data_table_tmp[i]['all_union'];
    }
}

console.log(data_countries);

function get_str_today(){
    var today = new Date();
    var date_tmp = new Date(today);
    var year = date_tmp.getYear() + 1900;
    var date = date_tmp.getDate();
    var month = date_tmp.getMonth() + 1;
    if(month < 10) {
        month = "0" + month;
    }
    if(date < 10) {
        date = "0" + date; 
    }
    var str_dt_today = year+"-"+month+"-"+date;
    return str_dt_today;
}

function get_str_yesterday(){
    var today = new Date();
    var date_tmp = new Date(today);
    date_tmp.setDate(today.getDate() - 1);
    year = date_tmp.getYear() + 1900;
    date = date_tmp.getDate();
    month = date_tmp.getMonth() + 1;
    if(month < 10) {
        month = "0" + month;
    }
    if(date < 10) {
        date = "0" + date; 
    }
    var str_dt_yesterday = year+"-"+month+"-"+date;
    return str_dt_yesterday;
}

sort_item = '';
sort_dir = 1;
filtered_data = [];

$('th.sort').click(function () {
    sort_item = $(this).attr('id');
    sort_dir *= -1;
    i_class = ($(this).children("i").attr('class') == 'fa fa-caret-down') ? 'fa fa-caret-up' : 'fa fa-caret-down';
    $(this).html(sort_item.charAt(0).toUpperCase() + sort_item.slice(1) + '<i class="' + i_class + '"></i>');
    tblDraw();
})

function tblDraw(){
    filtered_data = [];
    for (var i = 0; i < data_table.length; i++) {
            var item = data_table[i];
             filtered_data[i] = item;
    }
    if (sort_item) {
        filtered_data = data_sort(filtered_data, sort_item, sort_dir)
    }
    var html = '';
    var sum_new_cases = 0;
    var sum_new_deaths = 0;
    var sum_active_cases = 0;
    var sum_serious = 0;

    for (var i = 0; i < filtered_data.length; i++) {
        var item = filtered_data[i];
        if(item[11] == null){
            item[11] = "";
        }
        sum_new_cases +=  parseInt(item[3]);
        sum_new_deaths += parseInt(item[5]);
        sum_active_cases += parseInt(item[7]);
        sum_serious +=  parseInt(item[8]);
        
        html += "<tr>";
            html += "<td class='first_col'>" +
                        "<img name='image' class='img-responsive mt-0 img-line' alt='' src='img/flags/"+ item[0] +".png'>" +
                    "</td>";
            html += "<td class='first_col'>" +
                        item[1] +
                    "</td>";
            html += "<td>" +
                        "<div class='orb_value'>" + item[2] + "</div>" +
                    "</td>";
            html += "<td style='color: #FFEB3B;'>" +
                        "<div class='orb_value'><div class='flash-blink'>" + item[3] + "</div></div>" +
                    "</td>";
            html += "<td style='color: #F44336;'>" +
                        "<div class='orb_value'>" + item[4] + "</div>" +
                    "</td>";
            html += "<td style='color: #FF9800;'>" +
                        "<div class='orb_value'>" + item[5] + "</div>" +
                    "</td>";
            html += "<td style='color: #4CAF50;'>" +
                        "<div class='orb_value'>" + item[6] + "</div>" +
                    "</td>";
			html += "<td style='color: #673AB7;'>" +
                        "<div class='orb_value count'>" + item[7] + "</div>" +
                    "</td>";
			html += "<td>" +
                        "<div class='orb_value'>" + item[8] + "</div>" +
                    "</td>";
            html += "<td>" +
                        "<div class='orb_value'>" + item[9] + "</div>" +
                    "</td>";
            html += "<td>" +
                        "<div class='orb_value'>" + item[10] + "</div>" +
                    "</td>";
            html += "<td>" +
                        "<div class='orb_value'>" + item[11] + "</div>" +
                    "</td>";
		html += "</tr>";
    }

    html += "<tr></tr>";
// for sum
    html += "<tr>";
            html += "<td class='first_col'>SUM</td>";
            html += "<td class='first_col'></td>";
            html += "<td><div class='orb_value'></div></td>";
            html += "<td style='color: #FFEB3B;'><div class='orb_value'><div class='flash-blink'>" + sum_new_cases + "</div></div></td>";
            html += "<td style='color: #F44336;'>" +
                        "<div class='orb_value'></div>" +
                    "</td>";
            html += "<td style='color: #FF9800;'>" +
                        "<div class='orb_value'>" + sum_new_deaths + "</div>" +
                    "</td>";
            html += "<td style='color: #4CAF50;'>" +
                        "<div class='orb_value'></div>" +
                    "</td>";
			html += "<td style='color: #673AB7;'>" +
                        "<div class='orb_value count'>" + sum_active_cases + "</div>" +
                    "</td>";
			html += "<td>" +
                        "<div class='orb_value'>" + sum_serious + "</div>" +
                    "</td>";
            html += "<td>" +
                        "<div class='orb_value'></div>" +
                    "</td>";
            html += "<td>" +
                        "<div class='orb_value'></div>" +
                    "</td>";
            html += "<td>" +
                        "<div class='orb_value'></div>" +
                    "</td>";
		html += "</tr>";

    $('#tbody').html(html);
}

function insert_data_param(data_array) {
    for(var i = 0; i < data_array.length; i++) {
        data_table[i] = [];
        data_table[i][0] = data_array[i]['country_flags'];
        data_table[i][1] = data_array[i]['country_name_en'];
        data_table[i][2] = data_array[i]['total_cases'];
        data_table[i][3] = data_array[i]['new_cases'];
        data_table[i][4] = data_array[i]['total_deaths'];
        data_table[i][5] = data_array[i]['new_deaths'];
        data_table[i][6] = data_array[i]['total_recovered'];
        data_table[i][7] = data_array[i]['active_cases'];
        data_table[i][8] = data_array[i]['serious_critical'];
        data_table[i][9] = data_array[i]['tot_cases_1m_pop'];
        data_table[i][10] = data_array[i]['deaths_1m_pop'];
        data_table[i][11] = data_array[i]['1st_case'];
        data_table[i][12] = data_array[i]['continent'];
    }
}

$("#date").on('change',function(){
    var date = $(this).val();
    if(date == "Today") {
        date = get_str_today();
    } else if(date == "Yesterday") {
        date = get_str_yesterday();
    }

    console.log(date);       
        $.ajax({
              type: "POST",
              url: "request_ajax_table_data.php",
              data: {
                  'date' : date
                },
              success: function(res){
                    var table_data_tmp = JSON.parse(res);
                    console.log(table_data_tmp);

                    if(table_data_tmp == '0'){
                        data_table = [];     
                    }

                    for(var i = 0; i < table_data_tmp.length; i++) {
                        data_table[i] = [];                   
                        data_countries[i] = table_data_tmp[i]['country_name_en']; 
                        data_table[i][0] = table_data_tmp[i]['country_flags'];
                        data_table[i][1] = table_data_tmp[i]['country_name_en'];
                        data_table[i][2] = table_data_tmp[i]['total_cases'];
                        data_table[i][3] = table_data_tmp[i]['new_cases'];
                        data_table[i][4] = table_data_tmp[i]['total_deaths'];
                        data_table[i][5] = table_data_tmp[i]['new_deaths'];
                        data_table[i][6] = table_data_tmp[i]['total_recovered'];
                        data_table[i][7] = table_data_tmp[i]['active_cases'];
                        data_table[i][8] = table_data_tmp[i]['serious_critical'];
                        data_table[i][9] = table_data_tmp[i]['tot_cases_1m_pop'];
                        data_table[i][10] = table_data_tmp[i]['deaths_1m_pop'];
                        data_table[i][11] = table_data_tmp[i]['1st_case'];
                        data_table[i][12] = table_data_tmp[i]['continent'];
                        data_table[i][13] = table_data_tmp[i]['all_union'];
                    }
                        tblDraw();
                        insert_data();
                },
            });

});

$("#bar_date").on('change',function(){
    var bar_date = $(this).val();
    
    if(bar_date == "Today") {
        bar_date = get_str_today();
    } else if(bar_date == "Yesterday") {
        bar_date = get_str_yesterday();
    }

    $.ajax({	
        type: "POST",
        url: "request_ajax_bar_data.php",
        data: {
                'bar_date' : bar_date
            },
        success: function(res){
            var bar_data = JSON.parse(res);
            console.log(bar_data);
///////////////////////////////////////////

///////////////////////////////////////////    
        },
    });
});

$("#map_date").on('change',function(){
    var map_date = $(this).val();
   
    if(map_date == "Today") {
        map_date = get_str_today();
    } else if(map_date == "Yesterday") {
        map_date = get_str_yesterday();
    }
    console.log(map_date);       
    $.ajax({
        type: "POST",
        url: "request_ajax_map_data.php",
        data: {
                'map_date' : map_date
            },
        success: function(res){
            var map_data = JSON.parse(res);
            console.log(map_data);
            map_tooltip_data_view = [];
            for(var i = 0; i < map_data.length; i++) {
                map_tooltip_data_view[i] = [];
                map_tooltip_data_view[i]["country_code"] = map_data[i]["country_flags"];
                map_tooltip_data_view[i]["country_name"] =  map_data[i]["country_name_en"];
                map_tooltip_data_view[i]["total_cases"] = map_data[i]["total_cases"];
                map_tooltip_data_view[i]["serious_critical"] =  map_data[i]["serious_critical"];
                map_tooltip_data_view[i]["total_deaths"] =  map_data[i]["total_deaths"];
                map_tooltip_data_view[i]["total_recovered"] =  map_data[i]["total_recovered"];
            }
        },
    });

});

$('#chart_date').on('change',function(){
    var chart_date = $(this).val();
   
   if(chart_date == "Today") {
      chart_date = get_str_today();
   } else if(chart_date == "Yesterday") {
      chart_date = get_str_yesterday();
   }
   console.log(chart_date);       
   $.ajax({
       type: "POST",
       url: "request_ajax_chart_data.php",
       data: {
               'chart_date' : chart_date
           },
       success: function(res){
            var chart_data = JSON.parse(res);
            var daily_cases_view_tmp = [];   
            var daily_serious_view_tmp = [];
            var daily_deaths_view_tmp = [];
            var daily_recovered_view_tmp = [];
            var lb_date_view_tmp = [];

        for(var i = 0; i < chart_data[0].length; i++) {
            daily_cases_view_tmp[i] = chart_data[0][i]['all_cases'];
            daily_serious_view_tmp[i] = chart_data[1][i]['all_serious'];
            daily_deaths_view_tmp[i] = chart_data[2][i]['all_deaths'];
            daily_recovered_view_tmp[i] = chart_data[3][i]['all_recovered'];
            lb_date_view_tmp[i] = chart_data[4][i]['date'];
        }

///////////////////////////////////////////////////
    chart_grap.updateOptions({
            series: [{
                name: 'All cases',
                data: daily_cases_view_tmp
                }, {
                name: 'All serious',
                data: daily_serious_view_tmp
                }, {
                name: 'All deaths',
                data: daily_deaths_view_tmp
                }, {
                name: 'All recovered',
                data: daily_recovered_view_tmp
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
                categories: lb_date_view_tmp
                },
                legend: {
                position: 'top'
                },
                
                tooltip: {
                x: {
                    format: 'dd/MM/yy'
                },
                },
            })
//////////////////////////////////////////////////     
       },
   });
})

$('#africa_data').click(function(){
    var tmp_array = [];
    var nCount = 0;
    for(var i = 0; i < data_table.length; i++) {
        if(data_table[i][12] == continent_cons['africa']) {  
            tmp_array[nCount] = [];
            for(var j = 0; j < data_table[i].length; j++) {
                tmp_array[nCount][j] = data_table[i][j];
            } 
            nCount ++;
        }
    }
    data_table = [];
    for(var i = 0; i < tmp_array.length; i++) {
        data_table[i] = [];
        for(var j = 0; j < tmp_array[i].length; j++){
            data_table[i][j] = tmp_array[i][j];
        }
    }
    tblDraw();
    insert_data();
});
$('#europe_data').click(function(){
    var tmp_array = [];
    var nCount = 0;
    for(var i = 0; i < data_table.length; i++) {
        if(data_table[i][12] == continent_cons['europe']) {  
            tmp_array[nCount] = [];
            for(var j = 0; j < data_table[i].length; j++) {
                tmp_array[nCount][j] = data_table[i][j];
            } 
            nCount ++;
        }
    }
    data_table = [];
    for(var i = 0; i < tmp_array.length; i++) {
        data_table[i] = [];
        for(var j = 0; j < tmp_array[i].length; j++){
            data_table[i][j] = tmp_array[i][j];
        }
    }
    tblDraw();
    insert_data();
});
$('#asia_data').click(function(){
    var tmp_array = [];
    var nCount = 0;
    for(var i = 0; i < data_table.length; i++) {
        if(data_table[i][12] == continent_cons['asia']) {  
            tmp_array[nCount] = [];
            for(var j = 0; j < data_table[i].length; j++) {
                tmp_array[nCount][j] = data_table[i][j];
            } 
            nCount ++;
        }
    }
    data_table = [];
    for(var i = 0; i < tmp_array.length; i++) {
        data_table[i] = [];
        for(var j = 0; j < tmp_array[i].length; j++){
            data_table[i][j] = tmp_array[i][j];
        }
    }
    tblDraw();
    insert_data();
});
$('#nor_amireca_data').click(function(){
    var tmp_array = [];
    var nCount = 0;
    for(var i = 0; i < data_table.length; i++) {
        if(data_table[i][12] == continent_cons['nor_amireca']) {  
            tmp_array[nCount] = [];
            for(var j = 0; j < data_table[i].length; j++) {
                tmp_array[nCount][j] = data_table[i][j];
            } 
            nCount ++;
        }
    }
    data_table = [];
    for(var i = 0; i < tmp_array.length; i++) {
        data_table[i] = [];
        for(var j = 0; j < tmp_array[i].length; j++){
            data_table[i][j] = tmp_array[i][j];
        }
    }
    tblDraw();
    insert_data();
});
$('#sth_amirica_data').click(function(){
    var tmp_array = [];
    var nCount = 0;
    for(var i = 0; i < data_table.length; i++) {
        if(data_table[i][12] == continent_cons['sth_amireca']) {  
            tmp_array[nCount] = [];
            for(var j = 0; j < data_table[i].length; j++) {
                tmp_array[nCount][j] = data_table[i][j];
            } 
            nCount ++;
        }
    }
    data_table = [];
    for(var i = 0; i < tmp_array.length; i++) {
        data_table[i] = [];
        for(var j = 0; j < tmp_array[i].length; j++){
            data_table[i][j] = tmp_array[i][j];
        }
    }
    tblDraw();
    insert_data();
});
$('#australia_data').click(function(){
    var tmp_array = [];
    var nCount = 0;
    for(var i = 0; i < data_table.length; i++) {
        if(data_table[i][12] == continent_cons['australia']) {  
            tmp_array[nCount] = [];
            for(var j = 0; j < data_table[i].length; j++) {
                tmp_array[nCount][j] = data_table[i][j];
            } 
            nCount ++;
        }
    }
    data_table = [];
    for(var i = 0; i < tmp_array.length; i++) {
        data_table[i] = [];
        for(var j = 0; j < tmp_array[i].length; j++){
            data_table[i][j] = tmp_array[i][j];
        }
    }
    tblDraw();
    insert_data();
});
$('#aciana_data').click(function(){
    var tmp_array = [];
    var nCount = 0;
    for(var i = 0; i < data_table.length; i++) {
        if(data_table[i][12] == continent_cons['aciana']) {  
            tmp_array[nCount] = [];
            for(var j = 0; j < data_table[i].length; j++) {
                tmp_array[nCount][j] = data_table[i][j];
            } 
            nCount ++;
        }
    }
    data_table = [];
    for(var i = 0; i < tmp_array.length; i++) {
        data_table[i] = [];
        for(var j = 0; j < tmp_array[i].length; j++){
            data_table[i][j] = tmp_array[i][j];
        }
    }
    tblDraw();
    insert_data();
});
$('#arabic_data').click(function(){
    var tmp_array = [];
    var nCount = 0;
    for(var i = 0; i < data_table.length; i++) {
        if(data_table[i][13] == continent_cons['arabic']) {  
            tmp_array[nCount] = [];
            for(var j = 0; j < data_table[i].length; j++) {
                tmp_array[nCount][j] = data_table[i][j];
            } 
            nCount ++;
        }
    }
    data_table = [];
    for(var i = 0; i < tmp_array.length; i++) {
        data_table[i] = [];
        for(var j = 0; j < tmp_array[i].length; j++){
            data_table[i][j] = tmp_array[i][j];
        }
    }
    tblDraw();
    insert_data();
});
$('#all_data').click(function(){
    tblDraw();
});


function compare_countries(a, b) {
    a = a.toString();
    b = b.toString();

    console.log(a,b);

    value1 = a.toUpperCase();
    value2 = b.toUpperCase();

    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function compare_total_cases(a, b) {
    a = a.toString();
    b = b.toString();
    value1 = a.toUpperCase();
    value2 = b.toUpperCase();
    
    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function compare_new_cases(a, b) {
    a = a.toString();
    b = b.toString();
    value1 = a.toUpperCase();
    value2 = b.toUpperCase();

    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function compare_total_deaths(a, b) {
     a = a.toString();
    b = b.toString();
    value1 = a.toUpperCase();
    value2 = b.toUpperCase();

    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function compare_new_deaths(a, b) {
     a = a.toString();
    b = b.toString();
    value1 = a.toUpperCase();
    value2 = b.toUpperCase();

    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function compare_total_recovered(a, b) {
    a = a.toString();
    b = b.toString();
    value1 = a.toUpperCase();
    value2 = b.toUpperCase();

    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function compare_active_cases(a, b) {
    a = a.toString();
    b = b.toString();
    value1 = a.toUpperCase();
    value2 = b.toUpperCase();

    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function compare_serios_critical(a, b) {
    a = a.toString();
    b = b.toString();
    value1 = a.toUpperCase();
    value2 = b.toUpperCase();

    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function compare_total_cases_1m(a, b) {
    a = a.toString();
    b = b.toString();
    value1 = a.toUpperCase();
    value2 = b.toUpperCase();

    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function compare_deaths_1m(a, b) {
    a = a.toString();
    b = b.toString();
    value1 = a.toUpperCase();
    value2 = b.toUpperCase();

    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function compare_date_first(a, b) {
    a = a.toString();
    b = b.toString();
    value1 = a.toUpperCase();
    value2 = b.toUpperCase();

    let comparison = 0;
    if (value1 > value2) {
        comparison = 1;
    } else if (value1 < value2) {
        comparison = -1;
    }
    if (sort_dir == -1) {
        return comparison * -1;
    }
    return comparison;
}

function data_sort(data, sort_item, sort_dir) {
    if (sort_item == "countries") {
        data = data.sort(compare_countries)
        return data
    } else if (sort_item == "total cases") {
        data = data.sort(compare_total_cases)
        return data
    } else if (sort_item == "new cases") {
        data = data.sort(compare_new_cases)
        return data
    } else if (sort_item == "total deaths") {
        data = data.sort(compare_total_deaths)
        return data
    } else if (sort_item == "new deaths"){
        data = data.sort(compare_new_deaths)
        return data
    } else if (sort_item == "total recovered"){
        data = data.sort(compare_total_recovered)
        return data
    } else if (sort_item == "active cases"){
        data = data.sort(compare_active_cases)
        return data
    } else if (sort_item == "serios critical"){
        data = data.sort(compare_serios_critical)
        return data
    } else if (sort_item == "total cases 1m pop"){
        data = data.sort(compare_total_cases_1m)
        return data
    } else if (sort_item == "deaths 1m pop"){
        data = data.sort(compare_deaths_1m)
        return data
    } else {
        data = data.sort(compare_date_first)
        return data
    }
}

$(document).ready(function() {
    $('.js-example-basic-single').select2();
    insert_data();
    tblDraw();
    for(var i = 0; i < data_countries.length; i++) {
        var html = "<option value='" + data_countries[i] + "'>" + data_countries[i] + "</option>"
        $('#search_code').append(html); 
    }

    var today  = new Date();
    for ( var i = 0; i < 7; i ++ ) {
        var date_op = new Date(today);
        date_op.setDate(today.getDate() - i);
       
        var year = date_op.getYear() + 1900;
        var date = date_op.getDate();
        var month = date_op.getMonth() + 1;
        if(month < 10) {
            month = "0" + month;
        }
        if(date < 10) {
            date = "0" + date; 
        }
        var str_dt = year+"-"+month+"-"+date;
        if(i == 0) {
            str_dt = "Today";
        }else if(i == 1) {
            str_dt = "Yesterday";
        }
        var html = "<option value='" + str_dt + "'>" + str_dt + "</option>"
        $('#date').append(html);
        $('#bar_date').append(html);
        $('#map_date').append(html); 
        $('#chart_date').append(html); 
    }
    
});

$('#search_code').change(function(){
    var country = $(this).val();
    insert_data();    
    var select_ctry = [];
    for(var i = 0; i < data_table.length; i++) {
        if(country == data_table[i][1]) {
            for(var j = 0; j < data_table[i].length; j++){
                select_ctry[j] =  data_table[i][j];
            }
            break;
        }
    }
    data_table = [];
    data_table[0] = [];
    for(var i = 0; i < select_ctry.length; i++) {
        data_table[0][i] = select_ctry[i];
    }
    tblDraw();
    insert_data();  
});

</script>