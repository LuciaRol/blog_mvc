USE blog;

-- Insertar usuarios
INSERT INTO usuarios (nombre, apellidos, email, username, contrasena, rol) VALUES
('admin', 'admin', 'admin@admin.com', 'admin', 'admin', 'admin'),
('usur1', 'usur1', 'usur1@usur1.com', 'usur1', 'usur1', 'usur'), 
('usur2', 'usur2', 'usur2@usur2.com', 'usur2', 'usur2', 'usur'); 

-- Insertar categorías
INSERT INTO categorias (nombre) VALUES
('Actualidad'),
('Divulgación'),
('Cielo profundo'),
('Astrofísica'),
('Planetología'),
('Misiones'),
('Equipo'),
('La luna');




-- Insertar entradas
INSERT INTO entradas (usuario_id, categoria_id, titulo, descripcion, fecha) VALUES
(1, 1, "Un meteorito cruza la península", "Cádiz, Sevilla, Vigo o Madrid han sido testigos durante la noche del sábado al domingo de un misterioso bólido que cruzaba el cielo. Los vecinos de todas partes de España y Portugal salieron atónitos a sus ventanas para ver cómo, por un momento, el cielo se iluminaba con un azul verdoso imponente. 

Este misterioso bólido se trata de un meteoro muy brillante, caracterizado por parecer una bola de fuego y crear una estela luminosa por la zona en la que pasa, producida por la fricción a su entrada en la atmósfera terrestre. El término bola de fuego se refiere a cualquier meteoro excepcionalmente brillante en el cielo. En concreto, si su brillo supera el de Venus en el cielo nocturno, indica que el meteoroide original era más grande de lo común. 

El evento, registrado a partir de la medianoche, ha sido grabado por varias cámaras de observatorios a lo largo de la península.", NULL),
(1, 7, "Binoculares 7x50 Cometron Celestron", "Los Cometron son ideales para la astronomía y la observación crepuscular.

Estos clásicos binoculares de Porro ofrecen la imagen más luminosa: el haz de luz que sale del ocular la llamada pupila de salida tiene un diámetro de siete milímetros, el mismo que sus pupilas cuando se abren al máximo por la noche. Esto significa que no se desperdicia ninguna luz y se pueden ver claramente objetos tenues como nebulosas o cometas, así como los animales al anochecer. Las lentes multicoated garantizan una alta transmisión y evitan los molestos reflejos.

Gracias al amplio campo de visión de los Cometron, podrá examinar rápidamente grandes zonas del cielo para encontrar fácilmente su objetivo y no perderlo de vista. Tanto si busca un objetivo en el cielo como si trata de orientarse en la naturaleza, un gran campo de visión será siempre una ventaja. Su gran distancia interpupilar permite una visión cómoda de la que también pueden disfrutar los usuarios con gafas, bien con gafas normales, bien con gafas de sol para observar la naturaleza durante el día.", NULL),
(2, 5, "La polémica de Plutón", "Plutón ya no es considerado un planeta principal debido a una redefinición de lo que constituye un planeta por parte de la Unión Astronómica Internacional IAU en 2006. Antes de esta redefinición, Plutón era uno de los nueve planetas reconocidos en nuestro sistema solar. Sin embargo, la creciente comprensión de la diversidad de objetos en el sistema solar, especialmente en el cinturón de Kuiper, llevó a la necesidad de establecer una definición más precisa de lo que constituye un planeta.

La IAU definió un planeta como un cuerpo celeste que cumple con tres criterios:

Debe orbitar alrededor del Sol.
Debe tener suficiente masa para que su gravedad lo haya formado en una forma esférica.
Debe haber limpiado su órbita de otros objetos, lo que significa que su órbita no debe estar llena de otros cuerpos significativos que compartan la misma región orbital.
Plutón cumple con los dos primeros criterios, pero no cumple con el tercero. Su órbita está poblada por otros objetos en el cinturón de Kuiper, lo que llevó a la IAU a reclasificar a Plutón como un planeta enano. Esta categoría incluye objetos que son lo suficientemente masivos como para ser esféricos, pero que no han limpiado su vecindario orbital.

Por lo tanto, aunque Plutón sigue siendo un cuerpo celestial fascinante y un objeto de estudio importante en el sistema solar, ya no se considera un planeta principal según la definición oficial de la IAU. Actualmente se clasifica como planeta enano.", NULL),
(2, 8, "Hielo en la Luna", "La mayor parte de la superficie capaz de albergar el hielo que existe en el polo sur de la Luna se encuentra en los cráteres de gran diámetro. Estos, además, son casi todos muy antiguos en términos geológicos, con edades que superan los 3100 millones de años. No se ha encontrado hielo en la superficie de grandes cráteres con una edad inferior a los 3100 millones de años, aunque si se ha encontrado en cráteres más recientes pero de tamaño más modesto.

Este hielo no se encuentra en depósitos de gran continuidad lateral, sino que lo hace como parches salpicando la superficie, de una manera muy heterogénea, ocupando aproximadamente un 4.1 de toda la superficie que tiene las condiciones adecuadas para preservarlo. 

Por qué tienen esta distribución los depósitos de hielo. Podría ser que el depósito de este hielo ocurriera muy pronto en la historia de la Luna, siendo depósitos de un tamaño y continuidad espacial mucho mayor, pero que el continuo bombardeo de micrometeoritos haya provocado que una gran parte del hielo se pierda al espacio.
Fuente: https:www.ungeologoenapuros.es201910cualeselorigendelhieloenlasuperficielunar", NULL),
(2, 7, "Telescopios para principiantes", "Existen diversos tipos de telescopios. Para iniciarse en la astronomía le recomendamos uno de lentes con poca apertura, que es perfecto para observar la Luna y los planetas. Y cuando quiera profundizar un poco más, un telescopio de espejos con más apertura para la observación de nebulosas y galaxias.

Se preguntará si los telescopios de espejos también sirven para observación lunar y planetaria: por supuesto. De hecho, también puede disfrutar de nebulosas y galaxias con un telescopio de lentes, aunque para esta finalidad es mucho mejor un espejo más grande porque capta más luz y permite ver mejor los objetos.

Otros aspectos importantes a tener en cuenta:

Los telescopios de lentes seleccionados se suministran con monturas muy intuitivas y fáciles de manejar con articulación tanto horizontal como vertical.
Los telescopios de espejos descansan sobre robustas monturas Dobson, que incluyen un asa.
Algunos telescopios están equipados con sistemas digitales de navegación, que simplifican sobremanera la búsqueda de objetos.
Si el presupuesto es ajustado, con unos binoculares también puede observar muchos objetos celestes.
Pero basta de teoría, pasemos a la práctica. Estos son nuestros telescopios intuitivos para unos inicios fáciles en el mundo de la astronomía.
https:www.astroshop.esrevistaguiadecompralagranguiadecompralosmejorestelescopiosparaprincipiantesi,1598", NULL),
(3, 1, "Auroras boreales en España", "Una aurora boreal ha sido visible en la noche de este viernes en los cielos de gran parte de España, al menos desde Andalucía a Cataluña, Aragón, Galicia y la Comunidad Valenciana, según han publicado en las redes sociales diversos observatorios meteorológicos y astronómicos.

La Administración Nacional Oceánica y Atmosférica NOAA de Estados Unidos ha advertido de que la tormenta geomagnética más fuerte de los últimos 20 años ha golpeado la Tierra, haciendo que la aurora boreal sea visible en latitudes geomagnéticas mucho más bajas de lo habitual.

La Agencia Estatal de Meteorología Aemet ha confirmado esta madrugada que se están observando auroras polares a latitudes muy bajas del hemisferio norte, incluida España y que hay multitud de fotografías que así lo atestiguan.", NULL);
