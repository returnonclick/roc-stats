<div class="wrap">
<div class="container"> 
<h2>Return On Click Statistics</h2>
<?php echo $this->warning_message;?>
	<div class="row">
		<form name="filter_dates" method="POST">
		<div class="col-md-12" style="text-align:right;" >
			<form method="post" id="datefilter"> 
				Filter: <input type="text" name="daterange">	
				<input name="submit" id="submit" class="button button-primary" value="Ok" type="submit">
				<input type="hidden" name="usedaterange" value="1">
			</form>
		</div>
		</form>
	</div>

	<div id="chart_div" style="height: 500px;"></div>
	
	<h3 style="padding: 35px 5px 20px 5px;">Calls Details</h3>
	<div class="panel panel-default">  
		<div class="panel-heading">
			from <?php echo date('d M Y',strtotime($this->date_from)); ?> to <?php echo date('d M Y',strtotime($this->date_to)); ?>		
		</div>
		<table class="table">
			<thead class="thead">
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Tag</th>
					<th>Calls</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if($call_stat_table_result):
				$counter = 1;
				foreach ($call_stat_table_result as $call):		?>
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
	<div class="divider"></div>
	<h3 style="padding: 35px 5px 20px 5px;">Email Details</h3>
	<div class="panel panel-default">  
		<div class="panel-heading">
			from <?php echo date('d M Y',strtotime($this->date_from)); ?> to <?php echo date('d M Y',strtotime($this->date_to)); ?>		
		</div>
		<table class="table">
			<thead class="thead">
				<tr>
					<th>#</th>
					<th>Date</th>
					<th>Contact Form</th>
					<th>Emails Received</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if($email_stat_table_result):
				$counter = 1;
				foreach ($email_stat_table_result as $email):		?>
					<tr>
						<th scope="row"><?php echo $counter; ?></th>
						<td><?php echo date('d M', strtotime($email->day)); ?></td>
						<td><?php echo $email->form_name; ?></td>
						<td><?php echo $email->emails_sent; ?></td>
					</tr>		<?php
					$counter++;
				endforeach;
			endif;		?>
			</tbody>
		</table>
	</div>

	<div class="row">
		<div class="col-md-12" style="text-align:right;">
			© 2016 <a href="http://www.returnonclick.com.au" target="_blank"> Return On Click </a>All rights reserved.
		</div>
	</div> 	
</div>
</div>

<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawVisualization);

	<?php if(strlen($stat_chart['strToChart']) > 2): 		?>

	function drawVisualization() {
		// Some raw data (not necessarily accurate)
		var data = google.visualization.arrayToDataTable([
			['Day', 'Calls', 'Emails', 'Average'	]
			<?php echo $stat_chart['strToChart'] ; ?>
		]);

		var options = {
			title : 'Stats from <?php echo date('d M Y',strtotime($this->date_from)); ?> to <?php echo date('d M Y',strtotime($this->date_to)); ?>',
			vAxis: {title: ''},
			hAxis: {title: 'Day'},
			seriesType: 'bars',
			series: {2: {type: 'line'}}
		};

	    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
	    chart.draw(data, options);
	}

	<?php endif; 		?>
</script>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$('input[name="daterange"]').daterangepicker({
	    "ranges": {
	       'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(30, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'This Year': [moment().startOf('year'), moment().endOf('year')],
	    },
	    "locale": {
	        "format": "DD-MM-YYYY",
	    },
	    "parentEl": "daterange",
	    "startDate": "<?php echo date('d-m-Y',strtotime($this->date_from)); ?>",
	    "endDate": "<?php echo date('d-m-Y',strtotime($this->date_to)); ?>",
	    "opens": "left"
	}, function(start, end, label) {
		//$('#datefilter').submit();		it was not working... i don't know why
		//console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
	});



	// $('input[name="daterange"]').daterangepicker();
});
</script>
