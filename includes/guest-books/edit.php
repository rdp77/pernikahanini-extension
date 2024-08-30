<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

function guestbook_render_edit_form($edit_id)
{
    $guestbook_core = new GuestBookCore();
    $edit_data = $guestbook_core->edit($edit_id);
?>
<div class="form-column">
    <h2>Edit Data</h2>
    <form method="post">
        <?php wp_nonce_field('guestbook_action'); ?>
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?php echo esc_attr($edit_data->id); ?>">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Name <span class="required-asterisk">*</span></th>
                <td><input type="text" name="name" value="<?php echo esc_attr($edit_data->name); ?>" required></td>
            </tr>
            <tr valign="top">
                <th scope="row">Slug</th>
                <td><input type="text" name="slug" value="<?php echo esc_attr($edit_data->slug); ?>"></td>
            </tr>
        </table>
        <input type="submit" class="button-primary" value="Update Data">
    </form>
</div>
<?php
}