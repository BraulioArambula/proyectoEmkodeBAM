<?php
	require 'configuracionBD.php';

	$id  = $_POST["id"];
	$sql = "DELETE FROM empleados WHERE id = '".$id."'";
	$res = $mysqli->query($sql);

 	echo json_encode([$id]);
?>