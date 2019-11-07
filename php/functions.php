<?php
include_once 'sqlquery.php';
include_once 'SQLTool.php';

if(isset($_POST['getTables'])) {
    echo getExistingTables();
}

if(isset($_POST['table'])) {
    echo getExistingColumns($_POST['table']);
}

if(isset($_POST['deleteId'])) {
  session_start();
  $obj = unserialize($_SESSION['myTool']);
  echo $obj->deleteRow($_POST['deleteId']);
}

if(isset($_POST['edit'])) {
  session_start();
  $obj = unserialize($_SESSION['myTool']);
  echo $obj->editRows($_POST);
}

if(isset($_POST['new_table_columns'])) {
    echo createTable($_POST['new_table_columns']);
}

if(isset($_POST['show_columns'])) {
    echo showColumns($_POST['show_columns']);
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
    $options .= "<option value='{$line['Field']}' data-source-table='$tableName'>{$line['Field']}, {$line['Type']}</option>";
  }
  return $options;
}

/*function createTable($columns){
  $columnsStr = "";
  $tablesStr = "";
  $tableNames = array();
  foreach ($columns as $column) {
    $columnsStr .= $column[1] . "." . $column[0] . ", ";
    $tableNames[] = $column[1];
  }
  $columnsStr = substr($columnsStr, 0, -2);
  $tableNames = array_unique($tableNames);
  foreach ($tableNames as $tableName) {
    $tablesStr .= $tableName . ", ";
  }
  $tablesStr = substr($tablesStr, 0, -2);
  $sqlQuery = "CREATE TABLE created_from_php".rand()." AS (SELECT {$columnsStr} FROM {$tablesStr})";

  my_query($sqlQuery, false) or die('Query failed: ' . mysql_error());
//  return $columnsStr;
}*/

function showColumns($columns){
  $columnsStr = "";
  $tablesStr = "";
  $tableNames = array();
  $tableHeaders = "<table><tr id=\"columns-headers\">";
  foreach ($columns as $column) {
    $columnsStr .= $column[1] . "." . $column[0] . ", ";
    $tableNames[] = $column[1];
    $tableHeaders .= "<th>{$column[0]}</th>";
  }
  $tableHeaders .= "</tr>";
  $columnsStr = substr($columnsStr, 0, -2);
  $tableNames = array_unique($tableNames);
  foreach ($tableNames as $tableName) {
    $tablesStr .= $tableName . ", ";
  }
  $tablesStr = substr($tablesStr, 0, -2);
  $sqlQuery = "SELECT {$columnsStr} FROM  {$tablesStr}";

  $result = my_query($sqlQuery, true) or die('Query failed: ' . mysql_error());
  $tr = "";

  $echo = '
  <div class="table-header"><h2 id="table_name">'.$tablesStr.'</h2></div>
  <div class="table-block"">'.$tableHeaders;
  while ($line = $result->fetch_assoc()) {
    $tr = "<tr>";
    foreach ($line as $line_) {
      $tr .= "<td>{$line_}</td>";
    }
    $tr .= "</tr>";
    $echo .= $tr;
  }

  $echo .= '</table></div>';
  return $echo;
}
?>
