<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Crear Usuario</title>
    <?php include '../resources/templates/head.php' ?>
</head>
<body class="container-admin">

    <?php include '../resources/templates/header.php'; ?>
    <?php include '../resources/templates/nav.php'; ?>
    <?php include '../resources/templates/dialog.php'; ?>
    
    <section class="section-container">
        <article class="card">
            <div class="card-header">
                <h1>Crear usuarios</h1>
            </div>
            <div class="card-container">
                <form action="user/create" method="POST" class="form-container" onsubmit="return dialogValidation('¿Desea confirmar la creación de este usuario?');">
                    <?php if(isset($message)): ?>
                        <div class="message message-error"> <p class="text-center"> <?= $message ?? '' ?> </p> </div>
                    <?php endif; ?>
                    <div class="input-container">
                        <label for="">Nombre</label>
                        <span class="tooltip d-none">Campo requerido.</span>
                        <input type="text" name="name" class="validate">
                    </div>
                    <div class="input-container">
                        <label for="">Nombre de Usuario</label>
                        <span class="tooltip d-none">Campo requerido.</span>
                        <input type="text" name="username" class="validate">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success">Guardar</button>
                    </div>
                </form>                
            </div>
        </article>
    </section>
    <?php include '../resources/templates/scripts.php' ?>
    <script>
        const dialogValidation = (message) => {
            if(validation())
                openDialog(message);
            return false;
        }
    </script>
</body>
</html>