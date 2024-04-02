<?php
/**
 * Plugin Name: form principal form 
 * Plugin URI: http://juanpabloappleton.ch
 * Description: Este plugin maneja los envíos para mi API.
 * Version: 1.0
 * Author: Juan Pablo Appleton
 * Author URI: http://juanpabloappleton.ch
 */ 

// Asegura que la tabla se cree cuando se active el tema o el plugin

// Registra una nueva ruta REST para manejar la solicitud del formulario de contacto
add_action('rest_api_init', function () {
    register_rest_route('myroutes', '/hauptkontakt', array(
        'methods' => 'POST',
        'callback' => 'handle_haupt_Kontakt_form_submission',
    ));
});



// Función para manejar la solicitud del formulario de contacto
function handle_haupt_Kontakt_form_submission($request) {
    $params = $request->get_params();

    // Validar y sanear los datos recibidos del formulario
    $name = sanitize_text_field($params['names']);
    $email = filter_var($params['email'], FILTER_VALIDATE_EMAIL);
    $nachrichten = sanitize_text_field($params['nachrichten']);

    // Verificar si los datos son válidos
    if (empty($name) || empty($email) || empty($nachrichten)) {
        return new WP_REST_Response(array('error' => 'Nombre, correo electrónico y mensaje son obligatorios'), 400);
    }

    // Crear un arreglo con los datos del formulario
    $form_data = array(
        'names' => $name,
        'email' => $email,
        'nachrichten' => $nachrichten
    );

    // ID del formulario de Contact Form 7
    $form_id = '70b5a13'; // Reemplaza 123 con el ID de tu formulario de Contact Form 7

    // Enviar los datos al formulario de Contact Form 7
    $result = wpcf7_contact_form($form_id, $form_data);

    if ($result) {
        // Éxito al enviar el formulario
        return new WP_REST_Response(array(
            'message' => 'Formulario de contacto enviado con éxito.',
            'data' => array(
                'name' => $name,
                'email' => $email,
                'nachrichten' => $nachrichten
            )
        ), 200);
    } else {
        // Error al enviar el formulario
        return new WP_REST_Response(array('error' => 'Error al enviar el formulario de Contact Form 7'), 500);
    }
}