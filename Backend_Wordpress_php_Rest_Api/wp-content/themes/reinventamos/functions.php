<?php


function init_template()
{
    //imagen destacada
    add_theme_support('post-thumbnails');
    //titulo para seo
    add_theme_support('title-tag');
    add_theme_support('custom-logo', array(
      'height'      => 100,
    'width'       => 600,
    'flex-height' => true,
    'flex-width'  => true,
    ));

    register_nav_menus(
        array(
            'menuprincipal' => esc_html__( 'Hauptnavigation', 'reinventamos' ),
            'submenu' => esc_html__( 'SubMenu', 'reinventamos' ),
            'redessociales' => esc_html__( 'RedesSociales - Navigation', 'reinventamos' ),
            'menuprincipalsoloclick' => esc_html__( 'Hauptmenü nur ein click Navigation', 'reinventamos' ),
        )
    );
}

add_action('after_setup_theme', 'init_template');

function registrar_sidebar()
{
    register_sidebar(array(
        'name' => 'Pie de página',
        'id'  => 'footer',
        'description' => 'Zona de Widgets para pie de página',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<p>',
        'after_title'   => '</p>',
    ));
}

add_action('widgets_init', 'registrar_sidebar');




    //Gutenberg deaktivieren

add_filter("use_block_editor_for_post_type", "disable_gutenberg_editor");
function disable_gutenberg_editor()
{
return false;
}



function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
   }
   add_filter('upload_mimes', 'cc_mime_types');


//    $post_id = 10;
//    $meta_key = 'parrafo-1';
//    $meta_value = 'Reinventamos';
//    update_post_meta($post_id, $meta_key, $meta_value);


//cunston fields

function custom_meta_description() {
    if (is_single() || is_page()) {
      global $post;
      $description = get_post_meta($post->ID, 'Beschreibungfurseo', true);
      if (!empty($description)) {
        echo '<meta name="description" content="' . $description . '">';
      } else {
        $description = strip_tags($post->post_content);
        $description = str_replace("\n", "", $description);
        $description = substr($description, 0, 155);
        echo '<meta name="description" content="' . $description . '">';
      }
    } elseif (is_home()) {
      echo '<meta name="description" content="'.get_bloginfo( "description" ).'">';
    } elseif (is_category()) {
      echo '<meta name="description" content="Archivo de la categoría: ' . single_cat_title('', false) . '">';
    } elseif (is_tag()) {
      echo '<meta name="description" content="Archivo de la etiqueta: ' . single_tag_title('', false) . '">';
    }
  }
  add_action('wp_head', 'custom_meta_description');


  // Ändere JSON-Antwort, um das URL des hervorgehobenen Bildes einzuschließen
add_filter('rest_prepare_post', 'custom_prepare_post', 10, 3);

function custom_prepare_post($data, $post, $request) {
    $featured_image_id = $data->data['featured_media']; // ID des hervorgehobenen Bildes
    if ($featured_image_id) {
        $featured_image_url = wp_get_attachment_image_src($featured_image_id, 'full'); // URL des Bildes abrufen
        $data->data['featured_image_url'] = $featured_image_url[0]; // URL des Bildes zur JSON-Antwort hinzufügen
    } else {
        $data->data['featured_image_url'] = ''; // Wenn kein Bild vorhanden ist, leere URL festlegen
    }
    return $data;
}


add_filter('rest_authentication_errors', function($result) {
   if (!empty($result)) {
        return $result;
    }

    // Überprüfe den Ursprung der Anfrage
        $allowed_origin = 'http://localhost:5173'; // Ersetze durch den Ursprung deines Frontends
    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

   // Wenn die Anfrage vom zugelassenen Frontend stammt, erlaube die Anfrage
   if ($origin === $allowed_origin) {
        return $result;   }

   // Wenn der Ursprung nicht zugelassen ist, gib einen Fehler zurück
  return new WP_Error('rest_invalid_domain', 'Ungültige Domain.', array('status' => 403));
 });



