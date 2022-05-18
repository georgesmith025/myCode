<?php
session_start();
include("Databases.php");

if(!isset($_COOKIE["employeeIDCookie"])) {
	header("Location: /login.php");
}

//This will create shifts for the rest of the week and the following week

$currentDate = date('Y-m-d');
$todayDate = $currentDate;

$query = "SELECT shiftID FROM tblShifts WHERE (date < :date);";
	$result = $conn->prepare($query);
	$result->bindParam(":date", $currentDate);
	$result->execute();
	while ($rows = $result->fetch(PDO::FETCH_NUM))	{
		$shiftIDDelete = $rows[0];
		$query = "DELETE FROM tblEmployees_has_tblShifts WHERE (tblShifts_shiftID = :shiftIDDelete);";
		$resultDelete = $conn->prepare($query);
		$resultDelete->bindParam(":shiftIDDelete", $shiftIDDelete);
		$resultDelete->execute();
		
		$query = "SELECT tblTableBookings_tableBookingID FROM tblTableBookings_has_tblTables WHERE (tblTableBookings_tblShifts_shiftID = :shiftIDDelete);";
		$resultDelete = $conn->prepare($query);
		$resultDelete->bindParam(":shiftIDDelete", $shiftIDDelete);
		$resultDelete->execute();
		while ($rowsBooking = $resultDelete->fetch(PDO::FETCH_NUM))	{
			$tableBookingID = $rowsBooking[0];
			
			$query = "DELETE FROM tblTableBookings_has_tblTables WHERE tblTableBookings_tblShifts_shiftID = :shiftIDDelete";
			$resultDeleteTableBooking = $conn->prepare($query);
			$resultDeleteTableBooking->bindParam(":shiftIDDelete", $shiftIDDelete);
			$resultDeleteTableBooking->execute();
			
			$query = "DELETE FROM tblTableBookings WHERE (tableBookingID = :tableBookingID);";
			$resultDeleteTableBooking = $conn->prepare($query);
			$resultDeleteTableBooking->bindParam(":tableBookingID", $tableBookingID);
			$resultDeleteTableBooking->execute();
		}
		
		$query = "DELETE FROM tblShifts WHERE (shiftID = :shiftIDDelete);";
		$resultDelete = $conn->prepare($query);
		$resultDelete->bindParam(":shiftIDDelete", $shiftIDDelete);
		$resultDelete->execute();
	}

$currentDate = date('Y/m/d');

