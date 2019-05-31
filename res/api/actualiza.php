<?php
  require 'configuracionBD.php';

  $id  = $_POST["id"];
  $post = $_POST;

  $sql = "UPDATE empleados
          SET nombre = '".$post['nombre']."',
          apellido = '".$post['apellido']."',
          email = '".$post['email']."',
          telefono = '".$post['telefono']."'
          WHERE id = '".$id."'";

  $res = $mysqli->query($sql);
  $sql = "SELECT * FROM empleados WHERE id = '".$id."'"; 
  $res = $mysqli->query($sql);
  $data = $res->fetch_assoc();

  echo json_encode($data);
?>