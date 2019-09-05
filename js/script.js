$(document).ready(function() {
  loadTablesInBox();
});

function loadTablesInBox(){
  $.ajax({
  type: "POST",
  url: "php/functions.php",
  data: 'getTables',
  success: function(data) {
    $("#_tables_in_db").html(data);
    loadColumnsInBox();
  },
});
}

function loadColumnsInBox(){
  var tableName = $("#_tables_in_db").val();
  $.ajax({
  type: "POST",
  url: "php/functions.php",
  data: 'table='+tableName,
  success: function(data) {
    $("#_existing_columns").html(data);
  },
});
}
