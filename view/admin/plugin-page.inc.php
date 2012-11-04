<?php
/*
 * The DOPE plugin submenu content
 * @internal Lists all active (registered) dope plugin's (still incomplete)
 */
?>
<div id="dope-wrapper" class="wrap">
    <div id="icon-plugins" class="icon32" title="Listrik 230V. Hati-hati!"><br /></div>
    <h2><?php esc_html_e('Plugins based on DG\'s Object-oriented Plugin Extension ', 'dope') ?> 
        <a class="button add-new-h2" href="<?php echo esc_url($this->controllerUrl) ?>&amp;action=add"><?php esc_html_e('Add New', 'dope') ?></a>
    </h2>
    <table class="widefat post fixed" cellspacing="0">
        <thead>
            <tr class="alt">
                <th class="manage-column column-name"><?php esc_html_e('Plugin', 'dope') ?></th>
                <th class="manage-column column-created"><?php esc_html_e('Description', 'dope') ?></th>
                <th class="manage-column column-created"><?php esc_html_e('Bootstrap', 'dope') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($this->plugins != null && is_array($this->plugins)): ?>
                <?php foreach ($this->plugins as $dplugin): ?>
                    <tr valign="top">
                        <td class="post-title column-title">
                            <strong><a title="<?php esc_attr_e('Activate', 'dope') ?> <?php echo esc_attr($dplugin['name']) ?>" href="<?php echo esc_url($this->controllerUrl) ?>&amp;action=edit" class="row-title"><?php echo $dplugin['name'] ?></a></strong>
                            <div class="row-actions">
                                <span class="edit"><a title="<?php esc_attr_e('Edit', 'dope') ?>" href="<?php echo esc_url($this->controllerUrl) ?>&amp;action=edit"><?php esc_html_e('Edit', 'dope') ?></a> | </span>
                                <span class="trash"><a title="<?php esc_attr_e('Are you sure you want to delete this plugin?', 'dope') ?>" href="<?php echo esc_url($this->controllerUrl) ?>&amp;action=delete" class="submitdelete"><?php esc_html_e('Delete', 'dope') ?></a></span>
                            </div>
                        </td>
                        <td class="street column-created">
                            <p><?php echo $dplugin['description'] ?></p>
                        </td>
                        <td class="street column-created">
                            <p><?php echo esc_html('plugins/' . plugin_basename($dplugin['bootstrapFile'])) ?></p>
                        </td>
                    </tr>
                <?php endforeach; //end ?>
            <?php else: // rinse and repeat ?>
            <p><?php esc_html_e('There seems to be an error...', 'dope') ?></p>
        <?php endif ?>
        </tbody>
    </table>
    <div class="updated">
        <?php if ($this->debug): ?>
            <p style="font-size: 14px;">Hello<br />
            <p><pre><?php echo $this->debug ?> </pre></p>
        <?php endif; ?>
    </div>
</div>