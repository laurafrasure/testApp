<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US"> 

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title> 
		Vehicle Information Database 
	</title>


	<style>
		.error {color: #FF0000;}
	</style>

	<!-- Include CSS for different screen sizes -->
	<link rel="stylesheet" type="text/css" href="defaultstyle.css">
</head>

<body>

<?php
	
	require 'connectToDatabase.php';

	// Connect to Azure SQL Database
	$conn = ConnectToDatabase();

	// Get the session data from the previously selected Expense Month, if it exists
	session_start();
	if ( !empty( $_SESSION['prevSelections'] ))
	{ 
		$prevSelections = $_SESSION['prevSelections'];
		unset ( $_SESSION['prevSelections'] );
	}

	// Extract previously-selected Month and Year
	$prevEndDate= $prevSelections['prevEndDate'];
?>

<div class="intro">

	<h2> Vehicle Information </h2>

</div>

<!-- Define web form. 
The array $_POST is populated after the HTTP POST method.
The PHP script insertToDb.php will be executed after the user clicks "Submit"-->
<div class="container">
	<form action="insertToDb.php" method="post">

		<label>Vehicle Date (1-31):</label>
		<input type="text" step="1" name="End_Date" required>

		<!-- Text input for make, remembering previously selected make -->
		<label>Vehicle Make:</label>
		<input type="text" step="1" name="Vehicle_Make" value="<?php echo $prevVehicleMake;  ?>" required><br>

		<!-- Text input for model, remembering previously selected model -->
		<label>Vehicle Model:</label>
		<input type="text" step="1" name="Vehicle_Model" value="<?php echo $prevVehicleModel;  ?>" required><br>

		<!-- Text input for Employee Name, remembering previously selected name -->
		<label>Name of Employees:</label>
		<input type="text" step="1" name="Name_Of_Employees" value="<?php echo $prevNameOfEmployees;  ?>" required><br>

		<button type="submit">Submit</button>
	</form>
</div>

<h3> Previous Input (if any) - for verification purposes:</h3>
<p> Vehicle Make: <?php echo $prevSelections['prevVehicleMake'] ?> </p>
<p> Vehicle Model: <?php echo $prevSelections['prevVehicleModel'] ?> </p>
<p> Start Date: <?php echo $prevSelections['prevStartDate'] ?> </p>
<p> End Date: <?php echo $prevSelections['prevEndDate'] ?> </p>
<p> Name Of Employees: <?php echo $prevSelections['prevNameOfEmployees'] ?> </p>

</body>
</html>