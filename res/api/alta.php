<?php
	require 'configuracionBD.php';
  	
  	$post = $_POST;
	$sql = "INSERT INTO empleados(nombre,apellido,email,telefono)
			VALUES ('".$post['nombre']."','".$post['apellido']."','".$post['email']."','".$post['telefono']."');";

	$res = $mysqli->query($sql);
	$sql = "SELECT * FROM empleados ORDER BY id DESC LIMIT 1"; 
	$res = $mysqli->query($sql);
  	$data = $res->fetch_assoc();
	
	echo json_encode($data);
?>