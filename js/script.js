$(document).ready(function() {
  loadTablesInBox();

  $("#_tables_in_db").change(function(){
    loadColumnsInBox();
  });

  $("#_existing_columns").on('keypress',function(e) {
    if(e.which == 13) {
        pick()
    }
  });

  $("#_picked_columns").on('keypress',function(e) {
    if(e.which == 13) {
        remove()
    }
  });

  setOnClicks();

  $('.edit-btn').click(function(){
    var id = $(this).parent().parent()[0].cells[0].innerHTML;
    alert(id);
  });

  $("#pick_column").click(pick);
  $("#remove_column").click(remove);
  $("#load_table").click(loadColumnsInBox);

  $("#clear_column").click(function() {
    $("#_existing_columns").find('option').remove();
  });

  $("#new_mask").click(function() {
    $("#_existing_columns").find('option').remove();
    $("#_picked_columns").find('option').remove();
  });

  $("#save_mask").click(function() {
    alert("404 Function not found");
  });

  $("#create_table").click(function() {
    createTable();
  });

  $("#show_columns").click(function() {
    showColumns();
  });
});

function setOnClicks(){
  $('.delete-btn').click(function(){
    var id = $(this).parent().parent()[0].cells[0].innerHTML;
    alert(id);
    $.ajax({
      type: "POST",
      url: "php/functions.php",
      data: 'deleteId='+id,
      success: function(data) {
        $("#showed_table").html(data);
        setOnClicks();
      },
    });
  });
}

function pick(){
  var $options = $("#_existing_columns > option:selected");
  if($options.val() === undefined){
    var pickAll = confirm("Do you want to pick all columns?");
    if(pickAll){
      $('#_existing_columns option').each(function(){
        if($('#_picked_columns option[value='+this.value+']').length == 0){
          $(this).unbind("dblclick");
          $(this).dblclick(remove);
          $("#_picked_columns").append(this);
        }
      });
    }
  }
  else{
    var exists = false;
    $('#_picked_columns option').each(function(){
        if (this.value == $options.val()) {
            exists = true;
            return false;
        }
    });
    if(!exists){
      $($options).unbind("dblclick");
      $($options).dblclick(remove);
      $("#_picked_columns").append($options);
    }
  }
}

function remove(){
  if($("#_picked_columns option:selected").val() === undefined){
    var removeAll = confirm("Do you want to remove all columns?");
    if(removeAll){
      $("#_picked_columns").find('option').remove();
    }
  }
  else
  {
    $("#_picked_columns option:selected").remove();
  }
}

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
      $("#_existing_columns").append(data);
      $('#_existing_columns option').unbind("dblclick");
      $('#_existing_columns option').dblclick(pick);
    },
  });
}

/*function createTable(){
  var $columns = $("#_picked_columns option").map(function(){
    return new Array([$(this).val(), $(this).data("source-table")]);
  }).get();
  $.ajax({
    type: "POST",
    url: "php/functions.php",
    data: {"new_table_columns":$columns},
    success: function(data) {
      console.log($columns);
      console.log(data);
    },
  });
}*/

function showColumns(){
  var $columns = $("#_picked_columns option").map(function(){
    return new Array([$(this).val(), $(this).data("source-table")]);
  }).get();
  $.ajax({
    type: "POST",
    url: "php/functions.php",
    data: {"show_columns":$columns},
    success: function(data) {
      $("#showed_table").html(data);
      $("#showed_table").fadeIn();
      //console.log($columns);
      //console.log(data);
    },
  });
}
