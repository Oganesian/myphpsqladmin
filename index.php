<?php
//if($_POST["create"])
//{
	//$name = $_POST["name"];
	//$age = $_POST["age"];
	//$address = $_POST["address"];


	$mysqli = new mysqli("localhost", "root", "", "test");
	//$sql = "INSERT INTO test_table VALUES(NULL, '{$name}', {$age}, '{$address}')";
	$sql = "SELECT * FROM test_table";
	$result = $mysqli->query($sql) or die($mysqli->error);
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
			while ($column_info = $result->fetch_field()){
					echo $column_info->type . " ";
					//SELECT `CHARACTER_MAXIMUM_LENGTH` FROM information_schema.COLUMNS WHERE TABLE_NAME = 'test_table' AND COLUMN_NAME = 'address'

				//	echo $column_info->max_length . "<br>";

			}
		}
	}
//}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="main-row">
			<div class="component-block">
				<div class="upper-button-container">
					<button type="button" class="standard-btn" name="new_mask">New</button>
					<button type="button" class="standard-btn" name="open_mask">Open</button>
				</div>
				<div class="under-button-container">
					<button type="button" class="standard-btn" name="save_mask">Save</button>
					<button type="button" class="standard-btn" name="create_mask">Create</button>
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
