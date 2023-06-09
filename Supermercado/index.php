<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	
</head>
<body>
	<div class="login-box">
		<h1>Log In</h1>
		<form class="form_ingreso" method="post" action="index.php"> 
			<label for="username">Nombre de usuario</label>
			<input required maxlength=32 type="text" id="" name="user" placeholder="Ingrese su usuario" class="fondo">
			<label for="password">Contraseña</label>
			<input required maxlength=32 type="password" id="" name="password" placeholder="Ingrese su contraseña" class="fondo">
			<input type="submit" value="Iniciar sesión" name="ingresar">
		</form>
	</div>
	
	<?php
		$ingresado = false;
		if(isset($_POST['ingresar'])){
			$conn = mysqli_connect("localhost", "root", "", "supermercado");
			
			if (!$conn) {
				die("Conexión fallida: " . mysqli_connect_error());
			}

			$user = $_POST["user"];
			$password = $_POST['password'];

			$sql = "SELECT id, user, pass FROM usuarios WHERE user = '$user'";

			$ejecutar = mysqli_query($conn, $sql);
			$fila = mysqli_fetch_array($ejecutar);

			if($password == $fila['pass']){
				$ingresado = true;
			}
			else echo "Contraseña incorrecta";

            mysqli_close($conn);
		}
		if($ingresado == true){
			
			?>
			<style>
				.login-box{
					display: none;
				}
				.titulo{
					display: flex;
				}
				.form_registro, .form_busqueda{
					display: block;
				}
			</style>
			<?php
		}
	?>
    <section class="titulo">
        <h2>Registro de Productos</h2>
    </section>
    <form class="form_registro" action="#" method="POST" enctype="multipart/form-data">
        <label>Nombre del Producto:</label>
        <input type="text" maxlength=32 name="nombre" required>
        
        <label>Precio (ARS) s/IVA:</label>
        <input type="number" maxlength=20 min=0.01 step="0.01" name="precio" required>
        
        <label>Peso en KG:</label>
        <input type="number" min=0.01 step="0.01" name="peso" required>
        
        <label>Proveedor:</label>
        <input type="text" maxlength=64 name="proveedor" required>
        
        <label>Imagen:</label>
        <input type="text" maxlength=400 name="imagen" required>
        <br>
        <input type="submit" value="Registrar" name="registrar">
    </form>
	<?php
		if(isset($_POST['registrar'])){
			$conn = mysqli_connect("localhost", "root", "", "supermercado");
			
			if (!$conn) {
				die("Conexión fallida: " . mysqli_connect_error());
			}

			$nombreProd = $_POST["nombre"];
			$precioProd = $_POST['precio'];
			$pesoProd = $_POST['peso'];
			$proveedor = $_POST['proveedor'];
			$imagen = $_POST['imagen'];


			$sql = "INSERT INTO producto (nombre, peso, foto, precio, proveedor) 
			VALUES ( '$nombreProd', '$pesoProd', '$imagen', '$precioProd', '$proveedor')";

			$ejecutar = mysqli_query($conn, $sql);
			
            mysqli_close($conn);
			?>
			<style>
				.login-box{
					display: none;
				}
				.titulo{
					display: flex;
				}
				.form_registro, .form_busqueda{
					display: block;
				}
			</style>
			<?php
		}
	?>
    <section class="titulo">
        <h2>Búsqueda de Productos</h2>
    </section>
    <form class="form_busqueda" action="#" method="POST" enctype="multipart/form-data">
		<label for="busqueda">Nombre del producto:</label>
		<input type="text" name="busqueda" placeholder="Buscar producto...">
		<input type="submit" value="Buscar" name="buscar">
    </form>

	<?php
		if(isset($_POST['buscar'])){
			$conn = mysqli_connect("localhost", "root", "", "supermercado");
			
			if (!$conn) {
				die("Conexión fallida: " . mysqli_connect_error());
			}

			$busqueda = $_POST["busqueda"];


			$sql = "SELECT * FROM producto WHERE nombre = '$busqueda'";

			$ejecutar = mysqli_query($conn, $sql);
            $fila = mysqli_fetch_array($ejecutar);
			$precio = $fila['precio'];

            mysqli_close($conn);

			if(isset($fila['nombre'])){
				?>
				<div class="producto">
					<img src="<?php echo $fila['foto'];?>" alt="">
					<div class="prod_info">
						<h3><?php echo $fila['nombre'];?></h3>
						<h4>- Peso: <?php echo $fila['peso'];?> kg.</h4>
						<h4>- Precio c/ IVA: $<?php echo $precio+($precio*0.21);?></h4>
						<h4>- Proveedor: <?php echo $fila['proveedor'];?></h4>
				
						
						<style>
							.login-box{
								display: none;
							}
							.titulo{
								display: flex;
							}
							.form_registro, .form_busqueda{
								display: block;
							}
						</style>
						
					</div>
				</div>
				<?php
			}
			else{
				echo "<h4> El producto no existe </h4>";
				?>
				<style>
					.login-box{
						display: none;
					}
					.titulo{
						display: flex;
					}
					.form_registro, .form_busqueda{
						display: block;
					}
				</style>
				<?php
			}
		}
	?>
</body>
</html>
