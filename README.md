# Simple JSON DB

This is a simple JSON database coded with PHP. I also included a test page to demonstrate all the database calls.

## Quick Start

- Drop src files into a directory
- Open test.php and test database functions
- To make a new JSON DB file, create a new .json file and add curly braces **{}** with a code editor
- You can now use that file name in your database calls

![making new file in code editor](https://github.com/jasoncampbelldev/simple-json-db/blob/main/simple-json-db-screenshot-file-start.jpg?raw=true)

## Database Functions

### setRow($fileName, $dataArray)
Sets database row and properties. Returns the new row ID string.

#### Args
- **fileName:** name of JSON file to write row too
- **dataArray:** key/value array of properties to be added

#### Result
- **status:** Boolean (true/false) - True = successful. False = error
- **data:** String - Row ID if successful

#### Example
```
$propsArray = array();
$propsArray['name'] = "Jason";
$propsArray['message'] = "Hello World";
$result = setRow("testFile", $propsArray);
if ($result['status']) {
	 echo $result['data'] . "<br><br>";
}
```

### updateRow($fileName, $rowID, $props)
Updates a database row. This is JSON so you can also add new props. Returns row ID string.

#### Args
- **fileName:** name of JSON file to write row too
- **rowID:** id of row to update
- **props:** key/value array of properties to be added

#### Result
- **status:** Boolean (true/false) - True = successful. False = error
- **data:** String - Row ID if successful

#### Example
```
$propsArray = array();
$propsArray['name'] = "Jason & Jax";
$propsArray['message'] = "Hello Again World";
$result = updateRow("testFile", "6518f521c7631", $propsArray);
if ($result['status']) {
  echo $result['data']['id'] . "<br><br>";
}
```

### getAllRows($fileName)
Returns all rows in the JSON file. Result data is in array of arrays.

#### Args
- **fileName:** name of JSON file to write row too

#### Result
- **status:** Boolean (true/false) - True = successful. False = error
- **data:** Array of Arrays - All row data in key/value arrays if successful

#### Example
```
$result = getAllRows("testFile");
if ($result['status']) {
  foreach ($result['data'] as $key=>$row) {
    echo $key . "<br>";
    echo $row['name'] . "<br>";
    echo $row['message'] . "<br><br>";
  }
}
```

### getRow($fileName, $rowID)
Returns row by ID. Result data is a single array.

#### Args
- **fileName:** name of JSON file to write row too
- **rowID:** id of row to update

#### Result
- **status:** Boolean (true/false) - True = successful. False = error
- **data:** Array - Row data in key/value array if successful

#### Example
```
$result = getRow("testFile", "6518f521c7631");
if ($result['status']) {
  echo $result['data']['id'] . "<br>";
  echo $result['data']['name'] . "<br>";
  echo $result['data']['message'] . "<br><br>";
}
```

### queryDB($fileName, $propName, $propValue)
Returns row by property name/value. Result data is a single array.

#### Args
- **fileName:** name of JSON file to write row too
- **propName:** key name of property to query for
- **propName:** value of property to query for

#### Result
- **status:** Boolean (true/false) - True = successful. False = error
- **data:** Array - Row data in key/value array if successful

#### Example
```
$result = queryDB("testFile","name","jason");
if ($result['status']) {
  foreach ($result['data'] as $key=>$row) {
    echo $key . "<br>";
    echo $row['name'] . "<br>";
    echo $row['message'] . "<br><br>";
  }
}
```


### deleteRow($fileName, $rowID)
Deletes row by ID. Only returns a restult status.
- **fileName:** name of JSON file to write row too
- **rowID:** id of row to delete
- **propName:** value of property to query for

#### Result
- **status:** Boolean (true/false) - True = successful. False = error
- **data:** empty

#### Example
```
$result = deleteRow("testFile","6518f521c7631");
if ($result['status']) {
  echo "Row Deleted<br><br>";
}
```


## Test Page

![test page screenshot](https://github.com/jasoncampbelldev/simple-json-db/blob/main/simple-json-db-screenshot-test-page.jpg?raw=true)



## How JSON looks when added to file

![JSON fiel example](https://github.com/jasoncampbelldev/simple-json-db/blob/main/simple-json-db-screenshot-json.jpg?raw=true)



