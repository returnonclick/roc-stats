<div class="container"> 

	<h1>Return On Click Statistics</h1>

	<div id="chart_div" style="height: 500px;"></div>

	<div class="panel panel-default">  
		<div class="panel-heading">
			Calls from <?php echo date('d M Y',strtotime($date_from)); ?> to <?php echo date('d M Y',strtotime($date_to)); ?>		
		</div>
		<table class="table">
			<thead class="thead">
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Tag</th>
					<th>Clicks</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if($result):
				$counter = 1;
				$strToChart = '';
				foreach ($daily_result as $call):
					$strToChart .= ",['".date('d M', strtotime($call->day))."',  $call->phone_clicks,      3,			2		]"
					?>
					<tr>
						<th scope="row"><?php echo $counter; ?></th>
						<td><?php echo date('d M', strtotime($call->day)); ?></td>
						<td><?php echo $call->tag; ?></td>
						<td><?php echo $call->phone_clicks; ?></td>
					</tr>		<?php
					$counter++;
				endforeach;
			endif;		?>
			</tbody>
		</table>
	</div>

	<h3>Shortcodes</h3>
	
	<div class="row">
		<div class="col-md-4 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12" style="text-align:center;padding-bottom:5px;height:39px;">
					<a href="#">0425 999 ...</a>
				</div>
				<div class="col-md-12">
					<pre>[call_link tag="First" phone_number="0425 999 000"]</pre>
				</div>		
			</div>
		</div>
		<div class="col-md-4 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12" style="text-align:center;padding-bottom:5px;">
					<a href="#" class="btn btn-primary">Call Now</a>
				</div>
				<div class="col-md-12">
					<pre>[call_button style="primary" hide="false" phone_number="0425 999 000"]Call Now[/call_button]</pre>
				</div>		
			</div>
		</div>
		<div class="col-md-4 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12" style="text-align:center;padding-bottom:5px;">
					<a href="#" class="btn btn-danger">0425 999 ...</a>
				</div>
				<div class="col-md-12">
					<pre>[call_button tag="Second" style="danger" phone_number="0425 999 000"]</pre>
				</div>		
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12" style="text-align:center;padding-bottom:5px;">
					<a href="#" class="btn btn-success">0425 999 ...</a>
				</div>
				<div class="col-md-12">
					<pre>[call_button style="success" phone_number="0425 999 000"]</pre>
				</div>		
			</div>
		</div>
		<div class="col-md-4 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12" style="text-align:center;padding-bottom:5px;">
					<a href="#" class="btn btn-warning">0425 999 ...</a>
				</div>
				<div class="col-md-12">
					<pre>[call_button style="warning" phone_number="0425 999 000"]Call Now[/call_button]</pre>
				</div>		
			</div>
		</div>
		<div class="col-md-4 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12" style="text-align:center;padding-bottom:5px;">
					<a href="#" class="btn btn-default">0425 999 000</a>
				</div>
				<div class="col-md-12">
					<pre>[call_button hide="false" style="default" phone_number="0425 999 000"]</pre>
				</div>		
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<p>For adding phone links or buttons you must use call_link or call_button shortcodes which looks like that: [call_button phone_number="0425 999 000"]PhoneNumber[/call_button]. <br /> You can use that with or without colse tag which just is necessary if you whant to change the content of the link (text inside)</p>
			<p>There is more option with different attributes - phone_number, style, hide, tag. </p>
			<p>phone_number: You must inform the phone number to be called. Example: [call_link phone_number="0425 999 000"].</p>
			<p>hide: you can choose if you whant to show or hide the complete phone number. Example: [call_button hide="false" phone_number="0425 999 000"].</p>
			<p>tag: you can see this tag on reports. Example: [call_button tag="Home Page" phone_number="0425 999 000"].</p>
			<p>style: You can choose betwen few styles on buttons - primary, default, success, warning or danger. Example: [call_button style="warning" phone_number="0425 999 000"].<br />
			Notice: these pre-defined styles requires the BuildPress Theme.
			</p>

		</div>
	</div> 	
</div>







<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawVisualization);


	function drawVisualization() {
		// Some raw data (not necessarily accurate)
		var data = google.visualization.arrayToDataTable([
			['Day', 'Calls', 'Emails', 'Average'	]
			<?php echo $strToChart; ?>
		]);

		var options = {
			title : 'Contact Statistics',
			vAxis: {title: ''},
			hAxis: {title: 'Day'},
			seriesType: 'bars',
			series: {2: {type: 'line'}}
		};

	    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
	    chart.draw(data, options);
	}
</script>

<?php
	// echo '<pre>';
	// //echo $sql_query;
	// print_r($result);
	// print_r($total_result);
	// echo '</pre>';
?>