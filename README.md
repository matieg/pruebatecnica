# Prueba técnica

Este proyecto se ejecuta utilizando php 8.
Podes ejecutarlo usando XAMPP o con Docker.
## Opciones de ejecucion
- Opción 1: XAMPP.
- Opción 2: Docker.

## Ejecución con XAMPP

Abrir cmd

Dirigirme a la carpeta en la que se va a alojar el proyecto, en este caso seria: xampp/htdocs
Luego ejecutar el comando git para clonarlo.

Ejemplo:
```cmd
C:\xampp\htdocs>git clone https://github.com/matieg/pruebatecnica.git
```

Luego debemos ingresar al navegador web y escribir la url para crear la base de datos y el usuario de prueba:
http://localhost/pruebatecnica/create-db


Ahora podemos ir a la raíz del proyecto y empezar a usarlo:
http://localhost/pruebatecnica

- **Usuario** = user
- **Contraseña** = 123456


## Ejecución con docker

Dirigirme a la carpeta en la que se va a alojar el proyecto y ejecutar el comando git para clonarlo.

```shell
git clone https://github.com/matieg/pruebatecnica.git
```

Dirigirme a la carpeta dentro del proyecto:
```shell
cd pruebatecnica
```

Cambiar en el archivo .env, que se encuentra en la raiz del proyecto, las variables de entorno correspondientes a docker.
Para esto comentar la seccion "otros" y descomentar la seccion "docker".

Ejemplo:
```.env
#OTROS
# DB_CONNECTION=mysql
# DB_HOST=localhost
# DB_PORT=3306
# DB_DATABASE=pruebatecnica
# DB_USERNAME=root
# DB_PASSWORD=

#DOCKER
DB_CONNECTION=mysql
DB_HOST=pruebatecnica-bd
DB_PORT=3306
DB_DATABASE=pruebatecnica
DB_USERNAME=workanda
DB_PASSWORD=workanda
```

Una vez echo esto, moverme a la carpeta docker y ejectuar el comando para inicializarlo:
Ejecutar el comando docker:

```shell
cd docker
docker-compose up --build -d
```

En este punto docker iniciara el proyecto, con apache, php 8, mysql y phpmyadmin para ver la BD.
Tambien genera la base de datos con un usuario de prueba.

- **Para ejecutar el proyecto** = Abrir el navegador y escribir en la URL: http://localhost:8083
- **Para ejecutar el phpmyadmin** = Abrir el navegador y escribir en la URL: http://localhost:9992

Nota: Se eligieron esos puertos para tratar de evitar confictos con los puertos que normalmente se peuden tener en uso.

### las credenciales del usuario de prueba para el proyecto son:

- **Usuario** = user
- **Contraseña** = 123456


### Contraseñas phpmyadmin
Para ingresar podemos hacerlo con el usuario root y para este caso, no tiene contraseña (dejarla en blanco)






