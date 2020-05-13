<?php

$total_cases = $con->prepare("SELECT sum(new_cases) FROM countries");
$total_cases->execute();

$total_deaths = $con->prepare("SELECT sum(new_deaths) FROM countries");
$total_deaths->execute();

$total_recovered = $con->prepare("SELECT sum(total_recovered) FROM countries");
$total_recovered->execute();

$total_serious = $con->prepare("SELECT sum(serious_critical) FROM countries");
$total_serious->execute();

$stmt_case = $con->prepare("SELECT * FROM countries");
$stmt_case->execute();
$cases = $stmt_case->fetchall();

$map_data_sql = $con->prepare("select country_flags, country_name_en, total_cases, serious_critical, total_deaths, total_recovered from countries");
$map_data_sql->execute();
$map_tooltip_data = $map_data_sql->fetchall();
?>

<script>

var map_tooltip_data = [];
var map_tooltip_data_view = [];
map_tooltip_data = <?php echo json_encode($map_tooltip_data)?>;


for(var i = 0; i < map_tooltip_data.length; i++) {
	map_tooltip_data_view[i] = [];
	map_tooltip_data_view[i]["country_code"] = map_tooltip_data[i]["country_flags"];
	map_tooltip_data_view[i]["country_name"] =  map_tooltip_data[i]["country_name_en"];
	map_tooltip_data_view[i]["total_cases"] = map_tooltip_data[i]["total_cases"];
	map_tooltip_data_view[i]["serious_critical"] =  map_tooltip_data[i]["serious_critical"];
	map_tooltip_data_view[i]["total_deaths"] =  map_tooltip_data[i]["total_deaths"];
	map_tooltip_data_view[i]["total_recovered"] =  map_tooltip_data[i]["total_recovered"];
}

</script>

<!-- News line -->
<div class="row">
	<div class="col-xl-12 col-md-12 col-lg-12">
		<div class=" overflow-hidden bg-transparent card-crypto-scroll shadow-none">
			<div class="js-conveyor-example">
				<ul class="news-crypto"><?php
					foreach ($cases as $case) { 
						if ($case['new_cases'] && $case['new_deaths'] > 0 ) { ?>
							<li>
								<div class="crypto-card">
									<div class="row">
										<div class="d-flex">
											<div class="my-auto">
												<img name="image" class="img-responsive mt-0 img-line" alt="" src='img/flags/<?php echo $case['country_flags'] . '.png'?>'/>
											</div>
												<div class="ml-3">
													<p class="mb-1 tx-13"><?php echo $case['country_name_en']?></p>
													<div class="m-0 tx-13">
														<span class="text-danger ml-2 text-warning">
															<?php echo $case['new_cases']?>
														</span>
														<span class="text-danger ml-2 text-warning">
															<?php echo $case['new_deaths']?>
														</span>
														<span class="text-danger ml-2 text-success">
															<?php echo $case['total_recovered']?>
														</span>
													</div>
											</div>
										</div>
									</div>
								</div>
							</li><?php
						}
					} ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- Total cases -->
