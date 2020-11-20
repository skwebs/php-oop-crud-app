<!DOCTYPE html>
<html lang="en-IN">

<head prefix="og: https://ogp.me/ns# ">
	<title>:: Home | Anshu Memorial Academy ::</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2 shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="description" content="Anshu Memorial Academy CBSE Pattern Based an English Medium School from Std. Play to 8th.">
	<meta name="keywords" content="CBSE English School, Best CBSE School in Rajapakar Hajipur Vaishali, Play School, Anshu Memorial Academy School.">
	<meta name="theme-color" content="#0275d8">
	<!-- Required og tags -->
	<meta name="theme-color" content="#0275d8">
	<!-- all css vendors file-->
	<style type="text/css">

	</style>
	<link rel="stylesheet" href="./assets/vendors/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="./assets/vendors/bootstrap/5.0.0-alpha3/bootstrap.min.css" />
	<link rel="stylesheet" href="./assets/vendors/bootstrap/bs5-reset/bs5a2-remove.css" />
	<link rel="stylesheet" href="./assets/vendors/jquery-ui/1.12.1/jquery-ui.min.css">
	<!-- all css file-->
	<style type="text/css">
	.table {
		white-space: nowrap;
	}
	</style>
</head>

<body>
	<div class="container py-5">
		<div class="card">
			<div class="card-header text-center">
				<h2 class="card-title m-0">All Data</h2> </div>
			<div class="card-body ">
				<div class="table-responsive ">
					<table class="table p-2 table-striped border table-hover">
						<thead>
							<tr>
								<th scope="row" class="text-center">Action</th>
								<th scope="row">
									<input type="checkbox">
								</th>
								<th scope="row">Id_No.</th>
								<th scope="row">Name</th>
								<th scope="row">Roll</th>
								
							</tr>
						</thead>
						<tbody>
							<?php
						error_reporting(E_ALL);ini_set("display_errors", 1);
							include_once 'classes/class.Crud2.php';
							
							try {
							    $db = new Crud();
							
							    /*
							     * Select *
							     */
							    //select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null) {
							    $res = $db->select('reg',"*","","","id"); // Table name
							    foreach($db->getResult() as $r ){
								    echo '<tr>
									    <td class="btn-group">
										    <a class="btn btn-outline-primary" href="update.php?action=update&id='.$r["id"].'" > 
											    <i class="fa fa-pencil"></i>
										    </a>
										    <a class="btn btn-outline-danger" href="delete.php?id='.$r["id"].'" >
											    <i class="fa fa-trash"></i>
										    </a>
									    </td>
									    <td><input type="checkbox" ></td>
									    <td>'.$r["id"].'</td>
									    <td>'.$r["name"].'</td>
									    <td>'.$r["roll"].'</td>
								    </tr>';
							    };
							    
							} catch (PDOException $e) {
							    echo "There is some problem in connection: " . $e->getMessage();
							}
							
						?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer"> <a href="./add-student.html" class="btn btn-primary">Add Student</a> </div>
		</div>
	</div>
	<!-- all vendors js file-->
	<script src="./assets/vendors/jquery/3.5.1/jquery.min.js"></script>
	<script src="./assets/vendors/jquery-ui/1.12.1/jquery-ui.min.js"></script>
	<script src="./assets/vendors/jquery-sticky/jquery.sticky.min.js"></script>
	<script src="./assets/vendors/bootstrap/5.0.0-alpha3/bootstrap.bundle.min.js"></script>
</body>

</html>