<div class="container"> 
<div class="wrap">
<h2>Shortcodes for ROC Statistics</h2>
<?php echo $this->warning_message;?>
	<div class="jumbotron" >
	<div class="row ">
		<div class="col-md-3 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12 short-label">
					<a href="#">0425 999 ...</a>
				</div>
				<div class="col-md-12 short-code">
					<textarea class="short-code">[call to="0425 999 000" tag="Contact Us"]</textarea>
					
				</div>		
			</div>
		</div>
		<div class="col-md-3 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12 short-label">
					<a href="#" class="btn btn-primary">Call Now</a>
				</div>
				<div class="col-md-12 short-code">
					<textarea class="short-code">[call to="0425 999 000" style="primary" tag="Contact Us" hide="false" content="Call Now"]</textarea>
				</div>		
			</div>
		</div>
		<div class="col-md-3 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12 short-label">
					<a href="#" class="btn btn-primary">0425 999 000</a>
				</div>
				<div class="col-md-12 short-code">
					<textarea class="short-code">[call to="0425 999 000" style="primary" tag="Contact Us" hide="false"]</textarea>
				</div>		
			</div>
		</div>
		<div class="col-md-3 col-sm-6 cl-xs-12">
			<div class="row">	
				<div class="col-md-12 short-label">
					<a href="#" class="btn btn-primary">0425 999 ...</a>
				</div>
				<div class="col-md-12 short-code">
					<textarea class="short-code">[call to="0425 999 000" style="primary" tag="Contact Us" ]</textarea>
				</div>	
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12 short-label">
					<a href="#">0425 999 000</a>
				</div>
				<div class="col-md-12 short-code">
					<textarea class="short-code">[call to="0425 999 000" tag="Contact Us" hide="false"]</textarea>
					
				</div>		
			</div>
		</div>
		<div class="col-md-3 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12 short-label">
					<a href="#" class="btn btn-default">Call Now</a>
				</div>
				<div class="col-md-12 short-code">
					<textarea class="short-code">[call to="0425 999 000" style="default" tag="Contact Us" hide="false" content="Call Now"]</textarea>
				</div>		
			</div>
		</div>
		<div class="col-md-3 col-sm-6 cl-xs-12">
			<div class="row">
				<div class="col-md-12 short-label">
					<a href="#" class="btn btn-default">0425 999 000</a>
				</div>
				<div class="col-md-12 short-code">
					<textarea class="short-code">[call to="0425 999 000" style="default" tag="Contact Us" hide="false"]</textarea>
				</div>		
			</div>
		</div>
		<div class="col-md-3 col-sm-6 cl-xs-12">
			<div class="row">	
				<div class="col-md-12 short-label">
					<a href="#" class="btn btn-default">0425 999 ...</a>
				</div>
				<div class="col-md-12 short-code">
					<textarea class="short-code">[call to="0425 999 000" style="default" tag="Contact Us" ]</textarea>
				</div>	
			</div>
		</div>
	</div>
	</div>  <!-- /jumbotron -->

	<div class="row">
		<div class="col-md-12">
			<h4>Shortcode Generator</h4>
		</div>
	</div> 	
	<div class="jumbotron" >
	<div class="row">
		<div class="col-md-12">
				
			<div class="row">
				<div class="col-md-4 col-sm-6 cl-xs-12">
					<p>Number to Call:</p>
				</div>
				<div class="col-md-8 col-sm-6 cl-xs-12">
					<input class="frm-field" type="tel" id="to" name="to">
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-6 cl-xs-12">
					<p>Hide last 3 numbers:</p>
				</div>
				<div class="col-md-8 col-sm-6 cl-xs-12">
					<input class="frm-field" type="radio" name="hide" id="hide-true" value="true" checked> <label for="hide-true">Yes</label> <br>
  					<input class="frm-field" type="radio" name="hide" id="hide-false" value="false"> <label for="hide-false">No</label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-6 cl-xs-12">
					<p>Add tag (just one):</p>
				</div>
				<div class="col-md-8 col-sm-6 cl-xs-12">
					<input class="frm-field" type="text" id="tag" name="tag">
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-6 cl-xs-12">
					<p>Content do show:</p>
				</div>
				<div class="col-md-8 col-sm-6 cl-xs-12">
					<input class="frm-field" type="text" id="content" name="content">
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-6 cl-xs-12">
					<p>Style:</p>
				</div>
				<div class="col-md-8 col-sm-6 cl-xs-12">
					<input class="frm-field" type="radio" name="style" id="style-primary" value="primary" checked> <label for="style-primary"><a href="#" class="btn btn-primary">primary</a></label> <br />
  					<input class="frm-field" type="radio" name="style" id="style-default" value="default"> <label for="style-default"><a href="#" class="btn btn-default">default</a></label> <br />
  					<input class="frm-field" type="radio" name="style" id="style-other" value="other"> <label for="style-other">Custom CSS class</label>
  					<input class="frm-field" type="text" id="styletext" name="styletext">
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-6 cl-xs-12">
					<p>Result Shortcode:</p>
				</div>
				<div class="col-md-8 col-sm-6 cl-xs-12">
					<textarea class="short-code" id="result-shortcode"></textarea>
				</div>
			</div>
		</div>
	</div> 		
	</div>  <!-- /jumbotron -->

	<div class="jumbotron" >
	<div class="row">
		<div class="col-md-12">
			<p>For adding phone links or buttons you must use call shortcodes which looks like that: [call to="0425 999 000"]. <br /> You can use that with or without colse tag which just is necessary if you whant to change the content of the link (text inside)</p>
			<p>There is more option with different attributes - phone_number, style, hide, content and tag. </p>
			<p>phone_number: You must inform the phone number to be called. Example: [call to="0425 999 000"].</p>
			<p>hide: you can choose if you whant to show or hide the complete phone number. Example: [call hide="false" to="0425 999 000"].</p>
			<p>content: fill this attribute if you want to change the content to show a different information. Example: [call hide="false" to="0425 999 000" content="Call Now"].</p>
			<p>tag: you can see this tag on reports. Example: [call_button tag="Home Page" phone_number="0425 999 000"].</p>
			<p>style: You can choose betwen few styles on buttons - primary, default, success, warning or danger. Example: [call style="warning" to="0425 999 000"].<br />	
			<!--  primary, default, success, info, warning or danger -->
			</p>

		</div>
	</div> 	
	</div>  <!-- /jumbotron -->
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