function get_logo_src() {
  $size = 'full';
  $custom_logo_id = get_theme_mod( 'custom_logo' );
  $feat_img_array = wp_get_attachment_image_src($custom_logo_id, $size, true);
  return $feat_img_array[0];
}



function get_menu_name() {
  return wp_get_nav_menu_items('erstelleneinemenu');
}

function get_custom_logo_and_menu() {
  // Menüdaten abrufen
  $menu_items = get_menu_name();

  // Daten des benutzerdefinierten Logos abrufen
  $custom_logo_data = get_logo_src();

  // Menü- und Logodaten in einem Array kombinieren
  $data = array(
      'menu_items' => $menu_items,
      'custom_logo' => $custom_logo_data
  );

  // Kombinierte Daten zurückgeben
  return $data;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'myroutes', '/menu-and-logo', array(
      'methods' => 'GET',
      'callback' => 'get_custom_logo_and_menu',
  ) );
} );


 // Kunden-Anpassung Post-Typ in Rest-API
 // Benutzerdefinierten Pfad registrieren, um Kunden abzurufen
add_action('rest_api_init', function () {
  register_rest_route('myroutes', '/kunden', array(
       'methods' => 'GET',
        'callback' => 'get_clientes',
   ));
 });

 // Definieren der Rückruffunktion, um Kunden abzurufen
 function get_clientes() {
   // Kunden mit WP_Query abrufen
   $clientes_query = new WP_Query(array(
       'post_type' => 'clientes_rein',
       'posts_per_page' => -1, // Alle Kunden abrufen
   ));

   // Array zum Speichern der Kundendaten
  $clientes = array();

   // Schleife durch die Abfrageergebnisse und Aufbau des Kundenarrays
   if ($clientes_query->have_posts()) {
       while ($clientes_query->have_posts()) {
           $clientes_query->the_post();

           // Aktuelle Kundendaten abrufen
           $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
           $cliente_data = array(
               'id' => get_the_ID(),
              'title' => get_the_title(),
               'content' => get_the_content(),
               'thumbnail' => $thumbnail_url,
               // Weitere benutzerdefinierte Felder hier hinzufügen, wenn erforderlich
           );

           // ACF-Benutzerdefinierte Felder abrufen und zum Datenarray hinzufügen
          $custom_fields = get_fields(); // Alle mit dem aktuellen Beitrag verbundenen benutzerdefinierten Felder abrufen
          if ($custom_fields) {
              foreach ($custom_fields as $key => $value) {
                  $cliente_data[$key] = $value; // Benutzerdefiniertes Feld zum Datenarray hinzufügen
              }
          }

           // Kundendaten zum Kundenarray hinzufügen
           $clientes[] = $cliente_data;
      }
   }

   // Kundendaten wiederherstellen
   wp_reset_postdata();

   // Kundendaten im JSON-Format zurückgeben
   return $clientes;
 }


 // Funktion für Dienste 

 add_action('rest_api_init', function () {
  register_rest_route('myroutes', '/services', array(
       'methods' => 'GET',
        'callback' => 'get_dients',
   ));
 });



// Definieren der Rückruffunktion, um Dienste abzurufen
function get_dients($request) {
  $slug = $request['slug']; // Slug-Parameter aus der URL abrufen
  // Überprüfen, ob ein Slug bereitgestellt wurde
  if (!empty($slug)) {
      // Wenn ein Slug bereitgestellt wurde, den Dienst mit diesem Slug abrufen
      $service = get_dients_by_slug($slug);
      if ($service) {
          // Wenn der Dienst gefunden wurde, gib ihn im JSON-Format zurück
          return rest_ensure_response($service);
      } else {
          // Wenn der Dienst nicht gefunden wurde, gib eine Fehlermeldung zurück
          return new WP_Error('not_found', 'Kein Dienst mit dem bereitgestellten Slug gefunden.', array('status' => 404));
      }
  } else {
      // Wenn kein Slug bereitgestellt wurde, alle Dienste abrufen
      $services = get_dients_all();
      // Alle Dienste im JSON-Format zurückgeben
      return rest_ensure_response($services);
  }
}

