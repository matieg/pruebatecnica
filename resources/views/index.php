<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Prueba técnica</title>
    <?php include '../resources/templates/head.php' ?>
</head>
<body>
    <section class="container">
        <div id="login" class="login">
            <form action="" method="post" class="form-container" onsubmit="return validation();">
                <h1>Login</h1>

                <?php if(isset($message)): ?>
                <div class="message message-error"> <p> <?= $message ?? '' ?> </p> </div>
                <?php endif; ?>
                
                <?php if( $sessionMessage = getMessage() ): ?>
                    <div class="form-container message <?= $sessionMessage->type ?>">
                        <p class="text-center"> <?= $sessionMessage->text ?> </p> 
                    </div>
                <?php endif ?>

                <div class="input-container">
                    <label for="">Usuario</label>
                    <span class="tooltip d-none">Por favor ingrese el nombre de usuario.</span>
                    <input type="text" name="username" class="validate">
                </div>
                <div class="input-container">
                    <label for="">Contraseña</label>
                    <span class="tooltip d-none">Por favor ingrese su contraseña.</span>
                    <input type="password" name="password" class="validate">
                </div>
                <div class="d-flex justify-content-end">
                    <a href="register" class="btn">Registrarme</a>
                    <button class="btn btn-primary">Ingresar</button>
                </div>
            </form>
        </div>
    </section>
    <?php include '../resources/templates/scripts.php' ?>
</body>
</html>