# Gestor-de-incidencias
### Funcionalidad
- Sistema de login y registro  
>  ->Autentificación  
>  ->Autorización (administrador/usuario)  
>  ->Cifrado de contraseña  
    
- Operaciones CRUD con base de datos  
>  ->Visualización de usuarios, incidencias y comentarios  
>  ->Crear usuarios, incidencias y comentarios  
>  ->Actualizar el estado de la incidencia y los comentarios  
>  ->Eliminar usuarios, incidencias y comentarios  
  
- Paginación de comentarios  
  
### Configuración  
__Base de datos__  
Las tablas de datos necesarias se encuentran en la carpeta '0DB' en formato SQL.  
El nombre por defecto de la base de datos es 'gdi'. Si se desean cambiar los parámetros de la conexión ir a: 'GestorDeIncidencias\Model\dbConnexion.php'.  
  
__App__  
La aplicación sigue la estructura MVC debido a la fácil gestión de archivos y del tamaño de la aplicación (cuya sencillez no hace necesaria una estucturación modular).  
Los archivos reutilizados en varias páginas están almacenados en: 'GestorDeIncidencias\View\partials'.
  
__Iniciar sesión como administrador__  
Debido a que solo un administrador puede crear otro administrador, en el sistema de login se ha implementado la creación de un administrador si la contraseña y usuario es 'admin' (sin comillas). Evitando la necesidad de crearlo desde la base de datos o manipulando el código.  

### Uso
![image](https://github.com/helkyar/Gestor-de-Incidencias/blob/main/gif/admin.gif)  
![image](https://github.com/helkyar/Gestor-de-incidencias/blob/main/gif/user.gif) 