// Funktion zum Abrufen aller Dienste
function get_dients_all() {
  // Dienste mit WP_Query abrufen
  $services_query = new WP_Query(array(
      'post_type' => 'dienst_rein',
      'posts_per_page' => -1, // Alle Dienste abrufen
  ));

  // Array zum Speichern der Servicedaten
  $services = array();

  // Schleife durch die Abfrageergebnisse und Aufbau des Servicearrays
  if ($services_query->have_posts()) {
      while ($services_query->have_posts()) {
          $services_query->the_post();

          // Aktuelle Servicedaten abrufen
          $services_data = array(
              'id' => get_the_ID(),
              'title' => get_the_title(),
              'content' => get_the_content(),
              'slug' => get_post_field('post_name'),
              // Weitere benutzerdefinierte Felder hier hinzufügen, wenn erforderlich
          );

          // ACF-Benutzerdefinierte Felder abrufen und zum Datenarray hinzufügen
          $custom_fields = get_fields(); // Alle mit dem aktuellen Beitrag verbundenen benutzerdefinierten Felder abrufen
          if ($custom_fields) {
              foreach ($custom_fields as $key => $value) {
                  $services_data[$key] = $value; // Benutzerdefiniertes Feld zum Datenarray hinzufügen
              }
          }

          // Servicedaten zum Servicearray hinzufügen
          $services[] = $services_data;
      }
  }

  // Servicedaten wiederherstellen
  wp_reset_postdata();

  // Servicedaten im JSON-Format zurückgeben
  return $services;
}

// Funktion zum Abrufen eines Dienstes anhand seines Slugs
function get_dients_by_slug($slug) {
  // Dienst mit WP_Query abrufen
  $service_query = new WP_Query(array(
      'post_type' => 'dienst_rein',
      'name' => $slug, // Nach dem bereitgestellten Slug filtern
      'posts_per_page' => 1, // Nur einen Dienst mit dem angegebenen Slug abrufen
  ));

  // Überprüfen, ob der Dienst gefunden wurde
  if ($service_query->have_posts()) {
      $service_query->the_post();

      // Servicedaten abrufen
      $service_data = array(
          'id' => get_the_ID(),
          'title' => get_the_title(),
          'content' => get_the_content(),
          'slug' => get_post_field('post_name'),
          // Weitere benutzerdefinierte Felder hier hinzufügen, wenn erforderlich
      );

      // ACF-Benutzerdefinierte Felder abrufen und zum Datenarray hinzufügen
      $custom_fields = get_fields(); // Alle mit dem aktuellen Beitrag verbundenen benutzerdefinierten Felder abrufen
      if ($custom_fields) {
          foreach ($custom_fields as $key => $value) {
              $service_data[$key] = $value; // Benutzerdefiniertes Feld zum Datenarray hinzufügen
          }
      }

      // Servicedaten wiederherstellen
      wp_reset_postdata();

      // Servicedaten zurückgeben
      return $service_data;
  } else {
      // Wenn der Dienst nicht gefunden wurde, false zurückgeben
      return false;
  }
}







// Benutzerdefinierten Pfad registrieren, um Kunden und Dienste abzurufen
add_action('rest_api_init', function () {
  register_rest_route('myroutes', '/daten', array(
      'methods' => 'GET',
      'callback' => 'get_datos',
  ));
});

