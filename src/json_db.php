<?php

$GLOBALS['jsonFolder'] = "json"; // enter name of folder where JSON files are stored


//////////////////////////
// Sets JSON row/object //
//////////////////////////
function setRow($fileName, $dataArray) {
	$file = file_get_contents($GLOBALS['jsonFolder'] . "/" . $fileName . ".json");

	// if file doesn't exist return early
	if (!$file) {
		return array('status'=>false,'data'=>'file ' . $fileName . ' does not exist');
	}

	$jsonArray = json_decode($file, true);

	// if JSON array doesn't exist make it
	if ($jsonArray === null) {
	     $jsonArray = array();   
	}

	// add row item with unique ID
	$uniqID = uniqid();
	$jsonArray[$uniqID] = $dataArray;

	$encodedJSON = json_encode($jsonArray, JSON_PRETTY_PRINT);

	// write JSON back to file
	$file = fopen("json/" . $fileName . ".json", "w") or die("Unable to open file");
	fwrite($file, $encodedJSON);
	fclose($file);

	return array('status'=>true,'data'=>$uniqID);
}
// Example:
// $dataArray = array();
// $dataArray['name'] = "Jason";
// $dataArray['message'] = "Hello World";
// $result = setRow("testFile", $dataArray);
// if ($result['status']) {
//	 echo $result['data'] . "<br><br>";
// }


////////////////////////////
// Update JSON row/object //
////////////////////////////
function updateRow($fileName, $rowID, $props) {
	$file = file_get_contents($GLOBALS['jsonFolder'] . "/" . $fileName . ".json");

	// if file doesn't exist return early
	if (!$file) {
		return array('status'=>false,'data'=>'file ' . $fileName . ' does not exist');
	}

	$jsonArray = json_decode($file, true);

	// if JSON doesn't exist return early
	if ($jsonArray == null) {
		return array('status'=>false,'data'=>'json does not exist');
	}

	// if row doesn't exist return early else update row and return data
 	if ($jsonArray[$rowID] == null) {
 		return array('status'=>false,'data'=>'row does not exist');
 	} else {
 		foreach($props as $key => $prop)  {
 			$jsonArray[$rowID][$key] = $prop;
 		}

		$encodedJSON = json_encode($jsonArray,JSON_PRETTY_PRINT);

 		// write JSON back to file
		$file = fopen($GLOBALS['jsonFolder'] . "/" . $fileName . ".json", "w") or die("Unable to open file");
		fwrite($file, $encodedJSON);
		fclose($file);

 		return array('status'=>true,'data'=>$rowID);
 	}
}
// Example:
// $dataArray = array();
// $dataArray['name'] = "Jason & Jax";
// $dataArray['message'] = "Hello Again World";
// $result = updateRow("testFile", "6518f521c7631", $dataArray);
// if ($result['status']) {
//	 echo $result['data']['id'] . "<br><br>";
// }


////////////////////////////////////////
// Gets all JSON rows/objects in file //
////////////////////////////////////////
function getAllRows($fileName) {

	$file = file_get_contents($GLOBALS['jsonFolder'] . "/" . $fileName . ".json");

	// if file doesn't exist return early
	if (!$file) {
		return array('status'=>false,'data'=>'file ' . $fileName . ' does not exist');
	}

	$jsonArray = json_decode($file, true);
	
	// if JSON doesn't exist return early
	if ($jsonArray == null) {
		return array('status'=>false,'data'=>'json does not exist');
	}

	// if JSON doesn't exist return early
	if ($jsonArray == null) {
		return array('status'=>false,'data'=>'json does not exist');
	} else {
		return array('status'=>true,'data'=>$jsonArray);		
	}
}
// Example:
// $result = getAllRows("testFile");
// if ($result['status']) {
//	foreach ($result['data'] as $key=>$row) {
//      echo $key . "<br>";
//		echo $row['name'] . "<br>";
//		echo $row['message'] . "<br><br>";
//	}
// }



////////////////////////////////
// Gets JSON row/object by ID //
////////////////////////////////
function getRow($fileName, $rowID) {

	$file = file_get_contents($GLOBALS['jsonFolder'] . "/" . $fileName . ".json");
	
	// if file doesn't exist return early
	if (!$file) {
		return array('status'=>false,'data'=>'file ' . $fileName . ' does not exist');
	}

	$jsonArray = json_decode($file, true);

	// if JSON doesn't exist return early
	if ($jsonArray == null) {
		return array('status'=>false,'data'=>'json does not exist');
	}

    $rowArray = $jsonArray[$rowID];

	// if row doesn't exist return false else return data
 	if ($rowArray == null) {
 		return array('status'=>false,'data'=>'row does not exist');
 	} else {
 		$rowArray['id'] = $rowID;
 		return array('status'=>true,'data'=>$rowArray);
 	}
}
// Example:
// $result = getRow("testFile", "6518f521c7631");
// if ($result['status']) {
//	 echo $result['data']['id'] . "<br>";
//	 echo $result['data']['name'] . "<br>";
//	 echo $result['data']['message'] . "<br><br>";
// }



//////////////////////////////////////////////////////////////
// Queries for JSON rows/objects by property name and value //
//////////////////////////////////////////////////////////////
function queryDB($fileName, $propName, $propValue) {

	$file = file_get_contents($GLOBALS['jsonFolder'] . "/" . $fileName . ".json");

	// if file doesn't exist return early
	if (!$file) {
		return array('status'=>false,'data'=>'file ' . $fileName . ' does not exist');
	}

	$jsonArray = json_decode($file, true);

	// if JSON doesn't exist return early
	if ($jsonArray == null) {
		return array('status'=>false,'data'=>'json does not exist');
	}

	$returnArray = [];
	foreach ($jsonArray as $key => $row) {
		if ($row[$propName] == $propValue) {
			$returnArray[$key] = $row;
		}
	}

	// if no results return false else return results
	if (!$returnArray) {
		return array('status'=>false,'data'=>'no results');
	} else {
		return array('status'=>true,'data'=>$returnArray);		
	}
}
// Example:
// $result = queryDB("testFile","name","jason");
// if ($result['status']) {
//	foreach ($result['data'] as $key=>$row) {
//      echo $key . "<br>";
//		echo $row['name'] . "<br>";
//		echo $row['message'] . "<br><br>";
//	}
// }



/////////////////////////////
// Deletes JSON row/object //
/////////////////////////////
function deleteRow($fileName, $rowID) {

	$file = file_get_contents($GLOBALS['jsonFolder'] . "/" . $fileName . ".json");

	// if file doesn't exist return early
	if (!$file) {
		return array('status'=>false,'data'=>'file ' . $fileName . ' does not exist');
	}

	$jsonArray = json_decode($file, true);

	$status = false;
	
	// delete row from JSON
	if ($jsonArray[$rowID]) {
		unset($jsonArray[$rowID]);
		$status = true;
	}

	$encodedJSON = json_encode($jsonArray,JSON_PRETTY_PRINT);

	// write JSON back to file
	$file = fopen($GLOBALS['jsonFolder'] . "/" . $fileName . ".json", "w") or die("Unable to open file");
	fwrite($file, $encodedJSON);
	fclose($file);

	return array('status'=>$status,'data'=>'');
}
// Example:
// $result = deleteRow("testFile","6518f521c7631");
// if ($result['status']) {
//	echo "Row Deleted<br><br>";
// }



?>
