<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DATABASE', 'masks_and_tables');


function my_query($query, $hasResult){
    $db = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if(!$result = $db->query($query)){
        die("<h2>There was an error running the query [' . $db->error . ']</h2><br />".$query);
    } else {
        if($hasResult){
            return $result;
        }
    }
}

function safe_query($query){
	$suspicious_strings = array("DROP", "TABLE", "DATABASE", "DELETE",
	 "UNION", "UPDATE", "ALTER", "ADD", "SET", "=", "SELECT", "CREATE", "script", ";", "'", "\"", "--");
	foreach ($suspicious_strings as $string) {
		$query = str_ireplace($string, "", $query);
	}
	return $query;
}

?>
