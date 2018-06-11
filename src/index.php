<?php
// Generate and read contents of ssebs phone list
$out = shell_exec("/usr/bin/python3 bin/gen-people.py 2>&1");
$str = file_get_contents('people.txt');
$ary = json_decode($str, true);
#echo "[";
#foreach ($ary as $k=>$v){
#    echo '"' . $v . '",'; 
#}
#echo '""]';

?>
<!doctype html>
<html>
<head>
    <title>ssebs New Hire Request</title>
	<link rel="stylesheet" type="text/css" href="normalize.css" />
	<link rel="stylesheet" type="text/css" href="sakura.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
body {
	font-size: 1em;
    max-width: initial;
	background-color: #fff;
}
.center-bl {
	margin: auto;
	/* width: 75%; */
	text-align: center;
    max-width: 40em;
}
.center-list {
	text-align: left;
	display: inline-block;
}
.fl {
	float:left;
	width: 50%;
}
li {
	margin: 0;
}
button {
	background-color: #1f5469;
	border: 1px solid #1f5469;
}
hr {
	border-color: #1f5469;
}
	</style>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="./disableAutoFill.js"></script>
	<script>
	var tags = <?php
		echo "[";
		foreach ($ary as $k=>$v){
			echo '"' . $v . '",'; 
		}
		echo '""]';
	?>;

	$( function() {
		$( "#datepicker1" ).datepicker();
		$( "#datepicker2" ).datepicker();
	});
	$(document).ready(function() {
		$( ".auto" ).autocomplete({
		source: function( request, response ) {
			var matcher = new RegExp( "" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
			response( $.grep( tags, function( item ){
				return matcher.test( item );
			}) );
		}
	});	
});
	</script>
</head>
<body>
	<div class="center-bl" >
	    <h3 style="margin: 10px auto;">ssebs New Hire Request Form for CNS</h3>
		<div class="fl">
			<ul class="center-list">
				<h6 style="margin: 5px auto;">This form is used to setup:</h6>
				<li>Network accounts (Email and login)</li>
				<li>Computer(s) (Mac, Windows, Linux)</li>
				<li>Desk Phone</li>
			</ul>
		</div>
		<div class="fl">
			<p style="text-align: justify;"><em>Please Note: </em><strong>ALL</strong> data in this form must be correct, CNS will use this data to create accounts and configure machines. Changing someone's name can be a more complex process than it seems. Thanks!</p>
		</div>
		<div style="clear: both;" ></div>
		<p>Emails will be sent on your behalf to <a href="mailto:helpdesk@ssebs.com">helpdesk@ssebs.com</a>, and you (the requestor)</p>
	</div>
	<hr>
	<br>
	<div class="center-bl" >
	<form id="login-form" action="submit.php" method="post" onsubmit="return confirm('Are you sure everything is correct? Name MUST be spelled correctly!');" class="ib">
        <div class="fl">
			<!-- 
				&#8203; (Invisible Char) Needs to be used so autofill can be disabled
				Same thing with renaming the input name fields
			 -->
			<label>First N&#8203;ame: </label><input type="text" name="frist_naem" autocomplete="off" required><br/>
			<label>Last N&#8203;ame: </label><input type="text" name="lsat_naem" autocomplete="off" required><br/>
			<label>Manager: </label><input class="auto" type="text" name="mgr" required><br/>
			<!-- <label>Manager First N&#8203;ame: </label> <input type="text" name="mgr_frist" required><br/> -->
			<!-- <label>Manager Last N&#8203;ame: </label> <input type="text" name="mgr_lsat" required><br/>		 -->
			<label>Department: </label> <input type="text" name="lab" required><br/>
			<label>Job Title: </label> <input type="text" name="title" ><br/>
			<label>Employee Type:</label>
				<select name="ee_type" >
					<option value="term">Full Time Term (Has an End Date)</option>
					<option value="regular">Regular (No End Date)</option>
					<option value="intern">Intern</option>
					<option value="contractor">Contractor</option>
					<option value="consultant">Consultant</option>
				</select>
		    <label>Requestor Email:</label> <input type="text" name="from_email" required><br/>
		</div>
		<div class="fl">	
			<label>Start Date:</label> <input type="text" id="datepicker1" name="start_dt" autocomplete="off" required><br/>
			<label>End Date:</label> <input type="text" id="datepicker2" name="end_dt" autocomplete="off" ><br/>
			<label>Desk Phone Required?:</label> 
                <input type="radio" name="phone" value="yes" required> Yes &nbsp;&nbsp;
                <input type="radio" name="phone" value="no" required> No
            <br/>

			<label>Location? (35-####) :</label> <input type="text" name="location"><br/>
			<label>Computer Type:</label>
				<select name="comp">
					<option value="windows">Windows</option>
					<option value="mac">Mac</option>
					<option value="linux">Linux</option>
					<option value="other">Other</option>
					<option value="none">None</option>
				</select>
			<label>Computer Notes (new? name? etc?):</label> <input type="text" name="comp_notes"><br/>
		    <label>Misc Notes/Special Requests? :</label> <input type="text" name="misc_notes"><br/>
		</div>
		<div style="clear: both;" ></div>
        <br>
		<button type="submit" name="sumbit" >Create</button>
    </form>	

	</div>

</body>
</html>
