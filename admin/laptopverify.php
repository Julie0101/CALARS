
<?php
//  code laptop availablity
require_once("includes/config.php");
if (!empty($_POST["serialnumber"])) {
	$serialnumber = $_POST["serialnumber"];
	$sql = "SELECT SerialNumber FROM tbllaptops WHERE SerialNumber=:serialnumber";
	$query = $dbh->prepare($sql);
	$query->bindParam(':serialnumber', $serialnumber, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	// echo($query->rowCount());
	$cnt = 1;
	if ($query->rowCount() > 0) {
		echo "<span style='color:red'> Laptop Already Exists .</span>";
	} else {
		echo "<span style='color:green'> Laptop is viable for Registration .</span>";
		echo "<script>$('#submit').prop('disabled',false);</script>";
	}
}

if (!empty($_POST["emailid"])) {
	$email = $_POST["emailid"];
	$sql = "SELECT EmailId FROM tblusers WHERE EmailId=:email";
	$query = $dbh->prepare($sql);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	$cnt = 1;
	if ($query->rowCount() > 0) {
		echo "<span style='color:red'> You must be a registered user to upload .</span>";
		echo "<script>$('#submit').prop('disabled',true);</script>";
	} else {
		echo "<span style='color:green'> Continue with registration .</span>";
		echo "<script>$('#submit').prop('disabled',false);</script>";
	}
}
?>