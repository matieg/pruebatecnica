<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include '../resources/templates/head.php' ?>
</head>
<body>
    <section class="container">
        <div id="login" class="login">
            <form action="login" method="post" class="form-container">
                <h1>Login</h1>

                <?php if(isset($message)): ?>
                <div class="message message-error"> <p> <?= $message ?? '' ?> </p> </div>
                <?php endif; ?>

                <div class="input-container">
                    <label for="">Usuario</label>
                    <input type="text" name="username">
                </div>
                <div class="input-container">
                    <label for="">Contraseña</label>
                    <input type="password" name="password">
                </div>
                <div class="d-flex justify-content-center flex-column">
                    <a href="">Registrarme</a>
                    <button>Login</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>