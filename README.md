# <img src="./public/favicon.ico" alt="Hosteleria DAW" width="56"/> Hosteleria DAW

[![Open Source Love png2](https://badges.frapsoft.com/os/v2/open-source.png?v=103)](https://hosteleria.herokuapp.com) [![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://hosteleria.herokuapp.com)

Inicia sesión o regístrate, añade productos a tu carrito, realiza el pedido y... ¡disfruta de tu pedido!

[Consultar el manual de usuario.](https://docs.google.com/document/d/1uOFJb3ja7CcJPsTojjTWToZ6t7TdbQ0FTmgqhT4h2y8/edit?usp=sharing)  

[¡Visita la aplicación y pruébala!](https://hosteleria.herokuapp.com)  

Credenciales para probar con usuarios ya existentes:
- **Administrador**: raul.melgosa / 12345Abcde
- **Cliente**: irune.mendez / 12345Abcde


# Proyecto DAW

> ## **Gestor de pedidos online para hostelería**
> La Escuela de Hostelería quiere comenzar a gestionar los pedidos de sus clientes mediante una aplicación web y ha contactado con vosotros para llevar a cabo el desarrollo.  
> Actualmente únicamente disponen de una página web con un listado de productos y precios.  
>   
> La idea que tienen en mente es, por un lado, disponer como mínimo de un catálogo de productos online que ellos mismos puedan gestionar mediante un usuario administrador, y por otro lado, una web responsive que los usuarios puedan visitar para realizar sus pedidos. También han pensado, como funcionalidades extra, que los administradores podrían gestionar el estado de cada pedido (recibido, en proceso, preparado), ver estadísticas de los pedidos recibidos, avisos automáticos a clientes cuando el pedido esté listo, etc.  

## Grupo 1
- Raúl Melgosa
- Daniel Tamargo

---- 

# Set up del proyecto

Partiendo de que ya tenemos Laravel (homestead) funcionando, realizamos una serie de pasos para configurar el proyecto y poder trabajar todos juntos sobre el mismo.  

## 1- Clonar el repositorio  
Lo primero será clonar el repositorio, clonarlo donde tengas los demás proyectos de Laravel, así podrás localizarlo más rápido.  

## 2- Fichero .env
> Notas del parche: *Protejámonos de los franceses*  
> El fichero de ejemplo .env ya no se llamará ejemplo.env, ahora será ejemplo-entorno.  

El fichero .env **nunca** debería publicarse, por lo que se incluye en el .gitignore. Como es un proyecto de clase y lo que buscamos es trabajar en conjunto y aprender, sí que subiremos un fichero llamado **ejemplo-entorno** el cual renombraremos a .env y así tendremos disponibles las variables de entorno que configuran nuestro proyecto.  
Accedemos a la carpeta del proyecto y ejecutamos:  
```bash
# Nos situamos en la ruta del proyecto
copy ejemplo-entorno .env
```

## 3- Modificar el fichero Homestead.yaml
Tendremos que añadir el mapeo  
```yaml
folders:
    - map: ./www # <- aquí dentro es donde he dejado los proyectos
      to: /home/vagrant/projects # <- y esta la ruta donde apunto

sites:
    # ...
    - map: proyecto.test # <- esta es la configurada en el .env
      to: /home/vagrant/projects/proyecto/public # <- y por eso pongo esa ruta!
```
> **Nota:**   
> En mi caso dejo los proyectos dentro de una carpeta llamada **www** y hago el mapeo a /home/vagrant/**projects**, en vuestro caso fijaros en la directiva **folders** para saber dónde tenéis que dejar el repositorio y cómo lo está vinculando con la máquina virtual.

## 4- Añadir el dominio al fichero hosts
Modificamos el fichero hosts ubicado en C:\Windows\System32\drivers\etc y añadimos: 
```yaml
192.168.10.10      proyecto.test
```
> **Nota:**   
> 192.168.10.10 es la ip que he indicado en la primera línea del Homestead.yaml, si tenéis otra, poned la vuestra. Lo mismo para el dominio, si habéis configurado otro dominio, poned el que hayáis indicado.  

## 5- Instalar dependencias node.js
Hemos clonado el repositorio pero no tenemos las dependencias instaladas, estas se incluyen en el .gitignore para ahorrar mucho espacio en la nube y aprovechándonos de los ficheros de configuración de dependencias como **package.json** nos permitirán instalarlas con un solo comando.  
Desde Windows (para evitar problemas de bin links) accedemos dentro del proyecto y ejecutamos el comando:  
```bash
npm install
```  

## 6- Reload --provision
Con estos cambios ya hechos, vamos a recargar y volver a lanzar las provisiones para que se aplique bien la configuración y poder probar.  
**Importante**: Para ello, en el directorio de Homestead (donde tenemos el Homestead.yaml) ejecutamos el comando: 
```bash
vagrant reload --provision
```

## 7- Instalar dependencias composer
Ya tenemos casi todo configurado, ahora tenemos que instalar las dependencias del lado del servidor utilizando composer. Para ello ejecutamos `vagrant ssh`, accedemos a la carpeta del proyecto y ejecutamos el comando `composer install`

## 8- BBDD
Accedemos a la máquina virtual con `vagrant ssh` y a la consola mysql con `mysql -u root`
```bash
# Creamos la base de datos para tenerla disponible
CREATE DATABASE hosteleria;

# Creamos el usuario dev y le asignamos permisos
CREATE USER 'dev'@'localhost' IDENTIFIED BY '12345Abcde';
GRANT ALL PRIVILEGES ON hosteleria.* TO 'dev'@'localhost';
FLUSH PRIVILEGES;
```

## 9- Migraciones
Ejecutamos las migraciones existentes para generar las tablas y así poder probar la aplicación:  
```bash
php artisan migrate
```

