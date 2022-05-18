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
	
		<link rel="stylesheet" href="menuStyle.css">
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
			Menu
			</h1>
		</div>
		
		<div class="container">
			<form action="/foodMenu.php" method="post">
				<div class="form-group">
					<label for="menuCourse">Search by course:</label>
					<select class="form-control" id="menuCourse" name="menuCourse">
						<option value="*" >All</option>
						<option value="Starter" >Starter</option>
						<option value="Side" >Side</option>
						<option value="Main">Main</option>
						<option value="Dessert">Dessert</option>
						<option value="KMain">Kids menu</option>
						<option value="KDessert">Kids dessert</option>
					</select>
				</div>
				<div class="form-group">
					<label for="maxPrice">Max price:</label>
					<input type="number" class="form-control-plaintext" placeholder="0" min="0" max="20" id="maxPrice" name="maxPrice">
				</div>
				<button type="submit" class="btn btn-primary" name="menuCourseSearch">Search</button>
			</form>
		
			<?php
			if(isset($_POST['menuCourseSearch'])){
				$menuCourse = $_POST["menuCourse"];
				$maxPrice = $_POST["maxPrice"];
				if (!$maxPrice)	{
					$maxPrice = 20;
				}
			?>
			<div class = "container">
					<?php
					include("Databases.php");
						if ($menuCourse == "*")	{
							$query = "SELECT itemName, description, price, vegetarian FROM tblMenu WHERE price < :maxPrice ORDER BY itemID;";
						}	else	{
							$query = "SELECT itemName, description, price, vegetarian FROM tblMenu WHERE type = :menuCourse AND price < :maxPrice;";
						}
						$result = $conn->prepare($query);
						if (!($menuCourse == "*"))	{
							$result->bindParam(":menuCourse", $menuCourse);
						}
						$result->bindParam(":maxPrice", $maxPrice);
						$result->execute();
					?>
					<table>
						<tr>
							<th> Name </th>
							<th> Description </th>
							<th> Price </th>
							<th> Vegetarian </th>
						</tr>
						
						<?php  
							while($rows = $result->fetch(PDO::FETCH_NUM)) {
						?>	
						<tr>
							<td>
								<?php
								echo($rows[0]);
								?>
							</td>

							<td>
								<?php
								echo($rows[1]);
								?>
							</td>
							
							<td>
								<?php
								echo '£';
								echo($rows[2]);
								?>
							</td>
							
							<td>
								<?php
								if ($rows[3] == 1) {
								?>
									<p><span class="glyphicon glyphicon-leaf"></span></p>
								<?php 
								};
								?>
							</td>
						</tr>		
									
						<?php
							} 
						?>
					<table>
				</div>
			<?php
			}
			?>
		</div>
				
	</body>
</html>