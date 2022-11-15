<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

    # Assign form input with variables. 
	if (isset($_POST['submit'])) {
		$serialnumber = $_POST['serialnumber'];
		$emailid = $_POST['emailid'];
		$laptoptitle = $_POST['laptoptitle'];
		$brand = $_POST['brandname'];
		$laptopoverview = $_POST['laptopoverview'];
		$priceperday = $_POST['priceperday'];
		$processor = $_POST['processor'];
		$storage = $_POST['storage'];
		$ram = $_POST['ram'];
		$charger = $_POST['charger'];
		$bag = $_POST['bag'];
		$mouse = $_POST['mouse'];
		$id = intval($_GET['id']);
        
		# Update database tbllaptops with new form data. 
		$sql = "update tbllaptops 
		set SerialNumber=:serialnumber,OwnerEmail=:emailid,LaptopTitle=:laptoptitle,LaptopBrand=:brandname,
		LaptopOverview=:laptopoverview,PricePerDay=:priceperday,Processor=:processor,Storage=:storage,RAM=:ram,
		Charger=:charger,Bag=:bag,Mouse=:mouse 
		where id=:id ";

		$query = $dbh->prepare($sql);
		$query->bindParam(':serialnumber', $serialnumber, PDO::PARAM_STR);
		$query->bindParam(':emailid', $emailid, PDO::PARAM_STR);
		$query->bindParam(':laptoptitle', $laptoptitle, PDO::PARAM_STR);
		$query->bindParam(':brandname', $brand, PDO::PARAM_STR);
		$query->bindParam(':laptopoverview', $laptopoverview, PDO::PARAM_STR);
		$query->bindParam(':priceperday', $priceperday, PDO::PARAM_STR);
		$query->bindParam(':processor', $processor, PDO::PARAM_STR);
		$query->bindParam(':storage', $storage, PDO::PARAM_STR);
		$query->bindParam(':ram', $ram, PDO::PARAM_STR);
		$query->bindParam(':charger', $charger, PDO::PARAM_STR);
		$query->bindParam(':bag', $bag, PDO::PARAM_STR);
		$query->bindParam(':mouse', $mouse, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();

		$msg = "Data updated successfully";
	}


?>

	<!DOCTYPE html>
	<html lang="en" class="no-js">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Geofrey Obara">
		<meta name="theme-color" content="#3e454c">

		<title>Laptop Rental Portal | Admin Edit User Details</title>

		<!-- Font awesome -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- Sandstone Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap Datatables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<!-- Bootstrap social button library -->
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<!-- Bootstrap select -->
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<!-- Bootstrap file input -->
		<link rel="stylesheet" href="css/fileinput.min.css">
		<!-- Awesome Bootstrap checkbox -->
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
		<!-- Admin Stye -->
		<link rel="stylesheet" href="css/style.css">
		<style>
			.errorWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #dd3d36;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}

			.succWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #5cb85c;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}
		</style>
	</head>

	<body>
		<?php include('includes/header.php'); ?>
		<div class="ts-main-content">
			<?php include('includes/leftbar.php'); ?>
			<div class="content-wrapper">
				<div class="container-fluid">

					<div class="row">
						<div class="col-md-12">

							<h2 class="page-title">Edit Laptop Details</h2>

							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading">Basic Info</div>
										<div class="panel-body">
											<?php if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
											<?php
											$id = intval($_GET['id']);
											$sql = "SELECT tbllaptops.*,tblbrands.BrandName,tblbrands.id as bid from tbllaptops join tblbrands on tblbrands.id=tbllaptops.LaptopBrand where tbllaptops.id=:id";
											$query = $dbh->prepare($sql);
											$query->bindParam(':id', $id, PDO::PARAM_STR);
											$query->execute();
											$results = $query->fetchAll(PDO::FETCH_OBJ);
											$cnt = 1;
											if ($query->rowCount() > 0) {
												foreach ($results as $result) {	?>

													<form method="post" class="form-horizontal" enctype="multipart/form-data">
														<div class="form-group">
															<label class="col-sm-2 control-label">Serial Number<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="serialnumber" class="form-control" value="<?php echo htmlentities($result->SerialNumber) ?>" required>
															</div>

															<label class="col-sm-2 control-label">Owner Email<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="email" name="emailid" class="form-control" value="<?php echo htmlentities($result->OwnerEmail) ?>" onBlur="checkAvailability()" readonly="readonly" required >
																<span id="user-availability-status" style="font-size:12px;"></span>
															</div>
														</div>
														<div class="hr-dashed"></div>
														<div class="form-group">
															<label class="col-sm-2 control-label">Laptop Title<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="laptoptitle" class="form-control" value="<?php echo htmlentities($result->LaptopTitle) ?>" required>
															</div>
															<label class="col-sm-2 control-label">Select Brand<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<select class="selectpicker" name="brandname" required>
																	<option value="<?php echo htmlentities($result->bid); ?>"><?php echo htmlentities($bdname = $result->BrandName); ?> </option>
																	<?php $ret = "select id,BrandName from tblbrands";
																	$query = $dbh->prepare($ret);
																	//$query->bindParam(':id',$id, PDO::PARAM_STR);
																	$query->execute();
																	$resultss = $query->fetchAll(PDO::FETCH_OBJ);
																	if ($query->rowCount() > 0) {
																		foreach ($resultss as $results) {
																			if ($results->BrandName == $bdname) {
																				continue;
																			} else { ?>
																				<option value="<?php echo htmlentities($results->id); ?>"><?php echo htmlentities($results->BrandName); ?></option>
																	<?php  }
																		}
																	} ?>

																</select>
															</div>
														</div>

														<div class="hr-dashed"></div>
														<div class="form-group">
															<label class="col-sm-2 control-label">Laptop Overview<span style="color:red">*</span></label>
															<div class="col-sm-10">
																<textarea class="form-control" name="laptopoverview" rows="3" required><?php echo htmlentities($result->LaptopOverview); ?></textarea>
															</div>
														</div>

														<div class="form-group">
															<label class="col-sm-2 control-label">Price/Day(in KSH)<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="priceperday" class="form-control" value="<?php echo htmlentities($result->PricePerDay); ?>" required>
															</div>
															<label class="col-sm-2 control-label">Processor<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="processor" class="form-control" value="<?php echo htmlentities($result->Processor); ?>" required>
															</div>
														</div>


														<div class="form-group">
															<label class="col-sm-2 control-label">Storage<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="storage" class="form-control" value="<?php echo htmlentities($result->Storage); ?>" required>
															</div>
															<label class="col-sm-2 control-label">RAM<span style="color:red">*</span></label>
															<div class="col-sm-4">
																<input type="text" name="ram" class="form-control" value="<?php echo htmlentities($result->RAM); ?>" required>
															</div>
														</div>

														<div class="hr-dashed"></div>
														<div class="form-group">
															<div class="col-sm-12">
																<h4><b>Laptop Images</b></h4>
															</div>
														</div>


														<div class="form-group">
															<div class="col-sm-4">
																Image 1 <img src="img/laptopimages/<?php echo htmlentities($result->Vimage1); ?>" width="300" height="200" style="border:solid 1px #000">
																<a href="changeimage1.php?imgid=<?php echo htmlentities($result->id) ?>">Change Image 1</a>
															</div>
															<div class="col-sm-4">
																Image 2<img src="img/laptopimages/<?php echo htmlentities($result->Vimage2); ?>" width="300" height="200" style="border:solid 1px #000">
																<a href="changeimage2.php?imgid=<?php echo htmlentities($result->id) ?>">Change Image 2</a>
															</div>
															<div class="col-sm-4">
																Image 3<img src="img/laptopimages/<?php echo htmlentities($result->Vimage3); ?>" width="300" height="200" style="border:solid 1px #000">
																<a href="changeimage3.php?imgid=<?php echo htmlentities($result->id) ?>">Change Image 3</a>
															</div>
														</div>

														<div class="form-group">
															<div class="col-sm-4">
																Image 4<img src="img/laptopimages/<?php echo htmlentities($result->Vimage4); ?>" width="300" height="200" style="border:solid 1px #000">
																<a href="changeimage4.php?imgid=<?php echo htmlentities($result->id) ?>">Change Image 4</a>
															</div>
														</div>
														<div class="hr-dashed"></div>
										</div>
									</div>
								</div>
							</div>



							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-heading">Accessories</div>
										<div class="panel-body">


											<div class="form-group">
												<div class="col-sm-3">
													<?php if ($result->Charger == 1) { ?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="charger" checked value="1">
															<label for="inlineCheckbox1"> Charger </label>
														</div>
													<?php } else { ?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="charger" value="1">
															<label for="inlineCheckbox1"> Charger </label>
														</div>
													<?php } ?>
												</div>

												<div class="col-sm-3">
													<?php if ($result->Bag == 1) { ?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="bag" checked value="1">
															<label for="inlineCheckbox2"> Bag </label>
														</div>
													<?php } else { ?>
														<div class="checkbox checkbox-success checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="bag" value="1">
															<label for="inlineCheckbox2"> Bag </label>
														</div>
													<?php } ?>
												</div>

												<div class="col-sm-3">
													<?php if ($result->Mouse == 1) { ?>
														<div class="checkbox checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="mouse" checked value="1">
															<label for="inlineCheckbox2"> Mouse </label>
														</div>
													<?php } else { ?>
														<div class="checkbox checkbox-success checkbox-inline">
															<input type="checkbox" id="inlineCheckbox1" name="mouse" value="1">
															<label for="inlineCheckbox2"> Mouse </label>
														</div>
													<?php } ?>
												</div>

												<div class="form-group">

											<?php
												}
											}
											?>

											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2">
													<button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Save changes</button>
												</div>
											</div>
												</div>

												</form>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>

			<!-- Loading Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/bootstrap-select.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script src="js/jquery.dataTables.min.js"></script>
			<script src="js/dataTables.bootstrap.min.js"></script>
			<script src="js/Chart.min.js"></script>
			<script src="js/fileinput.js"></script>
			<script src="js/chartData.js"></script>
			<script src="js/main.js"></script>
	</body>

	</html>
<?php } ?>