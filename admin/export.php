<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php

$katha = new publicview();

$file_name = md5(rand()) . '.csv';
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$file_name");
header("Content-Type: application/csv;");
$file = fopen("php://output", "w");
$header = array("id", "username", "email","status", "user_type","first name","last_name","last login attempt"," profile created on","remarks","twitter profile"."facebook profile","google-plus profile" );
fputcsv($file, $header);

if(isset($_GET["from_date"]) && isset($_GET["to_date"]))
{
	$katha->query = "SELECT * FROM users INNER JOIN userlogs ON users.id = userlogs.user_id 
	WHERE DATE(users.created_at) BETWEEN '".$_GET["from_date"]."' AND '".$_GET["to_date"]."' 	";
	if(!$check->is_admin())
	{
		$katha->query .= ' AND users.id = "'.$_SESSION["id"].'" ';
	}
}
else
{
	$katha->query = "	SELECT * FROM users INNER JOIN userlogs ON users.id = userlogs.user_id 	";
	if(!$check->is_admin())
	{
		$katha->query .= ' WHERE users.id = "'.$_SESSION["id"].'" ';
	}
}

$katha->query .= 'ORDER BY users.created_at DESC';
$katha->execute();

$result = $katha->statement_result();

foreach($result as $row)
{
	$data = array();
	$data[] = $row["id"];
	$data[] = $row["username"];
	$data[] = $row["email"];
	$data[] = $row["login_status"];
	$data[] = $row["user_type"];
	$data[] = $row["first_name"];
	$data[] = $row["last_name"];
	$data[] = $row["last_login_attempt"];
	$data[] = $row["created_at"];
	$data[] = $row["remarks"];
	$data[] = $row["twitter"];
	$data[] = $row["facebook"];
	$data[] = $row["googleplus"];
	fputcsv($file, $data);
}
fclose($file);
exit;

?>