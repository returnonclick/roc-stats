<div class="container"> 
<div class="wrap">
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
	
	<div class="panel panel-default">  
		<div class="panel-heading">
			Calls from <?php echo date('d M Y',strtotime($this->date_from)); ?> to <?php echo date('d M Y',strtotime($this->date_to)); ?>		
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
	<div class="panel panel-default">  
		<div class="panel-heading">
			Emails from <?php echo date('d M Y',strtotime($this->date_from)); ?> to <?php echo date('d M Y',strtotime($this->date_to)); ?>		
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

	<h3 style="padding: 35px 5px 20px 5px;">Shortcodes</h3>
	
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
			<!--  primary, default, success, info, warning or danger -->
			</p>

		</div>
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
