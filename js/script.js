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

function resizableTable(){
  var thElm;
  var startOffset;

  Array.prototype.forEach.call(
    document.querySelectorAll("table th"),
    function (th) {
      th.style.position = 'relative';

    var grip = document.createElement('div');
    grip.innerHTML = "&nbsp;";
    grip.style.top = 0;
    grip.style.right = 0;
    grip.style.bottom = 0;
    grip.style.width = '5px';
    grip.style.position = 'absolute';
    grip.style.cursor = 'col-resize';
    grip.addEventListener('mousedown', function (e) {
        thElm = th;
        startOffset = th.offsetWidth - e.pageX;
    });

    th.appendChild(grip);
  });

document.addEventListener('mousemove', function (e) {
  if (thElm) {
    thElm.style.width = startOffset + e.pageX + 'px';
  }
});

document.addEventListener('mouseup', function () {
    thElm = undefined;
    $("#__table th").each(function(index) {
      console.log($(this).css("width"));
    });
});
}

function setOnClicks(){
  $('.delete-btn').click(function(){
    var id = $(this).parent().parent()[0].cells[0].dataset.value;
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

  $('.editButton').click(function(){
    var id = $('.editButton').attr("id");
    var len = $('#showed_table th').length;
    var dataArr = [];
    dataArr[0] = 'edit:true';
    dataArr[1] = 'old_id:'+id;
    $('#editTable th').each(function(index) {
      if(index + 1 == len) return true;
      dataArr.push($(this).text()+':::::QSFQXlfS6&=sfx:::&!%&/(()§%§!)'+$('#editTable td')[index].innerHTML);
    });
    $.ajax({
      type: "POST",
      url: "php/functions.php",
      data: {edit:dataArr},
      success: function(data) {
        $("#showed_table").html(data);
        setOnClicks();
        $(".modal").fadeOut(50);
        $(".dialog").fadeOut(10);
      },
    });
  });


  $('.edit-btn').click(function(){
    var id = $(this).parent().parent()[0].cells[0].dataset.value;
    $('.editButton').attr("id", id);
    $(".modal").fadeIn(50);
    $("#editDialog").fadeIn(50);
    var $th = $('#showed_table th');
    var $tr = $(this).parent().parent()[0];
    $("#editTable").html($($th).clone());
    $("#editTable").append($($tr).clone());
  });

  $(".cancel").click(function() {
   $(".modal").fadeOut(50);
   $(".dialog").fadeOut(10);
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
    },
  });
}
