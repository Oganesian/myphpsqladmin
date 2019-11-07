<?php
include_once("sqlquery.php");

class SQLTool
{
  private $tableName;
  private $columnsNames = array();
  private $create;
  private $update;
  private $delete;

  function __construct($tableName, $columnsNames, $create=true, $update=true, $delete=true){
    $this->tableName = $tableName;
    $this->columnsNames = $columnsNames;
    $this->create = $create;
    $this->update = $update;
    $this->delete = $delete;
  }

  function getTableName() {
    return $this->tableName;
  }
  function setTableName($tableName) {
    $this->tableName = $tableName;
  }

  function getColumnsNames() {
    return $this->columnsName;
  }
  function setColumnsNames($columnsName) {
    $this->columnsName = $columnsName;
  }

  function setFunctions($create, $update, $delete){
    $this->create = $create;
    $this->update = $update;
    $this->delete = $delete;
  }

  function showTable(){
    $columnsStr = "";
    $tableHeaders = "<table id=\"__table\"><tr id=\"columns-headers\">";

    foreach ($this->columnsNames as $column) {
      $columnsStr .= "`{$column}`, ";
      $tableHeaders .= "<th>{$column}</th>";
    }

    $tableHeaders .= "<th class='action-td' id='action-th'>Action</th></tr>";
    $columnsStr = substr($columnsStr, 0, -2);

    $result = my_query("SELECT {$columnsStr} FROM {$this->tableName}", true) or die('Query failed: ' . mysql_error());

    $echo = '
    <div class="table-header"><h2 id="table_name">'.$this->tableName.'</h2></div>
    <div class="table-block">'.$tableHeaders;

    while ($line = $result->fetch_assoc()) {
      $tr = "<tr>";
      foreach ($line as $line_) {
        $tr .= "<td data-value='{$line_}'>{$line_}</td>";
      }
      $tr .= "<td class='action-td'><div class='left-div edit-btn'><img src='img/edit.svg' class='action-img'></img></div><div class='delete-btn'><img src='img/delete.svg' class='action-img'></img></div></td>";
      $tr .= "</tr>";
      $echo .= $tr;
    }

    $echo .= '</table></div><script>resizableTable();</script>';
    return $echo;
  }

  function deleteRow($id){
    my_query("DELETE FROM {$this->tableName} WHERE `id`={$id}", false) or die('Query failed: ' . mysql_error());
    return $this->showTable();
  }

  function editRows($rows){
    $sqlQuery = "UPDATE `{$this->tableName}` SET ";
    $i = 0;
    $old_id;
    $arr = array();
    foreach ($rows as $row) {
      foreach ($row as $_row) {
        if($i++ == 0) continue;
        if($i == 2){
          $old_id = explode(":", $_row)[1];
          continue;
        }
        $teile = explode(":::::QSFQXlfS6&=sfx:::&!%&/(()§%§!)", $_row);
        $arr[$teile[0]] = $teile[1];
      }

      foreach ($arr as $key => $value) {
      $converted = strtr($key, array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES)));
      $converted = trim($converted, chr(0xC2).chr(0xA0));

        $sqlQuery .= "`{$converted}` = '{$value}', ";
      }
      $sqlQuery = substr($sqlQuery, 0, -2);
      $sqlQuery .= " WHERE `id` = {$old_id}";
    }
    my_query($sqlQuery, true) or die('Query failed: ' . mysql_error());
    return $this->showTable();
  }
}

?>
