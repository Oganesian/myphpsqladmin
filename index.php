<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
	<script src="js/script.js" type="text/javascript"></script>
</head>

<body>
	<div class="main-row">
		<div class="component-block">
			<div class="upper-button-container">
				<button type="button" class="standard-btn" id="new_mask">New</button>
				<button type="button" class="standard-btn" id="open_mask">Open</button>
			</div>
			<div class="component-main-row">
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
					</div>
				</div>
				<div class="container tables">
					<select class="standard-select" name="tables_in_db" id="_tables_in_db"></select>
				</div>
			</div>
			<div class="under-button-container">
				<button type="button" class="standard-btn" id="save_mask">Save</button>
				<button type="button" class="standard-btn" id="create_mask">Create</button>
			</div>
		</div>
		<!--<div class="form-container">
				<form name="user" method="post">
					<div class="input-container">
						<label for="name_">Name</label>
						<input type="text" class="input" name="name" id="name_" required />
					</div>
					<div class="input-container">
						<label for="age_">Age</label>
						<input type="number" class="input" name="age" required />
					</div>
					<div class="input-container">
						<label for="address_">Address</label>
						<input type="address" class="input" name="address" required />
					</div>
					<div class="input-container submit-container">
						<input type="submit" class="submit" name="create" value="Create" />
					</div>
				</form>
			</div>-->
	</div>
</body>

</html>
