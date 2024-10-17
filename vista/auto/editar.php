<?php
$Titulo = " Auto ";
include_once("../estructura/cabeceraBT.php");
$datos = data_submitted();

$objCU = new ABMUsuario();
$objC = new ABMAuto();

$obj = NULL;
if (isset($datos['patente']) && $datos['patente'] <> -1){
    $listaAuto = $objC->buscar($datos);
    if (count($listaAuto)==1){
        $obj= $listaAuto[0];
    }
}

$listaUsuario = $objCU->buscar(null);

?>	
<form method="post" action="accion.php" novalidate>
    <input id="patente" name ="patente" type="hidden" value="<?php echo ($obj !=null) ? $obj->getPatente() : "-1"?>" readonly required >
    <input id="accion" name ="accion" value="<?php echo ($datos['accion'] !=null) ? $datos['accion'] : "nose"?>" type="hidden">
    <div class="row mb-12">
        <div class="col-sm-12 ">
            <div class="form-group">
                <label for="patente" class="control-label">Patente:</label>
                <input id="patente" name ="patente" type="text" class="form-control" value="<?php echo ($obj !=null) ? $obj->getPatente() : ""?>" <?php echo ($obj !=null) ? "readonly" : ""?> required pattern="^[A-Z]{3}\s\d{3}$">
                <div class="invalid-feedback">Por favor ingrese una patente válida de tipo (ABC 123).</div>
            </div>
        </div>
    </div>

    <div class="row mb-12">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="marca" class="control-label">Marca:</label>
                <input id="marca" name ="marca" type="text" class="form-control" value="<?php echo  ($obj !=null) ? $obj->getMarca() : "" ?>"  required>
                <div class="invalid-feedback">Por favor ingrese una marca válida.</div>
            </div>
        </div>
    </div>

    <div class="row mb-12">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="modelo" class="control-label">Modelo:</label>
                <input id="modelo" name ="modelo" type="text" class="form-control" value="<?php echo  ($obj !=null) ? $obj->getModelo() : "" ?>"  required>
                <div class="invalid-feedback">Por favor ingrese un modelo válido.</div>
            </div>
        </div>
    </div>

    <div class="row mb-12">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="anio" class="control-label">Año:</label>
                <input id="anio" name ="anio" type="text" class="form-control" value="<?php echo  ($obj !=null) ? $obj->getAnio() : "" ?>"  required pattern="^(20[0-9]{2}|2100)$">
                <div class="invalid-feedback">Por favor ingrese un año válido (del 2000 en adelante).</div>
            </div>
        </div>
    </div>

    <div class="row mb-12">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="dni_usuario" class="control-label">Dueño:</label>
                <div class="input-group">
                    <select class="form-control" id="dni_usuario" name="dni_usuario" >
                        <?php
                        foreach ($listaUsuario as $usuario):
                            if ($obj != null && $obj->getObjUsuario()->getDni()==$usuario->getDni())
                                echo '<option selected value="'.$usuario->getDni().'">'. $usuario->getDni() .' </option>';
                            else
                                echo '<option value="'.$usuario->getDni().'">'. $usuario->getDni() .'</option>';
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <input type="submit" class="btn btn-primary btn-block" value="<?php echo ($datos['accion'] !=null) ? $datos['accion'] : "nose"?>">
</form>

<a href="index.php">Volver</a>

<?php
include_once("../estructura/pieBT.php");
?>