<?php
$Titulo = " Usuario ";
include_once("../estructura/cabeceraBT.php");
$datos = data_submitted();

$objC = new ABMUsuario();
$obj = NULL;
if (isset($datos['dni']) && $datos['dni'] <> -1){
    $listaTabla = $objC->buscar($datos);
    if (count($listaTabla)==1){
        $obj= $listaTabla[0];
    }
}

?>	
<form method="post" action="accion.php" id="formulario">
    <input id="dni" name ="dni" type="hidden" value="<?php echo ($obj !=null) ? $obj->getDni() : "-1"?>" readonly required >
    <input id="accion" name ="accion" value="<?php echo ($datos['accion'] !=null) ? $datos['accion'] : "nose"?>" type="hidden">
    <div class="row mb-12">
        <div class="col-sm-12 ">
            <div class="form-group has-feedback">
                <label for="dni" class="control-label">DNI:</label>
                <div class="input-group">
                    <input id="dni" name="dni" type="number" class="form-control" value="<?php echo ($obj !=null) ? $obj->getDni() : ""?>" <?php echo ($obj !=null) ? "readonly" : ""?>>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label for="nombre" class="control-label">Nombre:</label>
                <div class="input-group">
                    <input id="nombre" name="nombre" type="text" class="form-control" value="<?php echo ($obj !=null) ? $obj->getNombre() : ""?>">
                </div>
            </div>
            <div class="form-group has-feedback">
                <label for="email" class="control-label">Correo:</label>
                <div class="input-group">
                    <input id="email" name="email" type="email" class="form-control" value="<?php echo ($obj !=null) ? $obj->getEmail() : ""?>">
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