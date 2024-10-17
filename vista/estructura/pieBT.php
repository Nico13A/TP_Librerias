</main>
</div>

<footer class="footer mt-auto py-3 bg-dark">
    <div class="container">

        <p class="text-white"><?php echo $idiomas[$idiomaSeleccionado]['footer_text']; ?></p>
        <p class="text-white">
            <a href="index.php"><?php echo $idiomas[$idiomaSeleccionado]['volver_arriba']; ?></a>
        </p>

    </div>
</footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../../vista/js/jquery/jquery-3.5.1.slim.min.js"></script>
<script src="../../vista/js/popper/popper.min.js"></script>
<script src="../../vista/js/bootstrap/4.5.2/bootstrap.min.js"></script>
<script src="../../vista/js/bootstrap/4.5.2/bootstrapValidator.min.js"></script>

<script type="text/javascript" src="../../vista/js/bootstrap/4.5.2/validator.js"></script>

<script>
        $(document).ready(function() {
            $('#formulario').bootstrapValidator({
                fields: {
                    dni: {
                        validators: {
                            notEmpty: {
                                message: 'El DNI es obligatorio y no puede estar vacío'
                            },
                            numeric: {
                                message: 'El DNI debe ser un número'
                            }
                        }
                    },
                    nombre: {
                        validators: {
                            notEmpty: {
                                message: 'El nombre es obligatorio y no puede estar vacío'
                            },
                            stringLength: {
                                min: 5,
                                max: 50,
                                message: 'El nombre debe tener entre 5 y 50 caracteres'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'El correo es obligatorio y no puede estar vacío'
                            },
                            emailAddress: {
                                message: 'El correo no es válido'
                            }
                        }
                    }
                }
            });
        });
</script>

</body>
</html>