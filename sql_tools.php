<?php

require_once('sql_passwords.php');

function readSQL($YOUR_DATABASE_NAME, $sqlStr, $convertRowsToArrays=TRUE) {
    global $SQL_READER_PASS;
    // create SQL connection
    $conn = mysqli_connect("localhost", $SQL_READER_PASS[0], $SQL_READER_PASS[1], $YOUR_DATABASE_NAME); // don't forget to add your own SQL sign-in info
    if ($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    // run sql
    $result = mysqli_query($conn, $sqlStr);
    // loop to store the data in an associative array.
    $out = array();
    $index = 0;
    while ($row = mysqli_fetch_assoc($result)) {
    	if ($convertRowsToArrays) {
        	$out[$index] = array_values($row);
        } else {
        	$out[$index] = $row;
        }
        $index++;
    }
    //close and return
    mysqli_close($conn);
    return $out;
}
function writeSQL($YOUR_DATABASE_NAME, $sqlStr) {
    global $SQL_WRITER_PASS;
    // create SQL connection
    $conn = mysqli_connect("localhost", $SQL_WRITER_PASS[0], $SQL_WRITER_PASS[1], $YOUR_DATABASE_NAME); // don't forget to add your own SQL sign-in info
    if ($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    // send the query and return result
    $out = mysqli_query($conn, $sqlStr);
    // close connection
    mysqli_close($conn);
	return $out;
}

function updateTableRowFromArray($YOUR_DATABASE_NAME, $tableName, $rowSelector, $arr, $debug=false) {
	// get a list of the names of each column
	$tableHeaders = readSQL($YOUR_DATABASE_NAME, "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$YOUR_DATABASE_NAME."' AND TABLE_NAME = '".$tableName."'");
	
	// create a sql writing string
	$dontUpdateTheseCols = ['Referral Type', 'id', 'Date and Time']; // list of column names that you do not want to allow access to edit (for security reasons)
	$writeThis = array();
	for ($i = 0; $i < count($tableHeaders); $i++) {
    	if (in_array($tableHeaders[$i][0], $dontUpdateTheseCols) || $arr[$i]==NULL) {
        	continue;
        }
 		array_push($writeThis, "`".addslashes($tableHeaders[$i][0])."`=".addQuotes($arr[$i]));
	}

	// run it
	$updateStr = 'UPDATE `'.$tableName.'` SET '.join(", ",$writeThis).' WHERE '.$rowSelector;
	if ($debug) {
    	echo($updateStr);
    	echo('<br>');
    }
	return writeSQL($YOUR_DATABASE_NAME, $updateStr);
}
function addQuotes($str) {
	if (gettype($str) == 'string') {
    	return '"'.addslashes($str).'"';
    }
	if ($str == NULL) {
    	return 'NULL';
    }
	return $str;
}

?>