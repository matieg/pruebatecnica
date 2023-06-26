<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin - Listado de usuarios</title>
    <?php include '../resources/templates/head.php' ?>
</head>
<body class="container container-admin">
    <header>
        <h3>Bienvenido <?= auth()->name ?? '' ?></h3>
    </header>

    <?php include '../resources/templates/nav.php'; ?>
    <section class="section-container">
        <article class="card">
            <div class="card-header">
                <h1>Listado de usuarios</h1>
            </div>
            <div class="card-container">
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
                                <form class="d-flex" action="user/delete/<?= $user->id ?>" method="POST">                                    
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
</body>
</html>