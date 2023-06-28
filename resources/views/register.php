<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Prueba técnica</title>
    <?php include '../resources/templates/head.php' ?>
</head>
<body>
    <section class="container">
        <div id="login" class="login">
            <form action="register" method="post" class="form-container" onsubmit="return validation();">
                <h1>Registrarme</h1>

                <?php if( $sessionMessage = getMessage() ): ?>
                    <div class="form-container message <?= $sessionMessage->type ?>">
                        <p class="text-center"> <?= $sessionMessage->text ?> </p> 
                    </div>
                <?php endif ?>

                <div class="input-container">
                    <label for="">Nombre</label>
                    <span class="tooltip d-none">Por favor ingrese su nombre.</span>
                    <input type="text" name="name" class="validate">
                </div>
                <div class="input-container">
                    <label for="">Nombre de usuario</label>
                    <span class="tooltip d-none">Por favor ingrese su nombre de usuario.</span>
                    <input type="text" name="username" class="validate">
                </div>
                <div class="input-container">
                    <label for="">Contraseña</label>
                    <span class="tooltip d-none">Por favor ingrese su contraseña.</span>
                    <input type="password" name="password" class="validate">
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary">Registrarme</button>
                </div>
            </form>
        </div>
    </section>
    <?php include '../resources/templates/scripts.php' ?>
</body>
</html>