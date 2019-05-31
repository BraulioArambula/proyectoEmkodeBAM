<!DOCTYPE HTML5>
<html>
	<head>
		<title>EMPLEADOS</title>
		<!-- Estilos Bootstrap -->
		<link rel="stylesheet" href="res/css/bootstrap.min.css">
		<!-- SCRIPT JQuery-->
		<script type="text/javascript" src="res/js/jquery.js"></script>
		<!-- SCRIPT Bootstrap -->
		<script type="text/javascript" src="res/js/bootstrap.min.js"></script>
		<!-- SCRIPT que sirve para la paginación -->
		<script type="text/javascript" src="res/js/jquery.twbsPagination.min.js"></script>
		<!-- SCRIPT para dar diseño a las validaciones en los formularios -->
		<script src="res/js/validator.min.js"></script>
		<!-- SCRIPT para usar iconos de google -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!-- SCRIPT para usar las alertas --> 
		<script type="text/javascript" src="res/js/toastr.min.js"></script>
		<!-- ESTILO para usar las alertas --> 
	   	<link href="res/css/toastr.min.css" rel="stylesheet">
		<!-- SCRIPT para hacer uso de AJAX que se definió -->
	    <script src="res/js/empleado-ajax.js"></script>
	    <!-- SCRIPT que ayuda a que solo se puedan teclear números en algún input -->
	    <script type="text/javascript">
      		function justNumbers(e){
        		var keynum = window.event ? window.event.keyCode : e.which;
        		if ((keynum == 8) || (keynum == 46) || event.keyCode == 13)return true;  
        		return /\d/.test(String.fromCharCode(keynum));
      		}
    	</script>
    	<script type="text/javascript">
    	 var url = "http://localhost/ProyectoEmkode/";
        </script>
	</head>
	<body>
		<div style="padding-top: 2%;"></div>
		<div class="container" style="padding-top: 2%;padding-bottom: 1%;background-color: rgba(67,81,135, 0.8);">
			<div class="row">
		    	<div class="col-sm-6" style="text-align: left;">
					<h1 class="text-white">LISTADO DE EMPLEADOS</h1>
		    	</div>
		    	<div class="col-sm-6" style="text-align: right;">
					<a class="btn btn-success" onclick="document.getElementById('inputNombre').focus();" data-toggle="modal" href="#nuevoEmpleado">
						<i class="material-icons"></i>
						<span>NUEVO EMPLEADO</span>
					</a>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-sm-8"></div>
		    	<div class="col-sm-4">
		    		<br>
		    		<div id="busquedaEmpleado">
		    			<form action="res/api/muestra.php" method="POST">
		    				<div class="input-group">
		    					<input type="text" class="form-control validate" id="inputBusqueda" name="inputBusqueda" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" placeholder="BUSCAR" required />
            					<button id="buttonSearch" class="crud-submit-show col-md-auto btn btn-success" type="submit" title="Buscar">
	              					<i class="large material-icons">search</i>
    	        				</button>
		    				</div>
		      			</form>
		      		</div>
		    	</div>
			</div>
		</div>
		
		<div class="container" style="padding-top: 2%;">
			<table class="table table-bordered">
				<thead>
			    	<tr>
						<th>Nombre</th>
						<th>Apellido</th>
						<th>Email</th>
						<th>Telefono</th>
						<th width="200px">Acciones</th>
			    	</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<ul id="pagination" class="pagination-sm"></ul>
		</div>



	    <!-- Modal para NUEVO EMPLEADO -->
		<div class="modal" tabindex="-1" role="dialog" id="nuevoEmpleado">
  			<div class="modal-dialog" role="document">
	    		<div class="modal-content">
					<div class="modal-header" style="background-color: rgba(67,81,135, 0.8);">
						<h5 class="modal-title text-white">ALTA EMPLEADO</h5>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true" class="text-white">&times;</span>
        				</button>
      				</div>
      				<div class="modal-body">
	        			<form action="res/api/alta.php" method="POST">
		      				<div class="form-label-group">
		      					<label for="inputNombre">Nombre</label>
        						<input type="text" name="inputNombre" class="form-control" required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
      						</div>

							<div class="form-group" style="padding-top: 3%;">
								<label class="control-label" for="apellido">Apellido</label>
								<input type="text" name="inputApellido" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
							</div>

							<div class="form-group" style="padding-top: 2%;">
								<label class="control-label" for="email">Email</label>
								<input type="email" name="inputEmail" class="form-control" required >
							</div>

							<div class="form-group" style="padding-top: 2%;">
								<label class="control-label" for="telefono">Teléfono</label>
								<input type="text" name="inputTelefono" class="form-control" required onkeypress="return justNumbers(event);">
							</div>

							<div class="form-group" style="text-align: right;">
								<button type="submit" class="btn crud-submit btn-success">GUARDAR</button>
								<button type="button" class="btn btn-warning" class="close" data-dismiss="modal">CANCELAR</button>
							</div>
		      			</form>
    	  			</div>
    			</div>
  			</div>
		</div>

		<!-- Modal para ACTUALIZAR EMPLEADO -->
		<div class="modal" tabindex="-1" role="dialog" id="actEmpleado">
  			<div class="modal-dialog" role="document">
	    		<div class="modal-content">
					<div class="modal-header" style="background-color: rgba(67,81,135, 0.8);">
						<h5 class="modal-title text-white">ACTUALIZA EMPLEADO</h5>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true" class="text-white">&times;</span>
        				</button>
      				</div>
      				<div class="modal-body">
	        			<form data-toggle="validator" action="res/api/actualiza.php" method="PUT">
	        				<input type="hidden" name="id" class="idEditar">
		      				<div class="form-label-group">
		      					<label for="inputActNombre">Nombre</label>
        						<input type="text" name="inputActNombre" class="form-control" required autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
      						</div>

							<div class="form-group" style="padding-top: 3%;">
								<label class="control-label" for="inputActApellido">Apellido</label>
								<input type="text" name="inputActApellido" class="form-control" required style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
							</div>

							<div class="form-group" style="padding-top: 2%;">
								<label class="control-label" for="inputActEmail">Email</label>
								<input type="email" name="inputActEmail" class="form-control" required >
							</div>

							<div class="form-group" style="padding-top: 2%;">
								<label class="control-label" for="inputActTelefono">Teléfono</label>
								<input type="text" name="inputActTelefono" class="form-control" required onkeypress="return justNumbers(event);">
							</div>

							<div class="form-group" style="text-align: right;">
								<button type="submit" class="btn crud-submit-edit btn-success">ACTUALIZAR</button>
								<button type="button" class="btn btn-warning" class="close" data-dismiss="modal">CANCELAR</button>
							</div>
		      			</form>
    	  			</div>
    			</div>
  			</div>
		</div>
		
		<footer style="bottom: 0;width: 100%;height: 4rem;">
  			<!-- Copyright -->
  			<div class="footer-copyright text-center py-3">© 2019 Copyright:
    			<a href="#"> Braulio Arambula Martinez</a>
  			</div>
		</footer>
	</body>
</html>