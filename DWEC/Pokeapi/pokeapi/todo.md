# Overview
Realizar una aplicación on-line sobre Pokemons. Para ello nos basaremos en el desarrollo realizado para el [Ejercicio #3](https://educacionadistancia.juntadeandalucia.es/centros/granada/mod/page/view.php?id=50847). Nuestra web permitirá conocer todos los Pokemons (gracias a los datos de la API) así como jugar una vez aprendidas las características de éstos. 

# Must have
- Estar en producción.
- Al iniciarse la aplicación se muestra una landing page (web estática explicando tu proyecto).
- La cabecera debe permitir navegar a las siguientes rutas: Inicio, Pokemons y Jugar.
- La Ruta "Pokemons" se corresponde con el Ejercicio #3 desarrollado en clase.
- La Ruta "Jugar" debe mostrar un pequeño juego acerca de las características de los Pokemons que permita aplicar datos de estos. Es de temática libre y puede ser cualquier tipo que se base en adivinar un Pokemon (puede ser un ahoracado con nombres de Pokemons, averiguar el Pokemon conociendo características de él o cualquier otro que se te ocurra).
- Tratar las rutas erróneas con un componente al efecto (tratar el 404).
Se trata de una SPA, con lo que la única recarga de la página se produce al inicio.

# Optional ( 5 > 10 )

- (0.5 puntos) El juego implementado debe permitir un Ranking de puntuaciones (los nombres de usuario se escriben estáticamente)
Convertir esta app que es puramente monousuario y local en una web multiusuario accesible desde cualquier lugar. Para ello debemos tener usuarios registrados cada uno con su portfolio (no sería pues necesario escribir el nombre estáticamente). Por tanto:

- (1,5 puntos) Añadir en la cabecera una entrada Iniciar Sesión y otra de Registro (usuario/contraseña y dos redes de tu elección). No se permitirá Jugar hasta que el usuario está logueado, mostrandose su nombre en la cabecera (junto a Cerrar Sesión en lugar de Iniciar). 

- (1,5 puntos) Los rankings de puntuaciones se guardan en una BD Firestore.

- (1,5 puntos) Para conocer los detalles de un Pokemon, lo hacemos sobre un componente específico que se llama con una ruta con parámetros (/detalle/idPokemon)

Tenéis libertad para adaptar el proyecto a vuestras ideas o inquietudes. Así, puedes proponer las mejoras que se te ocurran, debiendo pactarlas previamente con el profesor que te indicará una valoración en puntos de tus propuestas.

Se valora el diseño, pero especialmente el esfuerzo en buscar la usabilidad de la web. Indica la URL del repositorio en GitHub con el código del proyecto así como la URL en producción.