<?php
include_once("sqlquery.php");

class SQLTool
{
  private $tableName;
  private $columnsNames = array();
  private $create;
  private $update;
  private $delete;

  function __construct($tableName, $columnsNames, $create, $update, $delete){
    $this->tableName = $tableName;
    $this->columnsNames = $columnsNames;
    $this->create = $create;
    $this->update = $update;
    $this->delete = $delete;
  }

  function getTableName() {
    return $this->tableName;
  }

  function getColumnsNames() {
    return $this->columnsName;
  }

  function showTable(){
    $columnsStr = "";
    $tableHeaders = "<table><tr id=\"columns-headers\">";

    foreach ($this->columnsNames as $column) {
      $columnsStr .= "{$column}, ";
      $tableHeaders .= "<th>{$column}</th>";
    }

    $tableHeaders .= "<th class='action-td' id='action-th'>Action</th></tr>";
    $columnsStr = substr($columnsStr, 0, -2);

    $result = my_query("SELECT {$columnsStr} FROM {$this->tableName}", true) or die('Query failed: ' . mysql_error());

    $echo = '
    <div class="table-header"><h2 id="table_name">'.$this->tableName.'</h2></div>
    <div class="table-block"">'.$tableHeaders;

    while ($line = $result->fetch_assoc()) {
      $tr = "<tr>";
      foreach ($line as $line_) {
        $tr .= "<td>{$line_}</td>";
      }
      $tr .= "<td class='action-td'><div class='left-div edit-btn'><img src='img/edit.svg' class='action-img'></img></div><div class='delete-btn'><img src='img/delete.svg' class='action-img'></img></div></td>";
      $tr .= "</tr>";
      $echo .= $tr;
    }

    $echo .= '</table></div>';
    return $echo;
  }

  function deleteRow($id){
    my_query("DELETE FROM {$this->tableName} WHERE `id`={$id}", true) or die('Query failed: ' . mysql_error());
    return $this->showTable();
  }
}

?>
