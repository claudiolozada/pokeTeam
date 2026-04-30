23/4:
hice el frontend del login...
le di estilos para que tenga apariencia a pokemon pero aun no he creado las tablas de BBDD. por hoy solo toque lo visual.

24/4:
adapte un poco el codigo del login de ander aunq aun esta a medias y estructure la BBDD y cree (creo de momento) todas las tablas q necesitare 
las principales son la de users, tipos, pokemons, las demas son tablas q conectan como equipo_pokemon, tipos_pokemon, y asi.. en total son 8
tablas.
logre conectarme a la base de datos pero poniendo los datos de acceso a pelo porque aun estoy enredado con lo del login y queria probar si 
funcionaba el acceso.. el lunes lo organisare mejor. (adelante mucho codigo pero no lo subire pq no e echo bien el acceso a la base de datos)

25 y 26:
El fin de semana aproveché en mi casa para adelantar la página home.php, La idea era que el usuario pudiera escoger un avatar y que ese avatar 
saliera en la página principal, junto con los cinco botones que llevan a las demás partes de la web. También hice el navbar aparte para poder 
incluirlo en todas las páginas y no repetir código.

También hablé con la IA para crear un logo de PokeTeam, porque no quería poner solo el nombre así normal. Fui organizando el home, le metí un poco 
de CSS y algo de JavaScript, y las cosas que no sabía hacer o que no quedaban como quería, se las pedí a la IA para luego yo modificarlas a mi 
manera.

Con los avatares tuve un rollo, porque las imágenes de los juegos se veían bien en pequeño, pero al ponerlas grandes se veían raras y demasiado 
pixeladas. Entonces usé la IA para mejorarles la calidad manteniendo el estilo pixel art, pero sin copiar personajes famosos de Pokémon. Al final
 creé mis propios avatares, los guardé con nombres como chico1, chico2, chica1, chica2, y también hice una foto de perfil para cada uno en otra 
carpeta llamada perfil.

Mi idea es que cuando el usuario se registre, elija su avatar y se guarde ese nombre en la base de datos. Así después puedo usar ese mismo nombre 
para mostrar el avatar o la foto de perfil, dependiendo de la carpeta. También empecé a hacer el menú que se despliega al tocar la foto de perfil,
 y lo dejé dentro del navbar para que funcione en todas las páginas.

27: 
 reorganise las carpetas porque me di cuenta q necesitaba crear mas archivos y asi no se ve todo tan mesclado, y despues tuve q acomodar las 
 direciones de los includes y demas para q funcione. con esto listo me puse a arreglar los errores q aun quedaban del login y controle mejor la 
 seguridad de la base de datos.. siempre tenia errores para aceder y al final el error fue q mi contraceña tenia $ y eso a php como que lo le 
 gusto tanto.. pero para solucionarlo solo en el .env puse la contraceña entre '' y asi si funciono el acceso.. en cuanto al login yo utilice el 
 codigo de ander asi q solo tuve q organizar siertas cosas y eliminar otras q no necesitaria

28: 
 adelante (con ayuda de la ia) el html y css porque como son cosas q si domino bien no quise perder tanto tiempo en eso y asi tendre mas tiempo 
 para la base de datos y php lo malo es q tengo muchos css (creo q devi hacer uno general y otros con pequeños cambios para no repetir tanto 
 codigo. pero ya lo dejare asi porque igual el aspecto fisico no se tomara en cuenta).. con da coneccion a la base de datos arreglada me enfoque 
 en bajar la informacion del usuario para usarla en mi pagina.. la ia me recomendo guardar el username del usuario al momento de rejistrarce para 
 extraer su id y asi podes hacer consultas a la base de datos y como el navbar esta incluido en la mayoria de paginas decidi pedirle la 
 informacion del usuario a la base de datos y guardarla en variables dentro del nav y asi cualquier cambio q haga la bbdd se actualizara en toda
  la web.
 no se q tan buena idea sea pero me funciono asi q lo mantendre asi

29: dias antes investigue un poco sobre la pokeapi en especifico para usarla en mi proyento pero para entender mejor como se extaen los datos 
busque proyentos de github  que usen pokeapi y encomtre una pokedex que extraia la informacion con js y la convertia en un archivo json para poder
usar esos datos en la web y mostrarlos con otras funciones en js.. adapte su web a mi proyecto ajustando algunas cosas para q se integrara mejor y
le hice algunos ajustes a la base de datos para no repetir o duplicar informacion.

30: solucione errores con el tema de editar cosas en la base de datos y gestione un poco los errores q podrian aparecer en la web creando un archivo que recibe el error por GET y depende del error mueste un abiso en pantalla y para avisar del  error, en el codigo uso if por si algo sale mal los redijigo a la pagina usando: header("Location: ../pages/perfil.php?error=locupado"); 
