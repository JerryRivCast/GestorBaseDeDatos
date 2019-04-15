<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Practica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <a href = "index.php">Alta de Alumnos</a>
    <a href = "busqueda.php">Búsqueda de Alumnos</a>
    <a href = "bajas.php">Baja de Alumnos</a>
    <a href = "modificar.php">Modificacion de Alumnos</a>
    <br><br>
    <?php
        $nombre = $_REQUEST['nombre'];
        $pais = $_REQUEST['codigopais'];
        $cta = $_REQUEST['num_cta'];

        modificarAlumno($nombre,$pais,$cta);
    ?>
</body>
</html>

<?php
function modificarAlumno($nombre,$pais,$cta)
{
    include 'credenciales.php';
    $conn = new mysqli($host_name,$user_name,$password,$database);

    if($conn->connect_error)
    {
        die('<p>Error al concectar con servidor MYSQL: '.mysqli_connect_error().'</p>');
    }
    else
    {
        if (!empty($nombre))
        {
            if (!empty($pais) && !empty($cta))
            {
                $sql = "UPDATE alumnos set pais = $pais, numero_cuenta = $cta where nombre = '$nombre';";
            }
            else if (!empty($pais) && empty($cta))
            {
                $sql = "UPDATE alumnos set pais = $pais where nombre = '$nombre';";
            }
            else if (empty($pais) && !empty($cta))
            {
                $sql = "UPDATE alumnos set numero_cuenta = $cta where nombre = '$nombre';";
            }
            else
            { echo '<p>Error, no se encontraron campos para la modificacion del registro</p>'; }
            $conn->query($sql);
        }
        else
        { echo '<p>Error, no se ingreso un nombre valido para la modificacion del registro</p>'; }
        
        
        $sql2 = "SELECT * from alumnos";
        $res = $conn->query($sql2); 
        echo '<h1 align="center">listado de Alumnos</h1>
              <table width="70%" border="1px" align="center">
              <tr  align="center">
                <td>Nombre</td>
                <td>Edad</td>
                <td>A_Paterno</td>
                <td>A_Materno</td>
                <td>Num_Cta</td>
                <td>Direccion</td>
                <td>Pais</td>
                <td>Telefono</td>
              </tr>';
        while($valores = mysqli_fetch_array($res))
        {
            echo '<tr align="center">
                    <td>'.$valores[0].'</td>
                    <td>'.$valores[1].'</td>
                    <td>'.$valores[2].'</td>
                    <td>'.$valores[3].'</td>
                    <td>'.$valores[4].'</td>
                    <td>'.$valores[5].'</td>
                    <td>'.$valores[6].'</td>
                    <td>'.$valores[7].'</td>
                  </tr>';
            
        }
        echo '</table>';
    }
    $conn->close();
}
?>