<?php

// Importación de clases necesarias
use DiDom\Document;
use Statickidz\GoogleTranslate;

// Función para guardar traducciones en el caché
function guardarTraduccionEnCache($clave, $traduccion) {
    $_SESSION['translations'][$clave] = $traduccion;
}

// Función para obtener traducciones del caché
function obtenerTraduccionDelCache($clave) {
    return $_SESSION['translations'][$clave] ?? null;
}

// Función para obtener y actualizar traducciones
function obtenerTraduccion($origen, $destino, $texto) {
    $clave = md5($origen . $destino . $texto); // Genera una clave única para la traducción
    $traduccion = obtenerTraduccionDelCache($clave); // Intenta obtener la traducción del caché

    if ($traduccion == null) { // Si no está en el caché
        $traductor = new GoogleTranslate(); // Crea una nueva instancia del traductor
        try {
            // Realiza la traducción
            $traduccion = $traductor->translate($origen, $destino, $texto);
            // Guarda la traducción en el caché
            guardarTraduccionEnCache($clave, $traduccion); 
        } catch (Exception $e) { // Manejo de excepciones si hay un error durante la traducción
            error_log("Error al traducir: " . $e->getMessage()); // Registra el error
            $traduccion = $texto; // Mantiene el texto original en caso de error
        }
    }

    return $traduccion; // Retorna la traducción
}

// Función para cargar el contenido HTML y extraer texto según el selector proporcionado
function extraerTexto($ruta, $selector, $subselector = null) {
    $textos = []; // Inicializa un array para almacenar los textos extraídos
    $htmlContent = file_get_contents($ruta); // Carga el contenido HTML desde la ruta especificada
    if ($htmlContent == false) {
        $textos = null; // Manejo de error si no se puede cargar el archivo
    } else {
        $dom = new Document($htmlContent); // Crea un objeto Document a partir del contenido HTML
        $elementos = $dom->find($selector); // Encuentra los elementos que coinciden con el selector proporcionado
        foreach ($elementos as $elemento) { // Itera sobre los elementos encontrados
            if ($subselector) { // Si hay un subselector especificado
                $subelementos = $elemento->find($subselector); // Encuentra los subelementos
                foreach ($subelementos as $subelemento) { // Itera sobre los subelementos
                    $textos[] = trim($subelemento->text()); // Extrae y limpia el texto, agregándolo al array
                }
            } else {
                $textos[] = trim($elemento->text()); // Extrae y limpia el texto del elemento principal
            }
        }
    }
    return $textos; // Retorna los textos extraídos
}


// Función para traducir textos usando caché
function traducirTextos($textos, $origen, $destino) {
    $textosTraducidos = []; // Inicializa un array para almacenar los textos traducidos

    foreach ($textos as $texto) { // Itera sobre los textos a traducir
        $textosTraducidos[] = obtenerTraduccion($origen, $destino, $texto); // Traduce el texto
        //usleep(500000); // Espera 0.5 segundos entre traducciones para evitar sobrecarga
    }
    
    return $textosTraducidos; // Retorna los textos traducidos
}

// Función para manejar la traducción de un div específico y sus contenidos
function traducirDivGreyblock($documento, $idiomaOrigen, $idiomaDestino, $fraseClave) {
    $contenidoHtml = "";

    // Se busca el primer elemento con la clase 'greyblock'
    $elemento = $documento->find('.greyblock')[0]; // Encuentra el primer div con la clase 'greyblock'
    if ($elemento) { // Si se encuentra el elemento
        $textos = $elemento->text(); // Extrae el texto completo del div
        $textoSinFormatos = trim($textos); // Limpia el texto de espacios innecesarios
        
        // Se extraen los textos dentro de <strong> y <a>
        $textoFuerte = $elemento->find('strong')[0]->text() ?? ''; // Texto dentro de <strong>
        $textoEnlace = $elemento->find('a')[0]->text() ?? ''; // Texto dentro de <a>
        
        // Se obtiene el texto principal, excluyendo los textos fuertes y de enlace
        $textoPrincipal = trim(str_replace([$textoFuerte, $textoEnlace], '', $textoSinFormatos));
    
        // Se traducen los textos
        $textoPrincipalTraducido = traducirTextos([$textoPrincipal], $idiomaOrigen, $idiomaDestino)[0];
        $textoFuerteTraducido = traducirTextos([$textoFuerte], $idiomaOrigen, $idiomaDestino)[0];
        $textoEnlaceTraducido = traducirTextos([$textoEnlace], $idiomaOrigen, $idiomaDestino)[0];

        // Se divide el texto traducido en partes usando la frase clave
        $partesTextoTraducido = explode($fraseClave, $textoPrincipalTraducido);
        $textoAntesDeDescargaTraducido = trim($partesTextoTraducido[0]); // Texto antes de la frase clave

        // Se definen palabras clave para diferentes idiomas
        $palabrasClave = [
            'en' => 'called',
            'es' => 'llamada',
            'fr' => 'appelée',
            'de' => 'muss'
        ];

        // Se obtiene la palabra clave del idioma de destino
        $palabraClave = $palabrasClave[$idiomaDestino] ?? '';

        // Se eliminan duplicados de la palabra clave en el texto traducido
        $textoAntesDeDescargaTraducido = preg_replace('/'. preg_quote($palabraClave) .'\s*\./', $palabraClave, $textoAntesDeDescargaTraducido);
    
        // Se construye el contenido HTML traducido
        $contenidoHtml = htmlspecialchars($textoAntesDeDescargaTraducido) . ' <strong>' . htmlspecialchars($textoFuerteTraducido) . '</strong>. ' . $fraseClave . ' <a href="../../sql/autosdb.sql" target="_blank">' . htmlspecialchars($textoEnlaceTraducido) . '</a>.';
    }
    // Si no se encuentra el elemento, retorna un string vacío o un mensaje de error
    return $contenidoHtml;
}



?>