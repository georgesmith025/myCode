<?php
session_start();

	if(isset($_POST['submit'])){
		$employeeID = $_POST["employeeID"];
		$name = $_POST["name"];
		$password = $_POST["password"];

		include("Databases.php");
		$query = "SELECT name, password FROM tblEmployees WHERE employeeID = :employeeID;";
		$result = $conn->prepare($query);
		$result->bindParam(":employeeID", $employeeID);
		$result->execute();
		$rows = $result->fetch(PDO::FETCH_NUM);
		$hash = $rows[1];	
		
		if($rows[1] AND password_verify($password, $hash)){
			$_SESSION["employeeID"] = $_POST["employeeID"];
			setcookie("employeeIDCookie", $employeeID, time() + (86400 * 30), "/");
			header("Location: /timetable.php");
		} else {
			?>
				<script>
					alert("Invalid login");
				</script
			<?php
		}
	}
	if($_COOKIE["employeeIDCookie"] != ""){
		header("Location: /timetable.php");
	}
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		
		<meta name="viewport" content="width=device-width, initial-scale=1"> <!--make it "responsive" !-->
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	</head>
	
	<body>
		<div class="container sticky">
			<nav class="navbar navbar-expand-sm" style="background: #343a40;">
			 <!-- Toggler/collapsibe Button -->
			  <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			  </button>

				 <div class="collapse navbar-collapse" id="collapsibleNavbar">
				<!-- Links -->
					<ul class="navbar-nav nav-fill w-100">
						<li class="nav-item">
							<a class="nav-link" href="index.php" style="color: #ffffff;">Home <span class="glyphicon glyphicon-home"></span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="foodMenu.php" style="color: #ffffff;">Menu <span class="glyphicon glyphicon-cutlery"></span></a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" style="color: #ffffff;">
							Online booking <span class="glyphicon glyphicon-book"></span>
							</a>
							<div class="dropdown-menu" style="background: #343333;">
								<a class="dropdown-item" href="bookTable.php" style="color: #ffffff;"> <span class="glyphicon glyphicon-menu-right"></span> Table</a>
								<a class="dropdown-item" href="bookRoom.php" style="color: #ffffff;"> <span class="glyphicon glyphicon-menu-right"></span> Room</a>
							</div>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="aboutus.php" style="color: #ffffff;">About us <span class="glyphicon glyphicon-info-sign"></span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="login.php" style="color: #ffffff;">Login <span class="glyphicon glyphicon-log-in"></span></a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
		
		<div class="container">
			<h1>
			Login
			</h1>
		</div>
		
		<div class="container">
				<form action="/login.php" method="post">
					
					<div class="form-group">
						<label for="employeeID">ID number:</label>
						<input type="number" min="1" class="form-control-plaintext" placeholder="0" id="employeeID" name="employeeID">
					</div>
					
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" class="form-control-plaintext" placeholder="Name" id="name" name="name">
					</div>

					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" class="form-control-plaintext" placeholder="Password" id="password" name="password">
					</div>
					
					<button type="submit" class="btn btn-primary" name="submit">Submit</button>
				</form>
		</div>
	</body>
</html>