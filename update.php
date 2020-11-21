<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'classes/class.Crud2.php';

$db = new Crud();
if (isset($_GET)) {
    //extract($_GET);
    try {
        //$r = array();
        $res = $db->select('reg', "*", "", "id=" . $_GET["id"]); // Table name
        $r = $db->getResult() [0];

    }
    catch(PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }
}
if (isset($_POST["action"]) && $_POST["action"] == "update") {
    extract($_POST);
    try {
        unset($_POST['action']);
        unset($_POST['id']);
        $res = $db->update('reg', $_POST, 'id=' . $id); // Table name, column names and values, WHERE conditions
        if ($res) {
            $_SESSION["sql"] = $db->getSql();
            header("Location: ./");
        }
    }
    catch(PDOException $e) {
        echo "There is some problem in connection: " . $e->getMessage();
    }
}

?>

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
	
	</style>
</head>
	<div class="container py-5 px-4" >
		<div class="card" >
			<div class="card-body" >
			<form method="post" >
				<input type="hidden" name="action" value="update" >
				<input type="hidden" id="id" name="id" value="<?php echo $r["id"]; ?>" required>
				
				<div class="form-group mb-2" >
				<label for="name">Name</label>
				<input class="form-control" type="text" id="name" name="name" placeholder="Name" value="<?php echo $r["name"]; ?>" required>
				</div>
				
				<div class="form-group mb-2" >
				<label for="roll">Roll</label>
				<input class="form-control" type="number" id="roll" name="roll" placeholder="Roll" value="<?php echo $r["roll"]; ?>" required>
				</div>
				
				<input type="submit" class="btn btn-primary" >
			</form>
			</div>
		</div>
	</div>
	
<body>
	<!-- all vendors js file-->
	<script src="./assets/vendors/jquery/3.5.1/jquery.min.js"></script>
	<script src="./assets/vendors/jquery-ui/1.12.1/jquery-ui.min.js"></script>
	<script src="./assets/vendors/jquery-sticky/jquery.sticky.min.js"></script>
	<script src="./assets/vendors/bootstrap/5.0.0-alpha3/bootstrap.bundle.min.js"></script>
</script>
</body>

</html>