<nav>
    <h2 class="text-white">Admin</h2>
    <ul>
        <li>
            <a href="home">Ver Usuarios</a>
        </li>
        <li>
            <a href="user/create">Crear Usuario</a>
        </li>
        <li>
            <a href="user/<?= auth()->id ?>">Modificar mis datos</a>
        </li>
        <li>
            <a href="logout">Salir</a>
        </li>
    </ul>
</nav>