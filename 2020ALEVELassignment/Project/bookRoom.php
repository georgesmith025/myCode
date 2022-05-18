<?php
	session_start();

	include("Databases.php");
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
		
		<link rel="stylesheet" href="menuStyle.css">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
			<div class="container">
				<h1>
				Book a room
				</h1>
			</div>
			
			<div class = "w3-container">
				<table class="w3-table">
					<tr>
						<th> Room number </th>
						<th> Description </th>
						<th> Max amount of people </th>
						<th> Price per night </th>
					</tr>
					
					<?php
					for($i=1; $i<=5; $i++){
						include("Databases.php");
						$query = "SELECT roomNumber, roomType, maxCapacity, pricePerNight FROM tblRooms WHERE roomNumber = :i;";
						$result = $conn->prepare($query);
						$result->bindParam(":i", $i);
						$result->execute();
					?>
					
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
								echo($rows[2]);
								?>
							</td>
							
							<td>
								<?php
								echo(£);
								echo($rows[3]);
								?>
							</td>
						</tr>			
					<?php
							}
					}
					?>
				</table>
			</div>
			
			<div class="container">
				<form action="/bookRoom.php" method="post">
				
					<div class="form-group">
						<label for="roomNumber">Which room would you like to book? :</label>
						<input type="number" min="1" max="5" class="form-control-plaintext" id="roomNumber" name="roomNumber">
					</div>
					
					<div class="form-group">
						<label for="startDate">Date of arrival:</label>
						<input type="date" class="form-control-plaintext" id="startDate" name="startDate">
					</div>
					
					<div class="form-group">
						<label for="endDate">Date you will be leaving:</label>
						<input type="date" class="form-control-plaintext" id="endDate" name="endDate">
					</div>
					
					<div class="form-group">
						<label for="peopleNumber">How many people will be staying in this room? :</label>
						<input type="number" min="1" max="4" class="form-control-plaintext" id="peopleNumber" name="peopleNumber">
					</div>
					
					<div class="form-group">
						<label for="firstName">First name:</label>
						<input type="text" class="form-control-plaintext" placeholder="First name" id="firstName" name="firstName">
					</div>
					
					<div class="form-group">
						<label for="surname">Second name:</label>
						<input type="text" class="form-control-plaintext" placeholder="Second name" id="surname" name="surname">
					</div>	
								
					<div class="form-group">
						<label for="email">Email address:</label>
						<input type="email" class="form-control-plaintext" placeholder="Email" id="email" name="email">
					</div>	
								
					<div class="form-group">
						<label for="phoneNumber">Phone number:</label>
						<input type="int" class="form-control-plaintext" placeholder="Phone number" id="phoneNumber" name="phoneNumber">
					</div>
					
					<button type="submit" class="btn btn-primary" name="submitRoomBooking">Submit</button>
				</form>
			</div>
			
			<?php
			if(isset($_POST['submitRoomBooking']))	{
				$firstName = $_POST["firstName"];
				$surname = $_POST["surname"];
				$email = $_POST["email"];
				$phoneNumber = $_POST["phoneNumber"];
				
				$roomNumber = $_POST["roomNumber"];
				$startDate = $_POST["startDate"];
				$endDate = $_POST["endDate"];
				$peopleNumber = $_POST["peopleNumber"];
				
				if ($startDate <= $endDate AND $endDate < date('Y-m-d', strtotime($startDate. ' + 7 days')))	{
					$query = "SELECT roomNumber FROM tblRooms WHERE (roomNumber = :roomNumber AND :peopleNumber > maxCapacity)";
					$result = $conn->prepare($query);
					$result->bindParam(":roomNumber", $roomNumber);
					$result->bindParam(":peopleNumber", $peopleNumber);
					$result->execute();
					$rows = $result->fetch(PDO::FETCH_NUM);
					
					if ($rows == False) {
						$tableBookingFound = False;
						
						$query = "SELECT startDate, endDate FROM tblRoomBookings WHERE tblRooms_roomNumber = :roomNumber;";
						$result = $conn->prepare($query);
						$result->bindParam(":roomNumber", $roomNumber);
						$result->execute();
						
						while ($rows = $result->fetch(PDO::FETCH_NUM))	{
							$testStartDate = $rows[0];
							$testEndDate = $rows[1];
							echo $testStartDate;
							echo $testEndDate;
							
							if (($startDate < $testStartDate or $startDate > $testEndDate) and ($endDate < $testStartDate))		{
							$tableBookingFound = True;
							}
						}
						
						$query = "SELECT startDate, endDate FROM tblRoomBookings WHERE tblRooms_roomNumber = :roomNumber;";
						$result = $conn->prepare($query);
						$result->bindParam(":roomNumber", $roomNumber);
						$result->execute();
						$rows = $result->fetch(PDO::FETCH_NUM);
						if ($rows == False)	{
							$tableBookingFound = True;
						}
						
						if ($tableBookingFound == True)		{
							$query = "BEGIN;
							INSERT INTO tblCustomerDetails (firstName, surname, email, phoneNumber) VALUES (:firstName, :surname, :email, :phoneNumber); 
							INSERT INTO tblRoomBookings (peopleNumber, startDate, endDate, tblRooms_roomNumber, tblCustomerDetails_CustomerID) VALUES (:peopleNumber, :startDate, :endDate, :roomNumber, LAST_INSERT_ID());
							COMMIT;";
							$result = $conn->prepare($query);
							$result->bindParam(":firstName", $firstName);
							$result->bindParam(":surname", $surname);
							$result->bindParam(":email", $email);
							$result->bindParam(":phoneNumber", $phoneNumber);
							
							$result->bindParam(":peopleNumber", $peopleNumber);
							$result->bindParam(":startDate", $startDate);
							$result->bindParam(":endDate", $endDate);
							$result->bindParam(":roomNumber", $roomNumber);
							$result->execute();
							
						}	else	{
							?>
							<script>
								alert("The room you have selected is not available");
							</script
							<?php
						}
					}	else	{
						?>
						<script>
							alert("The room you have selected is not available");
						</script
						<?php
					}
				}	else	{
					?>
					<script>
						alert("Error! Invalid dates");
					</script
					<?php
				}
			}
			?>
			
		</body>
	</div>
</html>