# Prueba técnica

Este proyecto se ejecuta utilizando php 8.
Podes ejecutarlo usando XAMPP o con Docker.

## Ejecución con docker

Dirigirme a la carpeta en la que se va a alojar el proyecto y ejecutar el comando git para clonarlo.

```cmd
git clone https://github.com/matieg/pruebatecnica.git
```

Dirigirme a la carpeta dentro del proyecto:
```cmd
cd pruebatecnica
```

Cambiar en el archivo .env que se encuentra en la raiz del proyecto, las variables de entorno correspondientes a docker.
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

```cmd
cd docker
docker-compose up --build -d
```

En este punto docker iniciara el proyecto, con apache, php 8, mysql y phpmyadmin para ver la BD.

- **Para ejecutar el proyecto** = Abrir el navegador y escribir en la URL: http://localhost:8083
- **Para ejecutar el phpmyadmin** = Abrir el navegador y escribir en la URL: http://localhost:9992

### Contraseñas phpmyadmin
Para ingresar podemos hacerlo con el usuario root y para este caso, no tiene contraseña (dejarla en blanco)
