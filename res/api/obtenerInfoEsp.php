<?php
	require 'configuracionBD.php';
	$numRegPag = 10;

	if (isset($_GET["pagina"]))
		$pagina  = $_GET["pagina"];
	else
		$pagina = 1;
	$busq = filter_input(INPUT_POST, 'busqueda');
	$empiezaDe = ($pagina-1) * $numRegPag;

	$sqlTotEmp = "SELECT * FROM empleados WHERE nombre LIKE '".$busq."%' OR apellido LIKE '".$busq."%' OR email LIKE '".$busq."%' OR telefono LIKE '".$busq."%'";
	$res =  mysqli_query($mysqli,$sqlTotEmp);
	$sql = "SELECT * FROM empleados WHERE nombre LIKE '".$busq."%' OR apellido LIKE '".$busq."%' OR email LIKE '".$busq."%' OR telefono LIKE '".$busq."%' ORDER BY id DESC LIMIT $empiezaDe, $numRegPag"; 

	$res = $mysqli->query($sql);

  	while($row = $res->fetch_assoc()){
		$json[] = $row;
  	}

  	$res =  mysqli_query($mysqli,$sqlTotEmp);
	$data['total'] = mysqli_num_rows($res);
	if($data['total'] == 0)
		$data['data'] = "";
	else
		$data['data'] = $json;
	$data['busq'] = $busq;
	echo json_encode($data);
?>