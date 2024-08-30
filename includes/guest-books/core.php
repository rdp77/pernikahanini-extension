<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class GuestBookCore
{
    private string $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'pernikahanini';
    }

    public function results()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM $this->table_name") ?? [];
    }

    public function store()
    {
        global $wpdb;

        // Verify nonce for security
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'guestbook_action')) {
            wp_die('Nonce verification failed.');
        }

        // Validate and sanitize input
        $name = sanitize_text_field($_POST['name']);
        $slug = !empty($_POST['slug']) ? Helpers::slugify(sanitize_text_field($_POST['slug'])) : Helpers::slugify($name);

        // Insert data into database
        $wpdb->insert(
            $this->table_name,
            array(
                'name' => $name,
                'slug' => $slug
            ),
            array(
                '%s',
                '%s'
            )
        );
    }

    public function edit($edit_id)
    {
        global $wpdb;

        return $edit_id ? $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $edit_id)) : null;
    }

    public function update()
    {
        global $wpdb;

        // Verify nonce for security
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'guestbook_action')) {
            wp_die('Nonce verification failed.');
        }

        // Validate and sanitize input
        $id = intval($_POST['id']);
        $name = sanitize_text_field($_POST['name']);
        $slug = !empty($_POST['slug']) ? Helpers::slugify(sanitize_text_field($_POST['slug'])) : Helpers::slugify($name);

        // Update data in database
        $wpdb->update(
            $this->table_name,
            array(
                'name' => $name,
                'phone' => $slug
            ),
            array('id' => $id),
            array(
                '%s',
                '%s'
            ),
            array('%d')
        );

        // Redirect and exit
        // wp_redirect(admin_url('admin.php?page=pernikahanini-extension'));
        // exit;
        // wp_redirect(home_url());
        // exit;
    }

    public function destroy()
    {
        global $wpdb;

        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $wpdb->delete($this->table_name, array('id' => $id));
        }
    }
}

// Initialize class
$guestbook_core = new GuestBookCore();