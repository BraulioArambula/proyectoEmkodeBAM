<?php
	require 'configuracionBD.php';
  	
  	$post = $_POST;
	
	$sql = "SELECT * FROM empleados WHERE nombre LIKE '".$post['busqueda']."%' ORDER BY id DESC LIMIT 1"; 
	$res = $mysqli->query($sql);
  	$data = $res->fetch_assoc();
	
	echo json_encode($data);
?>