<div class="row row-sm">
	<div class="col-12 col-md-3">
		<div class="card crypto crypt-primary overflow-hidden">
			<div class="card-body iconfont text-left">
				<div class="media">
					<div class="coin-logo bg-primary-transparent">
						<i class="fas fa-user-plus text-primary"></i>
					</div>
					<div class="media-body">
						<h6><?php echo lang('ALL_CASES') ?></h6>
						<p><span class="text-danger"><?php
					for($i=0; $rows_cases = $total_cases->fetch(); $i++){
						echo $rows_cases['sum(new_cases)'];
					} ?></span></p>
					</div>
				</div>

			</div>
							<div class="flot-wrapper">
					<div class="flot-chart ht-80 mt-4" id="total1"></div>
				</div>
			<div class="card-footer">
				<nav class="nav">
					<a class="nav-link active" href=""><span>1D</span><span>-12.24%</span></a> 
					<a class="nav-link" href=""><span>1W</span><span>-16.48%</span></a>
				</nav>
			</div>
		</div>
	</div>

	<div class="col-12 col-md-3">
		<div class="card crypto crypt-danger overflow-hidden">
			<div class="card-body iconfont text-left">
				<div class="media">
					<div class="coin-logo bg-danger-transparent">
						<i class="fas fa-user-clock text-danger"></i>
					</div>
					<div class="media-body">
						<h6><?php echo lang('ALL_SERIOUS') ?></h6>
						<p><span class="text-danger"><?php
						for($i=0; $rows_serious = $total_serious->fetch(); $i++){
							echo $rows_serious['sum(serious_critical)'];
						} ?></span></p>
					</div>
				</div>
			</div>
			<div class="flot-wrapper">
				<div class="flot-chart ht-80  mt-4" id="total2"></div>
			</div>
			<div class="card-footer">
				<nav class="nav">
					<a class="nav-link active" href=""><span>1D</span><span>-12.24%</span></a> 
					<a class="nav-link" href=""><span>1W</span><span>-16.48%</span></a>
				</nav>
			</div>
		</div>
	</div>

	<div class="col-12 col-md-3">
		<div class="card crypto  crypt-success overflow-hidden">
			<div class="card-body iconfont text-left">
				<div class="media">
					<div class="coin-logo bg-success-transparent">
						<i class="fas fa-user-times text-success"></i>
					</div>
					<div class="media-body">
						<h6><?php echo lang('ALL_DEATHS') ?></h6>
						<p><span class="text-danger"><?php
					for($i=0; $rows_deaths = $total_deaths->fetch(); $i++){
						echo $rows_deaths['sum(new_deaths)'];
					} ?></span></p>
					</div>
				</div>
			</div>
			<div class="flot-wrapper">
				<div class="flot-chart ht-80 mt-4" id="total3"></div>
			</div>
			<div class="card-footer">
				<nav class="nav">
					<a class="nav-link active" href=""><span>1D</span><span>-12.24%</span></a> 
					<a class="nav-link" href=""><span>1W</span><span>-16.48%</span></a>
				</nav>
			</div>
		</div>
	</div>

	<div class="col-12 col-md-3">
		<div class="card crypto  crypt-success overflow-hidden">
			<div class="card-body iconfont text-left">
				<div class="media">
					<div class="coin-logo bg-success-transparent">
						<i class="fas fa-user-check text-success"></i>
					</div>
					<div class="media-body">
						<h6><?php echo lang('ALL_RECOVERED') ?></h6>
						<p><span class="text-danger"><?php
					for($i=0; $rows_recovered = $total_recovered->fetch(); $i++){
						echo $rows_recovered['sum(total_recovered)'];
					} ?></span></p>
					</div>
				</div>

			</div>
			<div class="flot-wrapper">
				<div class="flot-chart ht-80 mt-4" id="total4"></div>
			</div>
			<div class="card-footer">
				<nav class="nav">
					<a class="nav-link active" href=""><span>1D</span><span>-12.24%</span></a> 
					<a class="nav-link" href=""><span>1W</span><span>-16.48%</span></a>
				</nav>
			</div>
		</div>
	</div>
</div>

<!-- /row -->

<div class="row" style = "justify-content: flex-end;">
	<!-- <div class="col-md-2">
			<select class="js-example-basic-single" name="state" id = "bar_date" style="width: 80%">
				
			</select>
	</div> -->
	<div class="col-md-2" style="text-align: right">
			<select class="js-example-basic-single" name="state" id = "map_date" style="width: 80%; ">
				
			</select>
	</div>
</div>

