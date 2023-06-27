<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin - Listado de usuarios</title>
    <?php include '../resources/templates/head.php' ?>
</head>
<body class="container container-admin">

    <?php include '../resources/templates/header.php'; ?>
    <?php include '../resources/templates/nav.php'; ?>
    <?php include '../resources/templates/dialog.php'; ?>

    <section class="section-container">
        <article class="card">
            <div class="card-header">
                <h1>Listado de usuarios</h1>
            </div>
            <div class="card-container">

                <?php if( $sessionMessage = getMessage() ): ?>
                    <div class="form-container message <?= $sessionMessage->type ?>">
                        <p class="text-center"> <?= $sessionMessage->text ?> </p> 
                    </div>
                <?php endif ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Nombre de usuario</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= $user->name ?></td>
                            <td><?= $user->username ?></td>
                            <td class="d-flex flex-row">
                                <form class="d-flex" id="deleteUser" action="user/delete/<?= $user->id ?>" method="POST" onsubmit="return openDialog('Esta a punto de eliminar a este usuario. ¿Desea continuar?');">
                                    <button class="btn btn-danger">Eliminar</button>
                                </form>
                                <a href="<?= 'user/'.$user->id; ?>" class="btn btn-primary">Editar</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
    <?php include '../resources/templates/scripts.php' ?>
</body>
</html>