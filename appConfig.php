<?php

// $homeLinks['appName'] = array(
//     'url' => 'path/to/link', 
//     'title' => 'Link title', 
//     'description' => 'Link text',
//     'icon' => 'path/to/icon', // optional icon to use with the link
//     'default' => false // optional name of the table group you wish to add the link to. If the table group name contains non-Latin characters, you should convert them to html entities.
// );

$homeLinks['test'] = array(
    'url' => 'newTemplate.php', 
    'navBar' => true,
    'title' => 'Blank Page', 
    'description' => 'Blank Page',
    'icon' => '', // optional icon to use with the link
    'default' => false
);
$homeLinks['Presupuesto'] = array(
    'url' => 'Presupuestos.php', 
    'navBar' => true,
    'title' => 'Presupuesto', 
    'description' => 'Generar presupuestos',
    'icon' => '', // optional icon to use with the link
    'default' => false
);

$homeLinks['Ventas'] = array(
    'url' => 'Remitos.php', 
    'navBar' => true,
    'title' => 'Ventas', 
    'description' => 'Generar remitos',
    'icon' => '', // optional icon to use with the link
    'default' => false
);

$homeLinks['Contactos'] = array(
    'url' => 'Contactos.php', 
    'navBar' => true,
    'title' => 'Contactos', 
    'description' => 'buscar contactos',
    'icon' => '', // optional icon to use with the link
    'default' => false
);

$homeLinks['Articulos'] = array(
    'url' => 'Articulos.php', 
    'navBar' => true,
    'title' => 'Articulos', 
    'description' => 'Buscar artículos',
    'icon' => '', // optional icon to use with the link
    'default' => false
);
$homeLinks['Empresas'] = array(
    'url' => 'Empresas.php', 
    'navBar' => true,
    'title' => 'Empresas', 
    'description' => 'Buscar empresas',
    'icon' => '', // optional icon to use with the link
    'default' => false
);

$homeLinks['ArticulosPublicos'] = array(
    'url' => 'ArticulosPublicos.php', 
    'navBar' => false,
    'title' => 'Articulos Publicos', 
    'description' => 'Buscar artículos públicos',
    'icon' => '', // optional icon to use with the link
    'default' => false
);

$homeLinks['login'] = array(
    'url' => 'index.php', 
    'navBar' => false,
    'title' => 'LogIn', 
    'description' => 'Ingreso diario',
    'icon' => '', // optional icon to use with the link
    'default' => false
);

$homeLinks['perfil'] = array(
    'url' => 'perfil.php', 
    'navBar' => false,
    'title' => 'Perfil', 
    'description' => 'Actulizar el perfil',
    'icon' => '', // optional icon to use with the link
    'default' => false
);
$homeLinks['ERROR'] = array(
    'url' => 'error.php', 
    'navBar' => false,
    'title' => 'ERROR', 
    'description' => 'Error general del sistema',
    'icon' => '', // optional icon to use with the link
    'default' => false
);