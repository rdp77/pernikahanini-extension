<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

function guestbook_render_data_list()
{
    $guestbook_core = new GuestBookCore();
    $results = $guestbook_core->results();
?>
<div class="list-column">
    <h2>Data List</h2>
    <table class="wp-list-table widefat fixed">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($results as $row) : ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo esc_html($row->name); ?></td>
                <td><?php echo esc_html($row->slug); ?></td>
                <td>
                    <a
                        href="<?php echo admin_url('admin.php?page=pernikahanini-extension&edit=' . esc_attr($row->id)); ?>">Edit</a>
                    |
                    <a
                        href="?page=pernikahanini-extension&action=delete&id=<?php echo esc_attr($row->id); ?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
}

function guestbook_render_add_form()
{
?>
<!-- Column Input -->
<div class="form-column">
    <h2>Add new data</h2>
    <form method="post">
        <?php wp_nonce_field('guestbook_action'); ?>
        <input type="hidden" name="action" value="add">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Name <span class="required-asterisk">*</span></th>
                <td><input type="text" name="name" required></td>
            </tr>
            <tr valign="top">
                <th scope="row">Slug</th>
                <td><input type="text" name="slug"></td>
            </tr>
        </table>
        <input type="submit" class="button-primary" value="Add Data">
    </form>
</div>
<?php
}