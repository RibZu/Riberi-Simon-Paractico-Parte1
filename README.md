# 📰 Módulo de Publicación de Noticias Institucionales

**Trabajo Integrador – Parte 1**  
**Proyecto de Desarrollo y Pruebas de la Aplicación**  
**Materia:** Técnicas y Herramientas para el Desarrollo Web con Calidad  
**Carrera:** Tecnicatura Universitaria en Web  
**Autor:** Riberi Zunino Simon  

---

## 1. Informe de Desarrollo

En este informe se detallan las decisiones técnicas tomadas para armar el módulo de noticias institucionales. A continuación, se explica por qué se eligieron ciertas herramientas, cómo se resolvieron los inconvenientes durante la programación y qué supuestos se tuvieron en cuenta para que el sistema cumpla con los requisitos pedidos por la cátedra.

### 1.1 Justificación del Entorno IDE y Tecnologías utilizadas
Para el desarrollo del proyecto se utilizó **Visual Studio Code (VS Code)** porque consume pocos recursos, lo que permite trabajar de forma fluida teniendo el servidor local y el navegador abiertos al mismo tiempo. Además, sus herramientas integradas ayudaron a agilizar la escritura del código. 

Por otro lado, la elección de **PHP, HTML, CSS y SQL** se debe a que, además de cumplir con los requisitos pedidos por la cátedra, son tecnologías que ya fuimos estudiando y aplicando en los años anteriores de la tecnicatura. Esto facilitó organizar el proyecto y avanzar más rápido sin tener que usar frameworks externos.

### 1.2 Justificación del motor de BD utilizado
La base de datos se construyó en **MySQL (MariaDB)** usando **XAMPP**, y se administró con **phpMyAdmin**. Se eligió esta opción por lo sencillo que resulta conectarla con PHP a través de `mysqli` y porque maneja muy bien las relaciones necesarias entre las tablas del sistema (como los usuarios, las noticias y el historial). 

Al igual que con los lenguajes de programación, al ser un motor de base de datos que ya conocemos de materias anteriores, su instalación y configuración en modo local fue muy rápida, resultando ideal para hacer las pruebas que exige este trabajo práctico.

### 1.3 Listado de problemas surgidos durante el desarrollo y soluciones

Mientras se iba armando la lógica del sistema, surgieron algunas dudas y problemas sobre cómo implementar las reglas pedidas. Así es como se resolvió cada uno:

*   **Problema:** Evitar que haya dos noticias publicadas con el mismo título (Regla 4).
    *   **Solución:** Antes de dejar que un Validador cambie el estado a "Publicada", agregué una consulta en el controlador que busca en la base de datos si ya existe una noticia publicada con ese mismo título. Si la encuentra, el sistema frena la acción y le muestra un mensaje de error en pantalla al usuario.

*   **Problema:** Validar el tamaño de las imágenes según lo que elija el administrador.
    *   **Solución:** Creé una tabla llamada `configuracion` para guardar el peso máximo permitido en bytes. Cuando un Editor intenta subir una foto, el código busca ese valor en la base de datos y lo compara con lo que pesa el archivo que está subiendo. Si es más pesado, muestra un error y no guarda la noticia.

*   **Problema:** Hacer que las noticias expiren automáticamente (Regla 11).
    *   **Solución:** Como en un entorno local (localhost) es difícil usar tareas programadas que corran solas todos los días, lo resolví haciendo que se verifique al entrar al sistema. Cada vez que alguien entra al `panel.php`, se ejecuta una consulta que busca las noticias publicadas que ya superaron los días permitidos (sacados de la configuración) y les cambia el estado a 'Expirada'.

*   **Problema:** Armar el proyecto en capas sin usar CodeIgniter u otro framework.
    *   **Solución:** Armé un esquema **MVC (Modelo-Vista-Controlador)** manual y sencillo. Separé los archivos en tres carpetas principales: `vistas` para todo lo que es diseño HTML y formularios, `modelos` para las consultas a la base de datos, y `controladores` para procesar los datos que mandan los formularios y tomar decisiones.

*   **Problema:** Guardar el historial de todo lo que le pasa a una noticia (Reglas 15 y 16).
    *   **Solución:** Hice una función general llamada `registrarHistorial()` dentro del archivo que maneja los modelos. Así, cada vez que en los controladores se crea, se edita o se cambia de estado una noticia, llamo a esa función para guardar qué usuario lo hizo, qué acción tomó y la fecha exacta.

### 1.4 Aportes y Supuestos (Reglas de Negocio Asumidas)

*   **Creación de un usuario Administrador:** Las consignas mencionaban a Editores y Validadores, pero el sistema necesitaba a alguien que pueda dar de alta a esos usuarios y que pueda cambiar las configuraciones (días de expiración y peso de imagen). Por eso creé el rol de "Administrador", que tiene un panel exclusivo para esto.
*   **Un usuario no puede validarse a sí mismo:** Como un usuario puede ser Editor y Validador al mismo tiempo, puse una restricción para que, si escribió una noticia, no le aparezca la opción de publicarla él mismo. Siempre tiene que validarla otra persona para cumplir con la idea de revisión.
*   **Botón manual para pedir validación:** La regla 7 menciona que un borrador pasa a validación. Para que el borrador no pase a ese estado solo cada vez que se hace un cambio, le agregué al Editor un botón de "Enviar a Validar" para que lo utilice recién cuando siente que la nota está terminada.
*   **Dejar comentarios para corregir:** Cuando el Validador manda una noticia a "Para Corrección", me pareció útil agregar un campo para que le deje escrito al Editor qué es lo que tiene que arreglar. Ese comentario le aparece al Editor cuando entra a modificar la noticia.
*   **Uso de sesiones para los mensajes:** Para no perder los datos que el usuario ya había escrito en el formulario si comete un error (como poner un título muy corto), usé variables de sesión en PHP. También me sirve para mostrar carteles verdes de éxito o rojos de error en las vistas sin usar JavaScript complejo.
*   **Botón de recuperar contraseña:** Creé una pantalla de recuperación. Como es un proyecto local, lo que hace es fijarse si el mail existe y, si es así, le resetea la contraseña a `123456` y le avisa por pantalla para que pueda entrar.

---

## ⚙️ Pasos de Instalación

1.  Crear una base de datos en **phpMyAdmin** con el nombre `noticias_db`.
2.  Importar el archivo `noticias_db.sql` que viene en la carpeta del proyecto. Esto va a crear las tablas y un usuario administrador por defecto.
3.  Copiar la carpeta entera del proyecto adentro de la carpeta pública del servidor local (por lo general es `htdocs` en XAMPP).
4.  Entrar desde el navegador web a: 
    ```bash
    http://localhost/[nombre-de-la-carpeta]/vistas/login.php
    ```
5.  **Datos de acceso para probar el sistema:**
    *   **Email:** `admin@mail.com`
    *   **Contraseña:** `123456`
    *(Desde este usuario administrador ya se pueden crear los demás roles y usuarios).*