// Funktion zum Abrufen von Kunden und Diensten
function get_datos() {
  // Array zum Speichern aller Daten
  $datos = array();

  // Kunden mit WP_Query abrufen
  $clientes_query = new WP_Query(array(
      'post_type' => 'clientes_rein',
      'posts_per_page' => -1, // Alle Kunden abrufen
  ));

  // Dienste mit WP_Query abrufen
  $servicios_query = new WP_Query(array(
      'post_type' => 'dienst_rein',
      'posts_per_page' => -1, // Alle Dienste abrufen
  ));

  // Kundendaten zum Datenarray hinzufügen
  if ($clientes_query->have_posts()) {
      while ($clientes_query->have_posts()) {
          $clientes_query->the_post();
          $cliente_data = array(
              'id' => get_the_ID(),
              'title' => get_the_title(),
              'content' => get_the_content(),
              // Weitere benutzerdefinierte Felder hier hinzufügen, wenn erforderlich
          );

          // ACF-Benutzerdefinierte Felder abrufen und zum Datenarray hinzufügen
          $custom_fields = get_fields(); // Alle mit dem aktuellen Beitrag verbundenen benutzerdefinierten Felder abrufen
          if ($custom_fields) {
              foreach ($custom_fields as $key => $value) {
                  $cliente_data[$key] = $value; // Benutzerdefiniertes Feld zum Datenarray hinzufügen
              }
          }

          $datos[] = $cliente_data;
      }
  }

  // Servicedaten zum Datenarray hinzufügen
  if ($servicios_query->have_posts()) {
      while ($servicios_query->have_posts()) {
          $servicios_query->the_post();
          $servicio_data = array(
              'id' => get_the_ID(),
              'title' => get_the_title(),
              'content' => get_the_content(),
              // Weitere benutzerdefinierte Felder hier hinzufügen, wenn erforderlich
          );

          // ACF-Benutzerdefinierte Felder abrufen und zum Datenarray hinzufügen
          $custom_fields = get_fields(); // Alle mit dem aktuellen Beitrag verbundenen benutzerdefinierten Felder abrufen
          if ($custom_fields) {
              foreach ($custom_fields as $key => $value) {
                  $servicio_data[$key] = $value; // Benutzerdefiniertes Feld zum Datenarray hinzufügen
              }
          }

          $datos[] = $servicio_data;
      }
  }

  // Kundendaten und Servicedaten wiederherstellen
  wp_reset_postdata();

  // Alle Daten im JSON-Format zurückgeben
  return $datos;
}



/// Autorname-Tag
function ag_filter_post_json($response, $post, $context) {
    // Autorname abrufen
    $author_data = get_userdata($post->post_author);
    $author_name = $author_data ? $author_data->display_name : '';

    // Tags des Beitrags abrufen
    $tags = wp_get_post_tags($post->ID);
    $tag_names = array();

    foreach ($tags as $tag) {
        $tag_names[] = $tag->name;
    }

    // Tag-Namen und Autorname zur Antwort hinzufügen
    $response->data['tag_names'] = $tag_names;
    $response->data['author_name'] = $author_name;

    return $response;
}

add_filter( 'rest_prepare_post', 'ag_filter_post_json', 10, 3 );



// Rest-API-Formular
// Code


// Ändere die Funktionsweise der Rest-API-Antwort von ACF
add_filter('acf/settings/rest_api_format',function(){

  return 'standard';

});



// Prozesse abrufen

add_action('rest_api_init', function () {
    register_rest_route('myroutes', '/prozess', array(
         'methods' => 'GET',
          'callback' => 'get_prozess_rein',
     ));
   });
  
   // Funktion zur Rückrufdefinition zum Abrufen von Kunden
   function get_prozess_rein() {
     // Prozesse mit WP_Query abrufen
     $prozess_query = new WP_Query(array(
         'post_type' => 'prozess_rein',
         'posts_per_page' => -1, // Alle Kunden abrufen
     ));
  
     // Array zum Speichern der Prozessdaten
    $prozess = array();
  
     // Schleife durch die Abfrageergebnisse und Aufbau des Prozessarrays
     if ($prozess_query->have_posts()) {
         while ($prozess_query->have_posts()) {
             $prozess_query->the_post();
  
             // Aktuelle Prozessdaten abrufen
             $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
             $prozess_data = array(
                 'id' => get_the_ID(),
                'title' => get_the_title(),
                 'content' => get_the_content(),
                 'thumbnail' => $thumbnail_url,
                 // Weitere benutzerdefinierte Felder hier hinzufügen, wenn erforderlich
             );
  
             $custom_fields = get_fields(); // Alle mit dem aktuellen Beitrag verbundenen benutzerdefinierten Felder abrufen
          if ($custom_fields) {
              foreach ($custom_fields as $key => $value) {
                  $prozess_data[$key] = $value; // Benutzerdefiniertes Feld zum Datenarray hinzufügen
              }
          }
           
             // Prozessdaten zum Prozessarray hinzufügen
             $prozess[] = $prozess_data;
        }
     }
  
     // Wiederherstellen der Prozessdaten
     wp_reset_postdata();
  
     // Prozessdaten im JSON-Format zurückgeben
     return $prozess;
   }



   // FAQ abrufen

