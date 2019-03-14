<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

</head>

<body>
  <?php
$dbhost = "localhost";
$dbuser = "matecsol_jose26";
$dbpassword = "jose26";
$dbname = "matecsol_CVUG";

$link = mysql_connect($dbhost,$dbuser,$dbpassword);
mysql_select_db($dbname); 

	$msql=new mysqli($dbhost,$dbuser,$dbpassword,$dbname);
	
if($msql==false){
	die("ERROR: No fue posible conectarse con la base de datos.". mysqli_conect_error());
	}
		echo '<div id="message">';
	
?>

</body>
</html>
