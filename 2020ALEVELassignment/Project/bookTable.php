<?php
	session_start();

	include("Databases.php");
	
	if(isset($_POST['submitTableBooking']))	{
		$surname = $_POST["surname"];
		$peopleNum = $_POST["peopleNum"];
		$date = $_POST["date"];
		$startTime = $_POST["startTime"];
		$endTime = date('H:i', strtotime($startTime. ' + 3 hours'));
		$currentDate = date('Y-m-d');
		
		if ($startTime > '12:00' AND $startTime < '15:00') 	{
			$shiftTime = '12:00';
		}	elseif	($startTime > '18:00' AND $startTime < '21:00') 	{
			$shiftTime = '18:00';
			}	
		
		if (($shiftTime == '12:00' OR $shiftTime == '18:00') AND ($date > date('Y-m-d', strtotime($currentDate. ' - 1 days'))))		{
			$query = "SELECT shiftID, peopleBooked FROM tblShifts WHERE (date = :date AND time = :shiftTime);";
			$result = $conn->prepare($query);
			$result->bindParam(":date", $date);
			$result->bindParam(":shiftTime", $shiftTime);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			
			if ($rows == True)	{
				$shiftID = $rows[0];
				$peopleBooked = $rows[1];
				$totalPeople = $peopleBooked + $peopleNum;
				
				$query = "UPDATE tblShifts SET peopleBooked = :peopleBooked WHERE shiftID = :shiftID;";
				$result = $conn->prepare($query);
				$result->bindParam(":shiftID", $shiftID);
				$result->bindParam(":peopleBooked", $totalPeople);
				$result->execute();
				
			}	else	{
				$nameOfDay = date('D', strtotime($date));
				$totalPeople = $peopleNum + 10;
					
				$query = "INSERT INTO tblShifts (weekDay, date, time, peopleBooked) VALUES (:nameOfDay, :date, :shiftTime, :peopleBooked);";
				$result = $conn->prepare($query);
				$result->bindParam(":nameOfDay", $nameOfDay);
				$result->bindParam(":date", $date);
				$result->bindParam(":shiftTime", $shiftTime);
				$result->bindParam(":peopleBooked", $totalPeople);
				$result->execute();	

				$query = "SELECT LAST_INSERT_ID();";
				$result = $conn->prepare($query);
				$result->execute();
				$rows = $result->fetch(PDO::FETCH_NUM);
				$shiftID = $rows[0];
			}
			
			$testTable = 1;
			while ($availableTableFound == False AND $testTable < 21)	 {
				$query = "SElECT tblTableBookings_tableBookingID FROM tblTableBookings_has_tblTables WHERE tblTables_tableNumber = :testTable;";
				$result = $conn->prepare($query);
				$result->bindParam(":testTable", $testTable);
				$result->execute();
				$testTableBookingID = $result->fetch(PDO::FETCH_NUM);
				
				if ($testTableBookingID)	{
					while($testTableBookingID == $result->fetch(PDO::FETCH_NUM)) {
						$query = "SElECT startTime, endTime FROM tblTableBookings WHERE tableBookingID = :testTableBookingID AND date = :date;";
						$result = $conn->prepare($query);
						$result->bindParam(":testTableBookingID", $testTableBookingID);
						$result->bindParam(":date", $date);
						$result->execute();
						$rows = $result->fetch(PDO::FETCH_NUM);
						
						if (!$rows OR $startTime < rows[0] and $endTime < rows[0] OR $startTime > rows[1])	{
								$availableTableFound = True;
						}
					}
					$testTable += 1;
				}
				else	{
					$availableTableFound = True;
				}
			}
			
			if ($availableTableFound == True)	{
				$query = "BEGIN;
					INSERT INTO tblTableBookings (surname, peopleNum, date, startTime, endTime, tblShifts_shiftID) VALUES (:surname, :peopleNum, :date, :startTime, :endTime, :shiftID);
					INSERT INTO tblTableBookings_has_tblTables VALUES (LAST_INSERT_ID(), :shiftID, :tableNumber);
				COMMIT;";
				
				$result = $conn->prepare($query);
				$result->bindParam(":surname", $surname);
				$result->bindParam(":peopleNum", $peopleNum);
				$result->bindParam(":date", $date);
				$result->bindParam(":startTime", $startTime);
				$result->bindParam(":endTime", $endTime);
				$result->bindParam(":shiftID", $shiftID);
				$result->bindParam(":tableNumber", $testTable);
				$result->execute();
				
				?>
				<script>
					alert("Booking made. Table number: " + <?php echo $testTable; ?>);
				</script>
				<?php
				
			} else	{
				?>
				<script>
					alert("Booking unavailable");
				</script
				<?php
			}
		}	else	{
			?>
			<script>
				alert("Invalid date/time");
			</script
			<?php
		}
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
		
		<div class = "container">
			<div class="container">
				<h1>
				Book a table
				</h1>
			</div>
			
			<div class="container">
				<form action="/bookTable.php" method="post">
					<div class="form-group">
						
					<div class="form-group">
						<label for="surname">Surname:</label>
						<input type="text" class="form-control-plaintext" placeholder="Surname" id="surname" name="surname">
					</div>
					
					<div class="form-group">
						<label for="peopleNum">How many people will be coming to the table :</label>
						<input type="number" min="1" max="20" class="form-control-plaintext" id="peopleNum" name="peopleNum">
					</div>
					
					<div class="form-group">
						<label for="date">Date:</label>
						<input type="date"	class="form-control-plaintext" id="date" name="date">
					</div>
					
					<div class="form-group">
						<label for="startTime">Time of arrival:</label>
						<input type="time" class="form-control-plaintext" id="startTime" name="startTime">
					</div>
					
					<button type="submit" class="btn btn-primary" name="submitTableBooking">Submit</button>
				</form>
			</div>
		</div>
	</body>
</html>