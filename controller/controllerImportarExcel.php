<?php
/**
 * Ejemplo de cómo usar PDO y PHPSpreadSheet para
 * importar datos de Excel a MySQL de manera
 * fácil, rápida y segura
 *
 * @author Antony Culqui Carranza
 *
 */

# Cargar clases instaladas por Composer
require_once "../vendor/autoload.php";

# Nuestra base de datos
require_once "controllerConexion.php";

# Indicar que usaremos el IOFactory
use PhpOffice\PhpSpreadsheet\IOFactory;

# Obtener conexión o salir en caso de error, mira bd.php
$bd = obtenerBD();

# Guardamos el documento recibido desde el formulario
$nombre_doc = $_FILES["documento"]['name'];
$ruta = "../" . $nombre_doc;
move_uploaded_file($_FILES["documento"]['tmp_name'], $ruta);

# El archivo a importar
# Recomiendo poner la ruta absoluta si no está junto al script
$rutaArchivo = $ruta;
$documento   = IOFactory::load($rutaArchivo);

# Se espera que en la primera hoja estén los productos
$hojaDeProductos = $documento->getSheet(0);

# Preparar base de datos para que los inserts sean rápidos
$bd->beginTransaction();

# Preparar sentencia de categorias
$sentencia = $bd->prepare("insert into catsearch
    (categoria ) values (?)");

# Calcular el máximo valor de la fila como entero, es decir, el
# límite de nuestro ciclo
$numeroMayorDeFila   = $hojaDeProductos->getHighestRow(); // Numérico
$letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
# Convertir la letra al número de columna correspondiente
$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

// Recorrer filas; comenzar en la fila 2 porque omitimos el encabezado
for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {

    # Las columnas están en este orden:
    # Categoria
    $categoria = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
    $sentencia->execute([$categoria]);
}

# Ahora vamos con los fabricantes
$sentencia = $bd->prepare("insert into fabricantesearch
    (categoria_id, fabricante) values (?, ?)");

# Se espera que en la segunda hoja estén los fabricantes
$hojaDeClientes = $documento->getSheet(1);

# Calcular el máximo valor de la fila como entero, es decir, el
# límite de nuestro ciclo
$numeroMayorDeFila   = $hojaDeClientes->getHighestRow(); // Numérico
$letraMayorDeColumna = $hojaDeClientes->getHighestColumn(); // Letra
# Convertir la letra al número de columna correspondiente
$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

// Recorrer filas; comenzar en la fila 2 porque omitimos el encabezado
for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {

    # Las columnas están en este orden:
    # Categoria_id, Fabricante
    $categoria_id = $hojaDeClientes->getCellByColumnAndRow(1, $indiceFila);
    $fabricante   = $hojaDeClientes->getCellByColumnAndRow(2, $indiceFila);
    $sentencia->execute([$categoria_id, $fabricante]);
}

# Ahora vamos con los productos
$sentencia = $bd->prepare("insert into productosearch
    (categoria_id, fabricante_id, producto, aprobacion, enlace) values (?, ?, ?, ?, ?)");

# Se espera que en la tercera hoja estén los productos
$hojaDeClientes = $documento->getSheet(2);

# Calcular el máximo valor de la fila como entero, es decir, el
# límite de nuestro ciclo
$numeroMayorDeFila   = $hojaDeClientes->getHighestRow(); // Numérico
$letraMayorDeColumna = $hojaDeClientes->getHighestColumn(); // Letra
# Convertir la letra al número de columna correspondiente
$numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

// Recorrer filas; comenzar en la fila 2 porque omitimos el encabezado
for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {

    # Las columnas están en este orden:
    # Categoria_id, Fabricante_id, Producto, Aprobación, Enlace.
    $categoria_id  = $hojaDeClientes->getCellByColumnAndRow(1, $indiceFila);
    $fabricante_id = $hojaDeClientes->getCellByColumnAndRow(2, $indiceFila);
    $producto      = $hojaDeClientes->getCellByColumnAndRow(3, $indiceFila);
    $aprobacion    = $hojaDeClientes->getCellByColumnAndRow(4, $indiceFila);
    $enlace        = $hojaDeClientes->getCellByColumnAndRow(5, $indiceFila);
    $sentencia->execute([$categoria_id, $fabricante_id, $producto, $aprobacion, $enlace]);
}

# Hacer commit para guardar cambios de la base de datos
$bd->commit();

# Se devuelve al index con un mensaje de confirmación
header("Location:../index.php?mensaje=Confirmado");
