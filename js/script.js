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

  $("#pick_column").click(pick);
  $("#remove_column").click(remove);

});

function pick(){
  var $options = $("#_existing_columns > option:selected").clone();
  if($options.val() === undefined){
    var pickAll = confirm("Do you want to pick all columns?");
    if(pickAll){
      var $options_ = $("#_existing_columns > option").clone();
      $("#_picked_columns").append($options_);
      // FIXME: dbclick and exists
      //$('#_picked_columns option').dblclick(remove);
      /*var exists_ = false;
      $('#_picked_columns option').each(function(){
        var $picked = this.value;
        alert(1);
        $($options_).each(function(){
          if (this.value == $picked) {
              exists_ = true;
              alert(1);
              return false;
          }
        });
        if(!exists_){
          $("#_picked_columns").append($options_);
        }
      });*/
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
      $("#_existing_columns").html(data);
      $('#_existing_columns option').dblclick(pick);
    },
  });
}
