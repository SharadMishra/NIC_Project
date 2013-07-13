
<html>
<head>
<link rel="stylesheet" type="text/css" href="basic.css">

</head>
<body class="bodywrapper">
<?php
$p_state= " ";
$p_city= " ";
$season = " ";
$pins= $_POST['pincode'];
//echo $pins;
$state = $_POST['state'];
$city = $_POST['city'];
$today=date("M");
//echo "Hello. You are from ".$city." "."(".$state.")";
echo "<br>";
if ($today=="Jul"||"Aug"||"Sep")
  {
	$season = "Kharif";
//	echo $season;
	}	

else if ($today=="Oct"||"Nov"||"Dec"||"Jan"||"Feb")
	{
	$season = "Rabi";
	}
$con=mysqli_connect("localhost","root","root","state_crop");
if (mysqli_connect_errno())
	{
	echo "Failed to connect to MYSQL: " . mysqli_connect_error();
	}
//echo "connection made";

$val = mysqli_query($con, "SELECT STATE FROM pincode WHERE PIN='$pins'");//$pstate = mysqli_query($con,"SELECT STATE FROM pincode WHERE PIN='$pins'");
$row = mysqli_fetch_array($val);
$p_state = $row['STATE'];


$valc = mysqli_query($con, "SELECT CITY FROM pincode WHERE PIN='$pins'");
$rowc = mysqli_fetch_array($valc);
$p_city = $rowc['CITY'];

$print = mysqli_query($con,"SELECT STATE,DISTRICT FROM season WHERE STATE='$state' OR (STATE='$p_state' AND DISTRICT='$p_city')");
$rowyc = mysqli_fetch_array($print);
$yourcity= $rowyc['DISTRICT'];
$yourstate = $rowyc['STATE'];

$result = mysqli_query($con,"SELECT DISTINCT CROP FROM season WHERE STATE='$state' OR (STATE='$p_state' AND DISTRICT='$p_city') AND SEASON='$season'");
echo "Hello. You are from ".$yourcity." "."(".$yourstate.")";
echo "The season is ".$season."<br>";
echo "You may grow any of the following :"."<br>";
while($rowcrop = mysqli_fetch_array($result))
{
$crop = $rowcrop['CROP'];
$image = mysqli_query($con, "SELECT * FROM crop_images WHERE CROP='$crop'");
while($rowimage = mysqli_fetch_array($image))
{
?>
<div class="image">
<img class="image" src ="<?php echo $rowimage['IMAGE']; ?>">
</div>
<?php
}
}

?>
</body>
</html>
