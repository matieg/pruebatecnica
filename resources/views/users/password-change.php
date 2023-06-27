<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cambiar Contraseña</title>
    <?php include '../resources/templates/head.php' ?>
</head>
<body class="container-admin">
    <header>
    </header>
    <?php include '../resources/templates/nav.php'; ?>
    <section class="section-container">
        <article class="card">
            <div class="card-header">
                <h1>Crear usuarios</h1>
            </div>
            <div class="card-container">
                <form action="password/change" method="POST" class="form-container" onsubmit="return validationPassword();">
                    <?php if(isset($message)): ?>
                        <div class="message message-error"> <p class="text-center"> <?= $message ?? '' ?> </p> </div>
                    <?php endif; ?>
                    <div class="input-container">
                        <label for="">Contraseña</label>
                        <span class="tooltip d-none">Campo requerido.</span>
                        <input type="password" id="password" name="password" class="validate validate-password">
                    </div>
                    <div class="input-container">
                        <label for="">Contraseña nueva</label>
                        <span class="tooltip d-none">Campo requerido.</span>
                        <input type="password" id="newpassword" name="newpassword" class="validate validate-password">
                    </div>
                    <div class="input-container">
                        <label for="">Repetir Contraseña</label>
                        <span class="tooltip d-none">Campo requerido.</span>
                        <input type="password" id="repeatpassword" name="repeatpassword" class="validate validate-password">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success">Guardar</button>
                    </div>
                </form>                
            </div>
        </article>
    </section>
    <?php include '../resources/templates/scripts.php' ?>
</body>
</html>