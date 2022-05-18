<?php
	session_start();

	$employeeID = $_POST["name"];
	if(!isset($_COOKIE["employeeIDCookie"])) {
	header("Location: /login.php");}
	
	if(isset($_POST['submit'])){
		$name = $_POST["name"];
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$jobTitle = $_POST["jobTitle"];
		$email = $_POST["email"];
		include("Databases.php");
		
		$query = "INSERT INTO tblEmployees (name, jobTitle, password, email) VALUES (:name, :jobTitle, :password, :email);";
		$result = $conn->prepare($query);
		$result->bindParam(":name", $name);
		$result->bindParam(":password", $password);
		$result->bindParam(":jobTitle", $jobTitle);
		$result->bindParam(":email", $email);
		$result->execute();
	
		$query = "SELECT employeeID FROM tblEmployees WHERE name = :name AND jobTitle = :jobTitle AND password = :password AND email = :email";
		$result = $conn->prepare($query);
		$result->bindParam(":name", $name);
		$result->bindParam(":password", $password);
		$result->bindParam(":jobTitle", $jobTitle);
		$result->bindParam(":email", $email);
		$result->execute();
		$rows = $result->fetch(PDO::FETCH_NUM);
		
		?>
		<script>
			alert("This employee's ID number is " + <?php echo $rows[0]; ?>);
		</script
		<?php
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

			<form action="/register.php" method="post">
					
				<div class="form-group">
					<label for="name">Name:</label>
					<input type="text" class="form-control-plaintext" placeholder="Name" id="name" name="name">
				</div>
	  
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" class="form-control-plaintext" placeholder="Password" id="password" name="password">
				</div>
				
				<div class="form-group">
					<label for="jobTitle">Job:</label>
					<select class="form-control" id="jobTitle" name="jobTitle">
						<option>Boss</option>
						<option>Chef</option>
						<option>Bar</option>
						<option>Waiter</option>
						<option>Pot wash</option>
						<option>Other</option>
					</select>
				</div>
				
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" class="form-control-plaintext" placeholder="Email" id="email" name="email">
				</div>
				
				<button type="submit" class="btn btn-primary" name="submit">Submit</button>
			</form>
			
			<form method="get" action="/timetable.php">
				<button type="submit">Back to timetable</button>
			</form>
		</div>

	</body>
	
</html>