<!doctype html>
<html>
<head>
    <title>ssebs New Hire Request - Submitted</title>
	<link rel="stylesheet" type="text/css" href="normalize.css" />
	<link rel="stylesheet" type="text/css" href="sakura.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
body {
	font-size: 1em;
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

	</style>
</head>
<body>
    <h4>Person Created! (Emails sent to helpdesk)</h4>
    <?php
// firstname and lastname fields obscured so it does not autofill
$first = $_POST["frist_naem"];
$last = $_POST["lsat_naem"];
$person = $first . "_" . $last;
$mgr = $_POST["mgr"];
if(preg_match('/\((.*)\)/' ,$mgr, $match) == 1 ) {
    //echo "MATCH: " . $match[1];
    $mgr = strtolower($match[1]);
}
$lab = $_POST["lab"];
$st = $_POST["start_dt"];
$phone = $_POST["phone"];
$cmp =  $_POST["comp"];
$cmp_n = $_POST["comp_notes"];
$misc = $_POST["misc_notes"];
$type = $_POST["ee_type"];
$location = $_POST["location"];
$from_email = $_POST["from_email"];

$file_name = "usr-yml/" . $person . ".yml";

$title = "null";
if ( isset($_POST["title"]) ) {
    $title =  $_POST["title"];
} else {
    $title = "";
}
$nd = "null";
if ( isset($_POST["end_dt"]) ) {
    $nd =  $_POST["end_dt"];
} else {
    $nd = "";
}

$yml = <<<EOT
---
- person: $person
  first_name: $first
  last_name: $last
  mgr: $mgr
  lab: $lab
  title: $title
  type: $type
  start_dt: $st
  end_dt: $nd
  phone: $phone
  comp: $cmp
  location: $location
  comp_notes: $cmp_n
  misc_notes: $misc
  requestor: $from_email

EOT;

$tmp = str_replace("\n", "<br>\n", $yml);
//echo str_replace("  ", "&nbsp;&nbsp;", $tmp);
file_put_contents($file_name, $yml);

echo "<hr>\n";

echo $file_name;
$out = shell_exec("cat " . $file_name . " 2>&1");
echo "<pre>" . $out . "</pre>";
$out = NULL;

echo "<hr>\n";

$out = shell_exec("/usr/bin/python3 bin/newhire-main.py 2>&1");
echo "<pre>" . $out . "</pre>";


?>
<div class="center-bl" >
    <form action="../" method="post">
        <button type="submit" >Go Back...</button>
    </form>	
</div>

</body>
</html>
