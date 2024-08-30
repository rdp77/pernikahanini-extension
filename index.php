<?php
/**
 * Plugin Name: PernikahanIni Extension
 * Description: Organize the guestbook and display names based on URL parameters.
 * Version: 1.0
 * Author: PernikahanIni
 * Author URI: https://pernikahanini.com
 */
// Prevent direct access
if (!defined("ABSPATH")) {
    exit();
}

require_once plugin_dir_path(__FILE__) . "includes/helpers.php";
require_once plugin_dir_path(__FILE__) . "includes/imports.php";

// Define the base path for the plugin includes directory
define(
    "GUEST_BOOKS_INCLUDES_PATH",
    plugin_dir_path(__FILE__) . "includes/guest-books/"
);

// Include all PHP files from the includes directory
Helpers::include_all_php_files(GUEST_BOOKS_INCLUDES_PATH);

// Create custom table on plugin activation
function pernikahanini_activate()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "pernikahanini";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        slug varchar(100) NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY slug_index (slug),
        KEY name_index (name)
    ) $charset_collate;";

    require_once ABSPATH . "wp-admin/includes/upgrade.php";
    dbDelta($sql);
}
register_activation_hook(__FILE__, "pernikahanini_activate");

// Create admin menu
function pernikahanini_plugin_menu()
{
    add_menu_page(
        "PernikahanIni Extension",
        "PernikahanIni Extension",
        "manage_options",
        "pernikahanini-extension",
        "pernikahanini_admin_page"
    );
    add_submenu_page(
        "pernikahanini-extension",
        "Guest Books",
        "Guest Books",
        "manage_options",
        "pernikahanini-extension",
        "pernikahanini_admin_page"
    );
    add_submenu_page(
        "pernikahanini-extension",
        "Import Data",
        "Import Data",
        "manage_options",
        "pernikahanini-import",
        "pernikahanini_import_page"
    );
    // add_submenu_page(
    //     'pernikahanini-extension',
    //     'Settings',
    //     'Settings',
    //     'manage_options',
    //     'pernikahanini-settings',
    //     'pernikahanini_settings_page'
    // );
}
add_action("admin_menu", "pernikahanini_plugin_menu");

// Admin page content
function pernikahanini_admin_page()
{
    $guestbook_core = new GuestBookCore();

    // Process Action
    if (isset($_POST["action"])) {
        switch ($_POST["action"]) {
            case "add":
                $guestbook_core->store();
                break;
            case "edit":
                $guestbook_core->update();
                break;
            default:
                break;
        }
    }
    $guestbook_core->destroy();

    $edit_id = isset($_GET["edit"]) ? intval($_GET["edit"]) : null;
    ?>
<div class="wrap">
    <h1>Guest Books</h1>
    <div class="content-container">
        <?php
        $edit_id
            ? guestbook_render_edit_form($edit_id)
            : guestbook_render_add_form();
        guestbook_render_data_list();?>
    </div>
</div>
<?php
}

function pernikahanini_import_page()
{
    ?>
<div class="wrap">
    <h1>Impor Data</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" />
        <input type="submit" name="import_csv" value="Impor CSV" />
    </form>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="excel_file" />
        <input type="submit" name="import_excel" value="Impor Excel" />
    </form>
</div>
<?php
$import = new Imports();

if (isset($_POST["import_csv"])) {
    $import->import_csv();
}

if (isset($_POST["import_excel"])) {
    $import->import_excel();
}
}

function pernikahanini_css()
{
    echo "<style>
.content-container {
    display: flex;
    gap: 10px;
}

.form-column,
.list-column {
    flex: 1;
}

.form-column {
    max-width: 30%;
}

.list-column {
    max-width: 70%;
}

.form-table th .required-asterisk {
    color: red;
    font-weight: bold;
}
</style>";
}
add_action("admin_head", "pernikahanini_css");

function pernikahanini_settings_page()
{
    global $wpdb; ?>

<h1>Settings</h1>

<?php
}

// Shortcode to display data
function pernikahanini_plugin_shortcode($atts)
{
    global $wpdb;
    $table_name = $wpdb->prefix . "pernikahanini";

    $name = isset($_GET["name"]) ? sanitize_text_field($_GET["name"]) : "";
    $name = $wpdb->get_var(
        $wpdb->prepare("SELECT name FROM $table_name WHERE name = %s", $name)
    );

    if ($name) {
        return "<p>Name: " . esc_html($name) . "</p>";
    } else {
        return "<p>No data found.</p>";
    }
}
add_shortcode("pernikahanini", "pernikahanini_plugin_shortcode");

// Register Elementor widget
function pernikahanini_register_widget($widgets_manager)
{
    require_once __DIR__ . "/elementor-widget.php";
    $widgets_manager->register(new \PernikahanIni_Elementor_Widget());
}
add_action("elementor/widgets/register", "pernikahanini_register_widget");

function pernikahanini_widget_categories($elements_manager)
{
    $elements_manager->add_category("pernikahan-ini", [
        "title" => esc_html__("Pernikahan Ini", "textdomain"),
        "icon" => "fa fa-plug",
    ]);
}
add_action(
    "elementor/elements/categories_registered",
    "pernikahanini_widget_categories"
);

function load_javascript()
{
    // Register script JavaScript
    wp_enqueue_script(
        "hide-elements-script", // Handle
        plugins_url("assets/js/hide-elements.js", __FILE__), // URL file JS
        [], // Nothing dependency
        null, // Version
        true // Load on Footer
    );

    wp_enqueue_script(
        "auto-filled-script", // Handle
        plugins_url("assets/js/auto-filled.js", __FILE__), // URL file JS
        [], // Nothing dependency
        null, // Version
        true // Load on Footer
    );

    wp_enqueue_script(
        "hide-on-not-found-script", // Handle
        plugins_url("assets/js/hide-on-not-found.js", __FILE__), // URL file JS
        [], // Nothing dependency
        null, // Version
        true // Load on Footer
    );

    wp_enqueue_script(
        "pernikahanini-helper-script", // Handle
        plugins_url("assets/js/helpers.js", __FILE__), // URL file JS
        [], // Nothing dependency
        null, // Version
        true // Load on Footer
    );
}
add_action("wp_enqueue_scripts", "load_javascript");