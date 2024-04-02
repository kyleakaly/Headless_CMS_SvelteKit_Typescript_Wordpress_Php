<h1> Headless CMS mit WordPress und SvelteKit </h1>

Hier ist das bereitgestellte Projekt. Wir haben Vercel verwendet, um das Frontend bereitzustellen, und dann einen normalen PHP-Server verwendet, um das Backend bereitzustellen. Hier kannst du die Anwendung in Aktion sehen.  
<a target="_blank">https://www.appletoninteligencia.ch/</a>

Dieses Projekt stellt die Entwicklung eines headless Content Management Systems (CMS) vor, das WordPress als Backend und Svelte Kit als Frontend verwendet.
Das flexible und leistungsstarke CMS basiert auf der Vielseitigkeit von WordPress und dessen Anpassungsfähigkeit mit Advanced Custom Fields (ACF).
Die Daten werden über die RESTful-API von WordPress abgerufen und dynamisch im Frontend mit Svelte Kit gerendert. Das Projekt wurde mit TypeScript umgesetzt und dient als Marketing-Website. 
Es umfasst eine grundlegende Startseite, ein Blog, in dem Benutzer Beiträge direkt im Backend erstellen können, und ein Kontaktformular, das Informationen in einer Datenbanktabelle speichert, um sie zu senden oder zu archivieren.

#### Konfiguration des Backends (WordPress):

1. Starten Sie einen Apache-Server mit MAMP oder XAMPP.
2. Du musst zum Installationsverzeichnis deines MAMPs oder XAMPPs gehen und den Ordner im htdocs-Verzeichnis speichern
3. Erstellen Sie eine Datenbank und einen Benutzer auf Ihrem MySQL-Server.
4. Kopieren Sie den Ordner `backendwordpress` in das `htdocs`-Verzeichnis Ihres Servers.
5. Starten Sie den Server und navigieren Sie in Ihrem Browser zu `localhost:<port>/Backend_Wordpress_php_Rest_Api`.
6. Installieren oder aktivieren Sie das Plugin Advanced Custom Fields in WordPress.
7. Importieren Sie die JSON-Datei mit den verfügbaren Feldern aus dem Repository.
8. Konfigurieren Sie gegebenenfalls weitere erforderliche Funktionen in WordPress, wie das Erstellen von Blogs, Menüs oder Texteinstellungen.

 Konfiguration von wp-config.php

Um die Verbindung zwischen WordPress und der Datenbank herzustellen, müssen Sie die folgenden Konfigurationsparameter in der Datei `wp-config.php` festlegen:

```php
define( 'DB_NAME', 'Dbname' );
define( 'DB_USER', 'dbuser' );
define( 'DB_PASSWORD', 'password db' );
define( 'DB_HOST', 'localhost:8889' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY', 'Bitte füllen Sie mit neuen einzigartigen Sätzen für Sicherheit aus. Sie können den Link verwenden https://api.wordpress.org/secret-key/1.1/salt/' );
define( 'SECURE_AUTH_KEY', 'Bitte füllen Sie mit neuen einzigartigen Sätzen für Sicherheit aus. Sie können den Link verwenden' );
define( 'LOGGED_IN_KEY', 'Bitte füllen Sie mit neuen einzigartigen Sätzen für Sicherheit aus. Sie können den Link verwenden' );
define( 'NONCE_KEY', 'Bitte füllen Sie mit neuen einzigartigen Sätzen für Sicherheit aus. Sie können den Link verwenden' );
define( 'AUTH_SALT', 'Bitte füllen Sie mit neuen einzigartigen Sätzen für Sicherheit aus. Sie können den Link verwenden' );
define( 'SECURE_AUTH_SALT', 'Bitte füllen Sie mit neuen einzigartigen Sätzen für Sicherheit aus. Sie können den Link verwenden' );
define( 'LOGGED_IN_SALT', 'Bitte füllen Sie mit neuen einzigartigen Sätzen für Sicherheit aus. Sie können den Link verwenden' );
define( 'NONCE_SALT', 'Bitte füllen Sie mit neuen einzigartigen Sätzen für Sicherheit aus. Sie können den Link verwenden' );
```

Anpassung und Erweiterung

In diesem Projekt haben wir WordPress umfangreich angepasst und erweitert, um eine benutzerdefinierte API-Bereitstellung zu ermöglichen. Dazu gehören:

- Anpassungen in der Datei `functions.php` im Theme "Reinventamos", die es Ihnen ermöglichen, API-Aufrufe zu tätigen und Endpunkte zu modifizieren.
- Die Erstellung von fünf benutzerdefinierten Plugins, die bearbeitet und angepasst werden können, um spezifische Anforderungen zu erfüllen.
- Die Verwendung des Plugins "Advanced Custom Fields" zur Erstellung benutzerdefinierter Felder.
  
Wir empfehlen, die mitgelieferte JSON-Datei zu verwenden, um unsere Konfiguration schnell und einfach zu übernehmen.

In funtions.php in /wp-content/themes/reinventamos/functions.php in die line  110 eine funktion  
du must due $allowed_origin = 'http://localhost:5173'; Ändern Sie Ihre Frontend-URL
```php
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

```

#### Konfiguration des Frontends (Svelte Kit):

1. Klonen Sie das Repository des Svelte-Kit-Frontends.
2. Öffnen Sie ein Terminal im Frontend-Ordner und führen Sie `npm install` aus, um die Abhängigkeiten zu installieren.
3. Erstellen Sie eine `.env`-Datei im Hauptverzeichnis des Frontends und setzen Sie die erforderlichen Umgebungsvariablen. Zum Beispiel:
```
VITE_URL_BACKEND= Ihre Backend-URL
VITE_PROD_URL = Ihre Frontend-URL
```
4. Nach der Installation der Abhängigkeiten starten Sie den MAMP-Server.
5. Starten Sie den Entwicklungsserver von Svelte Kit mit `npm run dev`.
6. Öffnen Sie die in der Terminalausgabe bereitgestellte URL, um den Inhalt des Frontends anzuzeigen.
7. Um Inhalte zu aktualisieren oder hinzuzufügen, greifen Sie auf das Backend von WordPress zu und führen Sie die erforderlichen Änderungen im Administrationsbereich durch.

#### Verwendete Technologien:

- Backend: WordPress mit benutzerdefinierten Plugins.
- Frontend: Svelte Kit mit TypeScript und CSS (einschließlich SCSS).
- Weitere Technologien: MySQL, MAMP/XAMPP.

Wenn Sie Schwierigkeiten beim Einrichten oder Verstehen des Projekts haben, zögern Sie nicht, mich zu kontaktieren, um eine ausführlichere Erklärung zu erhalten. Ich hoffe, Sie haben Spaß beim Erkunden des Projekts!
