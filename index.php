<?php
include_once 'php/SQLTool.php';
$myTool = new SQLTool("test", array("id", "text", "date", "double"));

session_start();
$_SESSION['myTool'] = serialize($myTool);

?>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
	<script src="js/script.js" type="text/javascript"></script>
</head>

<body>
	<div class="dialog" id="editDialog">
	<div class="dialog-wrapper" id="editWrapper">
		<div class="top-container">
			<div class="title-container">
				<div class="title" id="editTitle">Editing</div>
			</div>
		</div>
				<div class="table-container">
					<table contenteditable="true" id="editTable"></table>
				</div>
				<div class="button-container" id="editButtons">
					<button class="submit cancel">Cancel</button>
					<button class="submit editButton">Edit</button>
				</div>
	</div>
</div>

<div class="modal">
</div>

	<div class="main-row">
		<div class="component-block">
		  <div class="upper-button-container">
		    <button type="button" class="standard-btn" id="new_mask">New</button>
		    <button type="button" class="standard-btn" id="open_mask">Open (FIXME)</button>
		  </div>
		  <div class="component-main-row">
		    <form name="sql_mask" id="_sql_mask">
		      <div class="container picked-columns">
		        <select class="standard-select full-select" name="picked_columns" id="_picked_columns" size="5"></select>
		        <div class="columns-button-container">
		          <button type="button" class="standard-btn" id="remove_column">Remove</button>
		        </div>
		      </div>
		      <div class="container columns">
		        <select class="standard-select full-select" name="existing_columns" id="_existing_columns" size="5"></select>
		        <div class="columns-button-container">
		          <button type="button" class="standard-btn" id="pick_column">Pick</button>
		          <button type="button" class="standard-btn" id="clear_column">Clear</button>
		        </div>
		      </div>
		      <div class="container tables">
		        <select class="standard-select" name="tables_in_db" id="_tables_in_db"></select>
		      </div>
		      <div class="columns-button-container">
		        <button type="button" class="standard-btn" id="load_table">Load</button>
		      </div>
		    </div>
		    <div class="under-button-container">
		      <button type="button" class="standard-btn" id="save_mask">Save (FIXME)</button>
		      <button type="button" class="standard-btn" id="create_table">Create (FIXME)</button>
		      <button type="button" class="standard-btn" id="show_columns">Show</button>
		    </div>
		  </form>
		</div>
		<div class="table-container" id="showed_table">
      <?php echo $myTool->showTable(); ?>
		</div>
	</div>

</body>

</html>
