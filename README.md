# prueba-mantum
#  1 Bases de datos: 📝  
   - (Seudo-código o Diagrama). Realice un modelo de datos en donde 
se exprese la relación en un animal y su clase (tipo), realice unas 
cuantas inserciones.  

  ~~~bash  
    --
-- Base de datos: `especies`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal`
--

CREATE TABLE `animal` (
  `id` int(11) NOT NULL,
  `id_clase` int(11) DEFAULT NULL,
  `nombre_animal` varchar(30) DEFAULT NULL,
  `altura` decimal(10,0) DEFAULT NULL,
  `peso` decimal(10,0) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `animal`
--

INSERT INTO `animal` (`id`, `id_clase`, `nombre_animal`, `altura`, `peso`, `fecha_nacimiento`) VALUES
(1, 1, 'leon', 2, 130, '2016-01-01'),
(2, 1, 'perro', 1, 20, '2016-01-01'),
(3, 1, 'leon', 2, 130, '2016-06-01'),
(4, 1, 'perro', 1, 20, '2024-06-01'),
(5, 1, 'Caballo', 2, 420, '2024-06-01'),
(6, 1, 'Caballo', 2, 420, '2016-06-01'),
(7, 2, 'Abejas', 0, 0, '2024-06-01'),
(8, 2, 'Mantodea', 0, 0, '2024-06-01'),
(9, 2, 'Abejas', 0, 0, '2024-06-01'),
(10, 2, 'Mantodea', 0, 0, '2024-06-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `id` int(11) NOT NULL,
  `clase` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`id`, `clase`) VALUES
(1, 'mamifero'),
(2, 'insectos');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_clase` (`id_clase`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `animal`
--
ALTER TABLE `animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`id_clase`) REFERENCES `clase` (`id`),
  ADD CONSTRAINT `animal_ibfk_2` FOREIGN KEY (`id_clase`) REFERENCES `clase` (`id`);
COMMIT;

  ~~~
  - Construya una consulta SQL, donde obtengas la cantidad por cada 
tipo de animal, siempre que esa cantidad sea mayor a 2; ten 
presente que queremos contar los animales que la fecha de 
nacimiento sea mayor al 2016 

~~~bash  
SELECT c.id, COUNT(a.id_clase) AS cantidad FROM animal a
INNER JOIN clase c ON  a.id_clase = c.id
WHERE a.fecha_nacimiento > "2016-01-01"
GROUP BY c.clase
HAVING 
	COUNT(a.id_clase)>2;
~~~

# 2 WEB:
 - Realice un boceto arquitectónico (esquema) de un proyecto web con: 
   - FrontEND 
   - Navegador web  
   - Aplicación Android 
   - Aplicación iOS 
   - BackenEND 
   - Modelo de datos 

~~~bash  
https://maketapruebamant.netlify.app/
~~~

# 3 PHP
- Realice un modelo objetual en PHP de la clase persona con datos 
nombre, cédula, fecha de nacimiento y sexo con funciones de carga 
y guardado. 
- Cree una instancia de una persona desde otra clase (suponiendo que 
dicha clase esta creada) y guarde dicha instancia. 
-  Cargue la instancia y muéstrela en el navegador.   


# 4  Modelo – Vista – Controlador 
![App Screenshot](https://raw.githubusercontent.com/Rrosso27/prueba-mantum/refs/heads/main/public/img/image.png)  

-  Plantee un diagrama donde se observe el funcionamiento del patrón 
de diseño Modelo – vista – controlador. 

- Explique las funcionalidades del patrón de diseño Modelo – vista – 
controlador.  




# 5 Seudo – código (Matriz) 

Tienes una tabla llamada tienda y tienes una tabla llamada 
categorías, cada tienda tiene una categoría asociada. Se desea que 
entregues una matriz de la siguiente forma: [id_categoria] -> [nombre, 
tiendas _ asociadas -> [id_tienda, nombre _ tienda ]]. Las categorías 
deben estar ordenadas por nombre y dentro de cada categoría las 
tiendas deben estar ordenadas por nombre, ejemplifique el algoritmo, 
especifique en seudo código las consultas a la base y la generación 
de la estructura.  

~~~bash  
<?php
$tiendas = [

    [
        "id_tienda" => 3,
        "nombre_tienda" => "Fashion MaX",
        "id_categoria" => 3
    ],
    [
        "id_tienda" => 4,
        "nombre_tienda" => "Tienda Ana",
        "id_categoria" => 1
    ],
    [
        "id_tienda" => 1,
        "nombre_tienda" => "Tienda Juan",
        "id_categoria" => 1
    ],
    [
        "id_tienda" => 2,
        "nombre_tienda" => "Electro Hogar",
        "id_categoria" => 2
    ]
];

$categorias = [

    [
        "id_categoria" => 2,
        "nombre_categoria" => "Electrónica"
    ],
    [
        "id_categoria" => 3,
        "nombre_categoria" => "Ropa"
    ],
    [
        "id_categoria" => 1,
        "nombre_categoria" => "Abarrotes"
    ]
];


$CategoriaTienda = array();


foreach ($categorias as $categoria) {
    $CategoriaTienda[] = array(
        'id_categoria' => $categoria['id_categoria'],
        'nombre_categoria' => $categoria['nombre_categoria']
    );
}

for ($i = 0; $i < count($CategoriaTienda); $i++) {

    $CategoriaTienda[$i]['tiendas'] = array();
    foreach ($tiendas as $tienda) {
        if ($tienda['id_categoria'] == $CategoriaTienda[$i]['id_categoria']) {
            $CategoriaTienda[$i]['tiendas'][] = array(
                'id_tienda' => $tienda['id_tienda'],
                'nombre_tienda' => $tienda['nombre_tienda']
            );
        }
    }
}

$categoriasOrdenadas = obtenerCategoriasOrdenadas($CategoriaTienda);
echo $categoriasOrdenadas;



function obtenerCategoriasOrdenadas($CategoriaTienda) {
    usort($CategoriaTienda, function($a, $b) {
        return strcmp($a['nombre_categoria'], $b['nombre_categoria']);
    });
    return json_encode($CategoriaTienda);
}
~~~