while (date('D', strtotime($currentDate)) <> 'Mon' or $currentDate < date('Y/m/d', strtotime($todayDate. ' + 9 days')))	{
	$nameOfDay = date('D', strtotime($currentDate));
	$query = "SELECT shiftID FROM tblShifts WHERE (date = :date AND time = '12:00');";
		$result = $conn->prepare($query);
		$result->bindParam(":date", $currentDate);
		$result->execute();
		$rows = $result->fetch(PDO::FETCH_NUM);
	if ($rows == False)		{
		$query = "INSERT INTO tblShifts (weekDay, date, time, peopleBooked) VALUES (:nameOfDay, :date, '12:00', 10);";
			$result = $conn->prepare($query);
			$result->bindParam(":nameOfDay", $nameOfDay);
			$result->bindParam(":date", $currentDate);
			$result->execute();
			
		$query = "SELECT LAST_INSERT_ID();";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$shiftID = $rows[0];
			
			$query = "SELECT tblTableBookings_tableBookingID FROM tblTableBookings_has_tblTables WHERE tblTableBookings_tblShifts_shiftID = :shiftID;";
				$result = $conn->prepare($query);
				$result->bindParam(":shiftID", $shiftID);
				$result->execute();
				$totalPeopleNumShift = 0;
			while ($rows = $result->fetch(PDO::FETCH_NUM))	{
				$query = "SELECT peopleNum FROM tblTableBookings WHERE tableBookingID = :tableBookingID;";
					$resultPeople = $conn->prepare($query);
					$resultPeople->bindParam(":tableBookingID", $rows[0]);
					$resultPeople->execute();
					$peopleNum = $resultPeople->fetch(PDO::FETCH_NUM);
					$totalPeopleNumShift += $peopleNum[0];
			}
			$totalPeopleNumShift += 10;
			$query = "UPDATE tblShifts SET peopleBooked = :peopleBooked WHERE shiftID = :shiftID;";
				$result = $conn->prepare($query);
				$result->bindParam(":shiftID", $shiftID);
				$result->bindParam(":peopleBooked", $totalPeopleNumShift);
				$result->execute();
			
	}	else	{
		$shiftID = $rows[0];
	}
	
	$query = "SELECT tblShifts_shiftID FROM tblEmployees_has_tblShifts WHERE tblShifts_shiftID = :shiftID;";
	$result = $conn->prepare($query);
	$result->bindParam(":shiftID", $shiftID);
	$result->execute();
	$rows = $result->fetch(PDO::FETCH_NUM);
	if ($rows AND $currentDate > date('Y/m/d', strtotime($todayDate. ' + 2 days')))	{
		$query = "DELETE FROM tblEmployees_has_tblShifts WHERE tblShifts_shiftID = :shiftID;";
		$result = $conn->prepare($query);
		$result->bindParam(":shiftID", $shiftID);
		$result->execute();
		$runInserts = True;
	}	elseif ($rows)	{
		$runInserts = False;
	}	else	{
		$runInserts = True;
	}
	
	if ($runInserts == True)	{
		$query = "SELECT weekDay, peopleBooked FROM tblShifts WHERE shiftID = :shiftID;";
			$result = $conn->prepare($query);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$weekDay = $rows[0];
			$peopleBooked = $rows[1];
		
		if ($weekDay == "Mon" or $weekDay == "Tue" or $weekDay == "Wed" or $weekDay == "Thu" or $weekDay == "Fri" or $weekDay == "Sat")	{
			//Selecting random employees from different jobs in order to fill the right amount for an afternoon shift on the above days
			//Two chefs, one waiter, one person behind the bar
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Chef' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Chef' AND employeeID <> :chefOneID) ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefTwoID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Waiter' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$waiterOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Bar' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$barOneID = $rows[0];
			
			//Inserting all these Employee IDs with the corresponding shift IDs
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefTwoID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefTwoID", $chefTwoID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterOneID", $waiterOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:barOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":barOneID", $barOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
		}	elseif ($weekDay == "Sun")	{
			//Selecting random employees from different jobs in order to fill the right amount for an afternoon shift on a Sunday (Sunday lunch shift)
			//Two chefs (3 if busy), two waiters (3 if busy), one person behind the bar, and a pot wash
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Chef' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Chef' AND employeeID <> :chefOneID) ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefTwoID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Waiter' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$waiterOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Waiter' AND employeeID <> :waiterOneID) ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterOneID", $waiterOneID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$waiterTwoID = $rows[0];
			
			if ($peopleBooked > 30)	{
				$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Chef' AND employeeID <> :chefOneID AND employeeID <> :chefTwoID) ORDER BY RAND ( )  LIMIT 1";
				$result = $conn->prepare($query);
				$result->bindParam(":chefOneID", $chefOneID);
				$result->bindParam(":chefTwoID", $chefTwoID);
				$result->execute();
				$rows = $result->fetch(PDO::FETCH_NUM);
				$chefThreeID = $rows[0];
				
				$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Waiter' AND employeeID <> :waiterOneID AND employeeID <> :waiterTwoID) ORDER BY RAND ( )  LIMIT 1";
				$result = $conn->prepare($query);
				$result->bindParam(":waiterOneID", $waiterOneID);
				$result->bindParam(":waiterTwoID", $waiterTwoID);
				$result->execute();
				$rows = $result->fetch(PDO::FETCH_NUM);
				$waiterThreeID = $rows[0];
			}
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Bar' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$barOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Pot wash' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$potwashOneID = $rows[0];
			
			//Inserting all these Employee IDs with the corresponding shift IDs
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefTwoID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefTwoID", $chefTwoID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			if ($peopleBooked > 30)	{
				$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefThreeID, :shiftID);";
				$result = $conn->prepare($query);
				$result->bindParam(":chefThreeID", $chefThreeID);
				$result->bindParam(":shiftID", $shiftID);
				$result->execute();
				
				$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterThreeID, :shiftID);";
				$result = $conn->prepare($query);
				$result->bindParam(":waiterThreeID", $waiterThreeID);
				$result->bindParam(":shiftID", $shiftID);
				$result->execute();
			}
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterOneID", $waiterOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterTwoID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterTwoID", $waiterTwoID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:barOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":barOneID", $barOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:potwashOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":potwashOneID", $potwashOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
		}
	}
		
	$query = "SELECT shiftID FROM tblShifts WHERE (date = :date AND time = '18:00');";
			$result = $conn->prepare($query);
			$result->bindParam(":date", $currentDate);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
		if ($rows == False)		{
			$query = "INSERT INTO tblShifts (weekDay, date, time, peopleBooked) VALUES (:nameOfDay, :date, '18:00', 10);";
				$result = $conn->prepare($query);
				$result->bindParam(":nameOfDay", $nameOfDay);
				$result->bindParam(":date", $currentDate);
				$result->execute();
				
			$query = "SELECT LAST_INSERT_ID();";
				$result = $conn->prepare($query);
				$result->execute();
				$rows = $result->fetch(PDO::FETCH_NUM);
				$shiftID = $rows[0];
			
			$query = "SELECT tblTableBookings_tableBookingID FROM tblTableBookings_has_tblTables WHERE tblTableBookings_tblShifts_shiftID = :shiftID;";
				$result = $conn->prepare($query);
				$result->bindParam(":shiftID", $shiftID);
				$result->execute();
				$totalPeopleNumShift = 0;
			while ($rows = $result->fetch(PDO::FETCH_NUM))	{
				$query = "SELECT peopleNum FROM tblTableBookings WHERE tableBookingID = :tableBookingID;";
					$resultPeople = $conn->prepare($query);
					$resultPeople->bindParam(":tableBookingID", $rows[0]);
					$resultPeople->execute();
					$peopleNum = $resultPeople->fetch(PDO::FETCH_NUM);
					$totalPeopleNumShift += $peopleNum[0];
			}
			$totalPeopleNumShift += 10;
			$query = "UPDATE tblShifts SET peopleBooked = :peopleBooked WHERE shiftID = :shiftID;";
				$result = $conn->prepare($query);
				$result->bindParam(":shiftID", $shiftID);
				$result->bindParam(":peopleBooked", $totalPeopleNumShift);
				$result->execute();
				
				
		}	else	{
			$shiftID = $rows[0];
		}
	
	$query = "SELECT tblShifts_shiftID FROM tblEmployees_has_tblShifts WHERE tblShifts_shiftID = :shiftID;";
	$result = $conn->prepare($query);
	$result->bindParam(":shiftID", $shiftID);
	$result->execute();
	$rows = $result->fetch(PDO::FETCH_NUM);
	if ($rows AND $currentDate > date('Y/m/d', strtotime($todayDate. ' + 2 days')))	{
		$query = "DELETE FROM tblEmployees_has_tblShifts WHERE tblShifts_shiftID = :shiftID;";
		$result = $conn->prepare($query);
		$result->bindParam(":shiftID", $shiftID);
		$result->execute();
		$runInserts = True;
	}	elseif ($rows)	{
		$runInserts = False;
	}	else	{
		$runInserts = True;
	}
		
	if ($runInserts == True)	{
		if ($peopleBooked > 40)	{
			//Selecting random employees from different jobs in order to fill the right amount for an afternoon shift on the above days
			//Three chefs, three waiter, one person behind the bar, one pot wash
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Chef' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Chef' AND employeeID <> :chefOneID) ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefTwoID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Chef' AND employeeID <> :chefOneID AND employeeID <> :chefTwoID) ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->bindParam(":chefTwoID", $chefTwoID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefThreeID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Waiter' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$waiterOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Waiter' AND employeeID <> :waiterOneID) ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterOneID", $waiterOneID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$waiterTwoID = $rows[0];
		
			$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Waiter' AND employeeID <> :waiterOneID AND employeeID <> :waiterTwoID) ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterOneID", $waiterOneID);
			$result->bindParam(":waiterTwoID", $waiterTwoID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$waiterThreeID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Bar' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$barOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Pot wash' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$potwashOneID = $rows[0];
			
			//Inserting all these Employee IDs with the corresponding shift IDs
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefTwoID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefTwoID", $chefTwoID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefThreeID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefThreeID", $chefThreeID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
				
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterOneID", $waiterOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterTwoID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterTwoID", $waiterTwoID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterThreeID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterThreeID", $waiterThreeID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:barOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":barOneID", $barOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:potwashOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":potwashOneID", $potwashOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
		
		}	elseif ($weekDay == "Mon" or $weekDay == "Tue" or $weekDay == "Wed" or $weekDay == "Thu" or $weekDay == "Sun")	{
			//Selecting random employees from different jobs in order to fill the right amount for an afternoon shift on the above days
			//Two chefs, one waiter, one person behind the bar
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Chef' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Chef' AND employeeID <> :chefOneID) ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefTwoID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Waiter' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$waiterOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Bar' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$barOneID = $rows[0];
			
			//Inserting all these Employee IDs with the corresponding shift IDs
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefTwoID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefTwoID", $chefTwoID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterOneID", $waiterOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:barOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":barOneID", $barOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
		}	elseif ($weekDay == "Fri" or $weekDay == "Sat")	{
			//Selecting random employees from different jobs in order to fill the right amount for an afternoon shift on a Sunday (Sunday lunch shift)
			//Two chefs (3 if busy), two waiters (3 if busy), one person behind the bar, and a pot wash
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Chef' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Chef' AND employeeID <> :chefOneID) ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$chefTwoID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Waiter' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$waiterOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Waiter' AND employeeID <> :waiterOneID) ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterOneID", $waiterOneID);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$waiterTwoID = $rows[0];
			
			if ($peopleBooked > 30)	{
				$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Chef' AND employeeID <> :chefOneID AND employeeID <> :chefTwoID) ORDER BY RAND ( )  LIMIT 1";
				$result = $conn->prepare($query);
				$result->bindParam(":chefOneID", $chefOneID);
				$result->bindParam(":chefTwoID", $chefTwoID);
				$result->execute();
				$rows = $result->fetch(PDO::FETCH_NUM);
				$chefThreeID = $rows[0];
				
				$query = "SELECT employeeID FROM tblEmployees WHERE (jobTitle = 'Waiter' AND employeeID <> :waiterOneID AND employeeID <> :waiterTwoID) ORDER BY RAND ( )  LIMIT 1";
				$result = $conn->prepare($query);
				$result->bindParam(":waiterOneID", $waiterOneID);
				$result->bindParam(":waiterTwoID", $waiterTwoID);
				$result->execute();
				$rows = $result->fetch(PDO::FETCH_NUM);
				$waiterThreeID = $rows[0];
			}
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Bar' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$barOneID = $rows[0];
			
			$query = "SELECT employeeID FROM tblEmployees WHERE jobTitle = 'Pot wash' ORDER BY RAND ( )  LIMIT 1";
			$result = $conn->prepare($query);
			$result->execute();
			$rows = $result->fetch(PDO::FETCH_NUM);
			$potwashOneID = $rows[0];
			
			//Inserting all these Employee IDs with the corresponding shift IDs
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefOneID", $chefOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefTwoID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":chefTwoID", $chefTwoID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			if ($peopleBooked > 30)	{
				$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:chefThreeID, :shiftID);";
				$result = $conn->prepare($query);
				$result->bindParam(":chefThreeID", $chefThreeID);
				$result->bindParam(":shiftID", $shiftID);
				$result->execute();
				
				$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterThreeID, :shiftID);";
				$result = $conn->prepare($query);
				$result->bindParam(":waiterThreeID", $waiterThreeID);
				$result->bindParam(":shiftID", $shiftID);
				$result->execute();
			}
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterOneID", $waiterOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:waiterTwoID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":waiterTwoID", $waiterTwoID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:barOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":barOneID", $barOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
			
			$query = "INSERT INTO tblEmployees_has_tblShifts (tblEmployees_employeeID, tblShifts_shiftID) VALUES (:potwashOneID, :shiftID);";
			$result = $conn->prepare($query);
			$result->bindParam(":potwashOneID", $potwashOneID);
			$result->bindParam(":shiftID", $shiftID);
			$result->execute();
		}
	}

	$currentDate = date('Y/m/d', strtotime($currentDate. ' + 1 days'));
} 

header("Location: /timetable.php");
?>