<div class="map-bar">
	<div class="row">
		<div class="col-sm-12 col-md-4">
			<div class="card overflow-hidden">
				<div class="card-body">
					<div class="main-content-label mg-b-5">
						Stacked Bar Chart
					</div>

						<div class="ht-400" id="bar-chart"></div>

				</div>
			</div>
		</div>

		<div class="col-lg-8">
			<div class="card mg-b-20" id="map">
				<div class="card-body">
					<div class="main-content-label mg-b-5">
						Vector Map: World
					</div>
					<div class="ht-400" id="vmap"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row" style = "justify-content: flex-end;">
	<div class="col-md-2">
					<label id="flags"></label>
	</div>
	<div class="col-md-2" style="text-align: right">
			<select class="js-example-basic-single" name="state" id ="chart_date" style="width: 80%; ">
			</select>
	</div>
</div>

<!-- row -->
<div class="row row-sm">
	<div class="col-sm-12 col-md-12">
		<div class="card overflow-hidden">
			<div class="card-body">
				<div class="main-content-label mg-b-5">
					Stacked Bar Chart
				</div>
				<div class="ht-400" id="chart"></div>
			</div>
		</div>
	</div>
</div>
<!-- /row -->
<div class="card table-responsive tableContainer" id="table-container">
	
<div class="row" style="justify-content: space-between;">
	<div class="btn-group" role="group" aria-label="Basic example">
		<button type="button" class="btn btn-secondary" id="all_data">All</button>
		<button type="button" class="btn btn-secondary" id="africa_data">Africa</button>
		<button type="button" class="btn btn-secondary " id="europe_data">Europe</button>
		<button type="button" class="btn btn-secondary" id="asia_data">Asia</button>
		<button type="button" class="btn btn-secondary" id="nor_amireca_data">North amireca</button>
		<button type="button" class="btn btn-secondary" id="sth_amirica_data">South amirica</button>
		<button type="button" class="btn btn-secondary" id="australia_data">Australia</button>
		<button type="button" class="btn btn-secondary" id="aciana_data">Aciana</button>
		<button type="button" class="btn btn-secondary" id="arabic_data">Arabic</button>
	</div>

	<div class="col-md-2">
	  <select class="js-example-basic-single" name="state" id = "search_code" style="width: 80%">
	  </select>
	</div>
	<div class="col-md-2" style="text-align: right">
		<select  class="js-example-basic-single" id="date">
	  </select>
	</div>
</div>

  <table  id="dtBasicExample" class="table table-striped table-hover customers-list corona sticky-header" cellspacing="0" width="100%">
		<thead class="" id="myThead">
	    <tr>
    		<th></th>
      	<th id="countries" class="sort"><?php echo lang('COUNTRIES') ?><i class="fa fa-caret-down"></i></th>
      	<th id="total cases" class="sort"><?php echo lang('TOTAL_CASES') ?><i class="fa fa-caret-down"></i></th>
      	<th id="new cases" class="sort"><?php echo lang('NEW_CASES') ?><i class="fa fa-caret-down"></i></th>
      	<th id="total deaths" class="sort"><?php echo lang('TOTAL_DEATHS') ?><i class="fa fa-caret-down"></i></th>
      	<th id="new deaths" class="sort"><?php echo lang('NEW_DEATHS') ?><i class="fa fa-caret-down"></i></th>
      	<th id="total recovered" class="sort"><?php echo lang('TOTAL_RECOVERED') ?><i class="fa fa-caret-down"></i></th>
      	<th id="active cases" class="sort"><?php echo lang('ACTIVE_CASES') ?><i class="fa fa-caret-down"></i></th>
      	<th id="serios critical" class="sort"><?php echo lang('SERIOS_CRITICAL') ?><i class="fa fa-caret-down"></i></th>
      	<th id="total cases 1m pop" class="sort"><?php echo lang('TOTAL_CASES_1M_POP') ?><i class="fa fa-caret-down"></i></th>
      	<th id="deaths 1m pop" class="sort"><?php echo lang('DEATHS_1M_POP') ?><i class="fa fa-caret-down"></i></th>
      	<th id="date first case" class="sort"><?php echo lang('DATE_FIRST_CASE') ?><i class="fa fa-caret-down"></i></th>
	    </tr>
  	</thead>

  	<tbody id="tbody">
		  
  	</tbody>
  </table>
</div>




        

