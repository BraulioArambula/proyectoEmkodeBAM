<!-- CODIGO CREADO POR BRAULIO ARAMBULA MARTINEZ -->
<?php
	require 'configuracionBD.php';
	$numRegPag = 5;

	if (isset($_GET["pagina"]))
		$pagina  = $_GET["pagina"];
	else
		$pagina = 1;
	$empiezaDe = ($pagina-1) * $numRegPag;

	$sqlTotEmp = "SELECT * FROM empleados";
	$res =  mysqli_query($mysqli,$sqlTotEmp);
	$sql = "SELECT * FROM empleados ORDER BY id DESC LIMIT $empiezaDe, $numRegPag"; 

	$res = $mysqli->query($sql);

  	while($row = $res->fetch_assoc()){
		$json[] = $row;
  	}

	$data['data'] = $json;
	$res =  mysqli_query($mysqli,$sqlTotEmp);
	$data['total'] = mysqli_num_rows($res);
	echo json_encode($data);
?>