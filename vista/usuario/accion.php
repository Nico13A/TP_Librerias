<?php

include_once("../estructura/cabeceraBT.php");
include_once "../../utiles/vendor/autoload.php";

function mostrarErrores($erroresArray) {
    $html = '<div class="alert alert-danger">';
    $html .= '<h4>Errores encontrados:</h4><ul>';
    
    foreach ($erroresArray['errores'] as $campo => $erroresCampo) {
        $html .= "<li>" . ucfirst($campo) .":</li>";
        $html .= "<ul>";
        foreach ($erroresCampo as $mensaje) {
            $html .= "<li><strong>Problema:</strong> $mensaje</li>";
        }
        $html .= "</ul>";
    }
    
    $html .= '</u></div>';
    return $html;
}

$objTrans = new ABMUsuario();

if (!isset($datos)) {
    $datos = data_submitted();
}

if (isset($datos['accion'])) {
    switch ($datos['accion']) {
        case 'listar':
            $lista =  convert_array($objTrans->buscar(null));
            break;
        default:
            $mensaje = "";
            $resultado = $objTrans->abm($datos);
            if ($resultado['exito']) {
                $mensaje = "La acción " . $datos['accion'] . " se realizó correctamente.";
                echo("<script>location.href = './index.php?msg=$mensaje';</script>");
            } else {
                $mensaje = "La acción " . $datos['accion'] . " no se realizó correctamente.";
                if (!empty($resultado['errores'])) {
                    $mensaje .= mostrarErrores($resultado);
                    echo $mensaje;
                    echo "<a href='./index.php'>Volver</a>";
                }
                else {
                    echo("<script>location.href = './index.php?msg=$mensaje';</script>");
                }

            }
    }
} else {
    $mensaje = "<p class='text-warning'>No se especificó ninguna acción.</p>";
}

?>

