<?php
include_once 'sqlquery.php';

if(isset($_POST['getTables'])) {
    echo getExistingTables();
}

if(isset($_POST['table'])) {
    echo getExistingColumns($_POST['table']);
}

function getExistingTables(){
  $result = my_query("SHOW TABLES", true) or die('Query failed: ' . mysql_error());
  $options = "";
  while ($line = $result->fetch_assoc()) {
    $options .= "<option value='{$line['Tables_in_masks_and_tables']}'>{$line['Tables_in_masks_and_tables']}</option>";
  }
  return $options;
}

function getExistingColumns($tableName){
  // ADD CHECK IF TABLE EXISTS
  $result = my_query("SHOW COLUMNS FROM " . $tableName, true) or die('Query failed: ' . mysql_error());
  $options = "";
  while ($line = $result->fetch_assoc()) {
    $options .= "<option value='{$line['Field']}'>{$line['Field']}, {$line['Type']}</option>";
  }
  return $options;
}
?>
