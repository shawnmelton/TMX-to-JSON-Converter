TMX-to-JSON-Converter
=====================

Simple PHP script to convert a .tmx file to a .json file.

#### How to run script

Make sure that you provide a .tmx file and .json file in your command line arguments.

```javascript
php convert.php example.tmx example.json
```

#### Example TMX file

```xml
<?xml version="1.0" encoding="ISO-8859-1"?>
<tmx version="1.4">
    <header />
    <body>
        <tu tuid="All Rights Reserved"><tuv xml:lang="es"><seg>Todos los Derechos Reservados</seg></tuv></tu>
        <tu tuid="Application error"><tuv xml:lang="es"><seg>Error en la aplicación</seg></tuv></tu>
        <tu tuid="Back"><tuv xml:lang="es"><seg>Retroceder</seg></tuv></tu>
    </body>
</tmx>
```

#### Example JSON file

You will not need to provide this file.  It will be generated for you.

```javascript
[{
    "variable": "allRightsReserved",
    "en": "All Rights Reserved",
    "es": "Todos los Derechos Reservados"
},
{
    "variable": "applicationError",
    "en": "Application error",
    "es": "Error en la aplicación"
},
{
    "variable": "back",
    "en": "Back",
    "es": "Retroceder"
}]
```