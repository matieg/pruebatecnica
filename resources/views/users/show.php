<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Crear Usuario</title>
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
                <form action="create" method="POST" class="form-container">
                    <?php if(isset($message)): ?>
                        <div class="message message-error"> <p class="text-center"> <?= $message ?? '' ?> </p> </div>
                    <?php endif; ?>
                    <div class="input-container">
                        <label for="">Nombre</label>
                        <input type="text" name="name">
                    </div>
                    <div class="input-container">
                        <label for="">Nombre de Usuario</label>
                        <input type="text" name="username">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success">Guardar</button>
                    </div>
                </form>                
            </div>
        </article>
    </section>
</body>
</html>