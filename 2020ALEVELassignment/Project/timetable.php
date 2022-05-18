<?php
	session_start();
	include("Databases.php");
	
	if(!isset($_COOKIE["employeeIDCookie"])) {
		header("Location: /login.php");
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
							<a class="nav-link" href="logout.php" style="color: #ffffff;">Logout <span class="glyphicon glyphicon-log-out"></span></a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="container">
			<?php

			$employeeID = ($_COOKIE["employeeIDCookie"]);

			$query = "SELECT name, jobTitle FROM tblEmployees WHERE employeeID = :employeeID;";
			$result = $conn->prepare($query);
			$result->bindParam(":employeeID", $employeeID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$jobTitle = $rows[1];

			if ($jobTitle == 'Boss')	{
				?>
				<div class="container">
					<div class="row">
						<div class="column" style="width: 50%; padding: 16px 32px;">
							<form method="get" action="/register.php">
								<button type="submit">Register a new employee</button>
							</form>
						</div>
						<div class="column" style="width: 50%; padding: 16px 32px;">
							<form method="get" action="/generateShifts.php">
								<button type="submit">Generate shifts for the next week and week after</button>
							</form>
						</div>
					</div>
				</div>
				
				<br>
				<h1> Shifts </h1>
				
				<div class="w3-container">
					<?php
						$query = "SELECT shiftID, weekDay, date, time, peopleBooked FROM tblShifts;";
						$result = $conn->prepare($query);
						$result->execute();
					?>
					<table class="w3-table">
						<tr>
							<th> Day </th>
							<th> Date </th>
							<th> Time </th>
							<th> People predicted </th>
							<th> Staff (ID)</th>
						</tr>
						
						<?php  
							while($rows = $result->fetch(PDO::FETCH_NUM)) {
								$shiftID = $rows[0];
						?>	
						<tr>
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
								echo($rows[3]);
								?>
							</td>
							
							<td>
								<?php
								echo($rows[4]);
								?>
							</td>
							
							<td>
								<?php
									$query = "SELECT tblEmployees_employeeID FROM tblEmployees_has_tblShifts WHERE tblShifts_shiftID = :shiftID;";
									$resultNames = $conn->prepare($query);
									$resultNames->bindParam(":shiftID", $shiftID);
									$resultNames->execute();
									while($rowsNames = $resultNames->fetch(PDO::FETCH_NUM)) {
										$employeeIDNames = $rowsNames[0];
										$query = "SELECT name FROM tblEmployees WHERE employeeID = :employeeID;";
										$resultEmployeeNames = $conn->prepare($query);
										$resultEmployeeNames->bindParam(":employeeID", $employeeIDNames);
										$resultEmployeeNames->execute();
										$rowsEmployeeNames= $resultEmployeeNames->fetch(PDO::FETCH_NUM);
										echo ($rowsEmployeeNames[0] . ' ('. $employeeIDNames .'), ');
									}
								?>
							</td>
						</tr>		
						<?php
							} 
						?>
					</table>
				</div>
				
				<br>
				<h1> Table bookings </h1>
				
				<div class="w3-container">
					<?php
						$query = "SELECT surname, peopleNum, date, startTime FROM tblTableBookings;";
						$result = $conn->prepare($query);
						$result->execute();
					?>
					<table class="w3-table">
						<tr>
							<th> Surname </th>
							<th> Number of people </th>
							<th> Date </th>
							<th> Start time </th>
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
								echo($rows[2]);
								?>
							</td>
							
							<td>
								<?php
								echo($rows[3]);
								?>
							</td>
						</tr>		
						<?php
							} 
						?>
					</table>
				</div>
				
				<br>
				<h1> Room bookings </h1>
				
				<div class="w3-container">
					<?php
						$query = "SELECT CustomerID, firstName, surname, email, phoneNumber FROM tblCustomerDetails;";
						$result = $conn->prepare($query);
						$result->execute();
					?>
					<table class="w3-table">
						<tr>
							<th> Resident name </th>
							<th> Email </th>
							<th> Phone number </th>
							<th> Number of residents </th>
							<th> Start date </th>
							<th> End date </th>
							<th> Room number </th>
						</tr>
						
						<?php  
							while($rows = $result->fetch(PDO::FETCH_NUM)) {
						?>	
						<tr>
							<td>
								<?php
								echo($rows[1] . ' ' . $rows[2]);
								?>
							</td>

							<td>
								<?php
								echo($rows[3]);
								?>
							</td>
							
							<td>
								<?php
								echo($rows[4]);
								?>
							</td>
							
							<?php
								$query = "SELECT peopleNumber, startDate, endDate, tblRooms_roomNumber FROM tblRoomBookings WHERE tblCustomerDetails_CustomerID = :customerID;";
								$resultRooms = $conn->prepare($query);
								$resultRooms->bindParam(":customerID", $rows[0]);
								$resultRooms->execute();
								$rowsRooms = $resultRooms->fetch(PDO::FETCH_NUM);
							?>
							
							<td>
								<?php
								echo($rowsRooms[0]);
								?>
							</td>
							
							<td>
								<?php
								echo($rowsRooms[1]);
								?>
							</td>
							
							<td>
								<?php
								echo($rowsRooms[2]);
								?>
							</td>
							
							<td>
								<?php
								echo($rowsRooms[3]);
								?>
							</td>
						</tr>		
						<?php
							} 
						?>
					</table>
				</div>
				
				<br>
			<?php
			}	elseif ($jobTitle == 'Chef' or $jobTitle == 'Bar')	{
			?>
			
				<div class="container">
					<div class="row">
						<div class="column" style="width: 50%; padding: 16px 32px;">
							<form method="get" action="/generateShifts.php">
								<button type="submit">Generate shifts for the next week and week after</button>
							</form>
						</div>
					</div>
				</div>
			
				<br>
				<h1> Shifts </h1>
			
				<div class="w3-container">
					
						<?php 
						$query = "SELECT tblShifts_shiftID FROM tblEmployees_has_tblShifts WHERE tblEmployees_employeeID = :employeeID;";
						$result = $conn->prepare($query);
						$result->bindParam(":employeeID", $employeeID);
						$result->execute();
						?>
					<table class="w3-table">
						<tr>
							<th> Day </th>
							<th> Date </th>
							<th> Time </th>
							<th> People predicted </th>
							<th> Staff (ID)</th>
						</tr>
						<?php
						while ($rows = $result->fetch(PDO::FETCH_NUM))	{
							$shiftID = $rows[0];
							$query = "SELECT weekDay, date, time, peopleBooked FROM tblShifts WHERE shiftID = :shiftID";
							$resultShift = $conn->prepare($query);
							$resultShift->bindParam(":shiftID", $shiftID);
							$resultShift->execute();
							while($shiftRows = $resultShift->fetch(PDO::FETCH_NUM)) {
						?>
					
						<tr>
							<td>
								<?php
								echo($shiftRows[0]);
								?>
							</td>

							<td>
								<?php
								echo($shiftRows[1]);
								?>
							</td>
							
							<td>
								<?php
								echo($shiftRows[2]);
								?>
							</td>
							
							<td>
								<?php
								echo($shiftRows[3]);
								?>
							</td>
							
							<td>
								<?php
									$query = "SELECT tblEmployees_employeeID FROM tblEmployees_has_tblShifts WHERE tblShifts_shiftID = :shiftID;";
									$resultNames = $conn->prepare($query);
									$resultNames->bindParam(":shiftID", $shiftID);
									$resultNames->execute();
									while($rowsNames = $resultNames->fetch(PDO::FETCH_NUM)) {
										$employeeIDNames = $rowsNames[0];
										$query = "SELECT name FROM tblEmployees WHERE employeeID = :employeeID;";
										$resultEmployeeNames = $conn->prepare($query);
										$resultEmployeeNames->bindParam(":employeeID", $employeeIDNames);
										$resultEmployeeNames->execute();
										$rowsEmployeeNames= $resultEmployeeNames->fetch(PDO::FETCH_NUM);
										echo ($rowsEmployeeNames[0] . ' ('. $employeeIDNames .'), ');
									}
								?>
							</td>
						</tr>		
									
						<?php
							}
						}
						?>
					<table>
				</div>
				
				<br>
				<h1> Table bookings </h1>
				
				<div class="w3-container">
					<?php
						$query = "SELECT surname, peopleNum, date, startTime FROM tblTableBookings;";
						$result = $conn->prepare($query);
						$result->execute();
					?>
					<table class="w3-table">
						<tr>
							<th> Surname </th>
							<th> Number of people </th>
							<th> Date </th>
							<th> Start time </th>
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
								echo($rows[2]);
								?>
							</td>
							
							<td>
								<?php
								echo($rows[3]);
								?>
							</td>
						</tr>		
						<?php
							} 
						?>
					</table>
				</div>
				
				<br>
			<?php
				}	else	{
			?>
			
				<br>
				<h1> Shifts </h1>
				
				<div class="w3-container">
					
						<?php 
						$query = "SELECT tblShifts_shiftID FROM tblEmployees_has_tblShifts WHERE tblEmployees_employeeID = :employeeID;";
						$result = $conn->prepare($query);
						$result->bindParam(":employeeID", $employeeID);
						$result->execute();
						?>
					<table class="w3-table">
						<tr>
							<th> Day </th>
							<th> Date </th>
							<th> Time </th>
							<th> People predicted </th>
							<th> Staff (ID)</th>
						</tr>
						<?php
						while ($rows = $result->fetch(PDO::FETCH_NUM))	{
							$shiftID = $rows[0];
							$query = "SELECT weekDay, date, time, peopleBooked FROM tblShifts WHERE shiftID = :shiftID";
							$resultShift = $conn->prepare($query);
							$resultShift->bindParam(":shiftID", $shiftID);
							$resultShift->execute();
							while($shiftRows = $resultShift->fetch(PDO::FETCH_NUM)) {
						?>
					
						<tr>
							<td>
								<?php
								echo($shiftRows[0]);
								?>
							</td>

							<td>
								<?php
								echo($shiftRows[1]);
								?>
							</td>
							
							<td>
								<?php
								echo($shiftRows[2]);
								?>
							</td>
							
							<td>
								<?php
								echo($shiftRows[3]);
								?>
							</td>
							
							<td>
								<?php
									$query = "SELECT tblEmployees_employeeID FROM tblEmployees_has_tblShifts WHERE tblShifts_shiftID = :shiftID;";
									$resultNames = $conn->prepare($query);
									$resultNames->bindParam(":shiftID", $shiftID);
									$resultNames->execute();
									while($rowsNames = $resultNames->fetch(PDO::FETCH_NUM)) {
										$employeeIDNames = $rowsNames[0];
										$query = "SELECT name FROM tblEmployees WHERE employeeID = :employeeID;";
										$resultEmployeeNames = $conn->prepare($query);
										$resultEmployeeNames->bindParam(":employeeID", $employeeIDNames);
										$resultEmployeeNames->execute();
										$rowsEmployeeNames= $resultEmployeeNames->fetch(PDO::FETCH_NUM);
										echo ($rowsEmployeeNames[0] . ' ('. $employeeIDNames .'), ');
									}
								?>
							</td>
						</tr>	
									
						<?php
							}
						}
						?>
					<table>
				</div>
				
				<br>
			<?php
				}
			?>
		</div>
	</body>
</html>