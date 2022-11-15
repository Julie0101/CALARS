<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	# Update page content

	if ($_POST['submit'] == "Update") {
		$pagetype = $_GET['type'];
		$pagedetails = $_POST['pgedetails'];
		$sql = "UPDATE tblpages SET detail=:pagedetails WHERE type=:pagetype";
		$query = $dbh->prepare($sql);
		$query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
		$query->bindParam(':pagedetails', $pagedetails, PDO::PARAM_STR);
		$query->execute();
		$msg = "Page data updated  successfully";
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

		<title>Laptop Rental Portal | Admin Create Brand</title>

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
		<script type="text/JavaScript"></script>

		<script type="text/javascript" src="nicEdit.js"></script>
		<script type="text/javascript">
			bkLib.onDomLoaded(function() {
				nicEditors.allTextAreas()
			});
		</script>

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

							<h2 class="page-title">Manage Pages </h2>

							<div class="row">
								<div class="col-md-10">
									<div class="panel panel-default">
										<div class="panel-heading">Form fields</div>
										<div class="panel-body">
											<form method="post" name="chngpwd" class="form-horizontal" onSubmit="return valid();">


												<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
												<div class="form-group">
													<label class="col-sm-4 control-label">select Page</label>
													<div class="col-sm-8">
														<select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
															<option value="" selected="selected" class="form-control">***Select One***</option>
															<option value="manage-pages.php?type=terms">terms and condition</option>
															<option value="manage-pages.php?type=privacy">privacy and policy</option>
															<option value="manage-pages.php?type=aboutus">aboutus</option>
															<option value="manage-pages.php?type=faqs">FAQs</option>
														</select>
													</div>
												</div>
												<div class="hr-dashed"></div>

												<div class="form-group">
													<label class="col-sm-4 control-label">selected Page</label>
													<div class="col-sm-8">
														<?php

														switch ($_GET['type']) {
															case "terms":
																echo "Terms and Conditions";
																break;

															case "privacy":
																echo "Privacy And Policy";
																break;

															case "aboutus":
																echo "About US";
																break;

															case "faqs":
																echo "FAQs";
																break;

															default:
																echo "";
																break;
														}

														?>
													</div>
												</div>

												<div class="form-group">
													<label class="col-sm-4 control-label">Page Details </label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="5" cols="50" name="pgedetails" id="pgedetails" placeholder="Package Details" required>
										                    <?php
										                    $pagetype = $_GET['type'];
										                    $sql = "SELECT detail from tblpages where type=:pagetype";
										                    $query = $dbh->prepare($sql);
										                    $query->bindParam(':pagetype', $pagetype, PDO::PARAM_STR);
										                    $query->execute();
										                    $results = $query->fetchAll(PDO::FETCH_OBJ);
										                    $cnt = 1;
										                    if ($query->rowCount() > 0) {
										                    	foreach ($results as $result) {
										                    		echo htmlentities($result->detail);
										                    	}
										                    }
										                    ?>

										                </textarea>
													</div>
												</div>

												<div class="form-group">
													<div class="col-sm-8 col-sm-offset-4">

														<button type="submit" name="submit" value="Update" id="submit" class="btn-primary btn">Update</button>
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