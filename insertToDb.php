<?php


 
	// PHP script used to connect to backend Azure SQL database
	require 'ConnectToDatabase.php';

	// Start session for this particular PHP script execution.
	session_start();

	// Define variables and set to empty values
	$VehicleMake = $VehicleModel = $StartDate = $EndDate = $NameOfEmployees = NULL;

	// Get input variables
	$VehicleMake= (varchar(255)) ($_POST['Vehicle_Make']);
	$VehicleModel= (varchar(255)) ($_POST['Vehicle_Model']);
	$StartDate= (date) ($_POST['Start_Date']);
	$EndDate= (date) ($_POST['End_Date']);
	$NameOfEmployees= (varchar(255)) ($_POST['Name_Of_Employees']);

	// Get the authentication claims stored in the Token Store after user logins using Azure Active Directory
	$claims= json_decode($_SERVER['MS_CLIENT_PRINCIPAL'])->claims;
	foreach($claims as $claim)
	{		
		if ( $claim->typ == "http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress" )
		{
			$userEmail= $claim->val;
			break;
		}
	}

	///////////////////////////////////////////////////////
	//////////////////// INPUT VALIDATION /////////////////
	///////////////////////////////////////////////////////

	//Initialize variable to keep track of any errors
	$anyErrors= TRUE;


	///////////////////////////////////////////////////////
	////////// INPUT PARSING AND WRITE TO SQL DB //////////
	///////////////////////////////////////////////////////

	// Only input information into database if there are no errors
	if ( $anyErrors ) 
	{

		// Connect to Azure SQL Database
		$conn = ConnectToDatabase();

		// Build SQL query to insert new expense data into SQL database
		$tsql=
		"INSERT INTO SangriaWine (	
				VehicleMake,
				VehicleModel,
				StartDate,
				EndDate,
				NameOfEmployees,
				)
		VALUES ('" . $userEmail . "',
				'" . $VehicleMake . "',
				'" . $VehicleModel . "', 
				'" . $StartDate . "', 
				'" . $EndDate . "', 
				'" . $NameOfEmployees . "')";

		// Run query
		$sqlQueryStatus= sqlsrv_query($conn, $tsql);

		// Close SQL database connection
		sqlsrv_close ($conn);
	}

	// Initialize an array of previously-posted info
	$prevSelections = array();

	// Populate array with key-value pairs
	$prevSelections['prevVehicleMake']= $VehicleMake;
	$prevSelections['prevVehicleModel']= $VehicleModel;
	$prevSelections['prevStartDate']= $StartDate;
	$prevSelections['prevEndDate']= $EndDate;
	$prevSelections['prevNameOfEmployee']= $NameOfEmployees;

	// Store previously-selected data as part of info to carry over after URL redirection
	$_SESSION['prevSelections'] = $prevSelections;

	/* Redirect browser to home page */
	header("Location: /"); 
?>