add_action('rest_api_init', function () {
    register_rest_route('myroutes', '/faq', array(
         'methods' => 'GET',
          'callback' => 'get_faq_rein',
     ));
   });
  
   // Funktion zur Rückrufdefinition zum Abrufen von FAQ
   function get_faq_rein() {
     // FAQ mit WP_Query abrufen
     $faq_query = new WP_Query(array(
         'post_type' => 'faq_rein',
         'posts_per_page' => -1, // Alle FAQ abrufen
     ));
  
     // Array zum Speichern der FAQ-Daten
    $faq = array();
  
     // Schleife durch die Abfrageergebnisse und Aufbau des FAQ-Arrays
     if ($faq_query->have_posts()) {
         while ($faq_query->have_posts()) {
             $faq_query->the_post();
  
             // Aktuelle FAQ-Daten abrufen
             $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
             $faq_data = array(
                 'id' => get_the_ID(),
                'title' => get_the_title(),
                 'content' => get_the_content(),
                 'thumbnail' => $thumbnail_url,
                 // Weitere benutzerdefinierte Felder hier hinzufügen, wenn erforderlich
             );
           
             // FAQ-Daten zum FAQ-Array hinzufügen
             $faq[] = $faq_data;
        }
     }
  
     // Wiederherstellen der FAQ-Daten
     wp_reset_postdata();
  
     // FAQ-Daten im JSON-Format zurückgeben
     return $faq;
   }


//    Über uns abrufen

add_action('rest_api_init', function () {
    register_rest_route('myroutes', '/ueberuns', array(
         'methods' => 'GET',
          'callback' => 'get_ueberuns_rein',
     ));
   });
  
   // Funktion zur Rückrufdefinition zum Abrufen von Über uns
   function get_ueberuns_rein() {
     // Über uns mit WP_Query abrufen
     $ueberuns_query = new WP_Query(array(
         'post_type' => 'ueberuns_rein',
         'posts_per_page' => -1, // Alle Über uns abrufen
     ));
  
     // Array zum Speichern der Über-uns-Daten
    $ueberuns = array();
  
     // Schleife durch die Abfrageergebnisse und Aufbau des Über-uns-Arrays
     if ($ueberuns_query->have_posts()) {
         while ($ueberuns_query->have_posts()) {
             $ueberuns_query->the_post();
  
             // Aktuelle Über-uns-Daten abrufen
             $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
             $ueberuns_data = array(
                 'id' => get_the_ID(),
                'title' => get_the_title(),
                 'content' => get_the_content(),
                 'thumbnail' => $thumbnail_url,
                 // Weitere benutzerdefinierte Felder hier hinzufügen, wenn erforderlich
             );

             $custom_fields = get_fields(); // Alle mit dem aktuellen Beitrag verbundenen benutzerdefinierten Felder abrufen
             if ($custom_fields) {
                 foreach ($custom_fields as $key => $value) {
                     $ueberuns_data[$key] = $value; // Benutzerdefiniertes Feld zum Datenarray hinzufügen
                 }
             }
           
             // Über-uns-Daten zum Über-uns-Array hinzufügen
             $ueberuns[] = $ueberuns_data;
        }
     }
  
     // Wiederherstellen der Über-uns-Daten
     wp_reset_postdata();
  
     // Über-uns-Daten im JSON-Format zurückgeben
     return $ueberuns;
   }
