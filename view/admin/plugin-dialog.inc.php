<?php
/*
 * Displays the plugin dialog
 */
?>
<div id="helloworld">Hello world!</div>
<div style = "display:none">
    <div id = "dope-plugin-dialog" class = "dope-dialog">
        <div class="dope-dialog-content">
            <strong><?php esc_html_e("You're about to deactivate DOPE", 'dope'); ?></strong>

            <p><?php esc_html_e('The following plugins depends on dope and will also be deactivated', 'dope'); ?></p>

            <table class="widefat post fixed" cellspacing="0">
                <thead>
                    <tr class="alt">
                        <th class="manage-column column-name"><?php esc_html_e('Plugin', 'dope') ?></th>
                        <th class="manage-column column-name"><?php esc_html_e('Description', 'dope') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->plugins as $dplugin): ?>
                        <tr valign="top">
                            <td class="post-title column-title">
                                <strong><?php echo $dplugin['name'] ?></a></strong>
                            </td>
                            <td class="street column-created">
                                <p><?php echo $dplugin['description'] ?></p>
                            </td>
                        </tr>
                    <?php endforeach; //end ?>
                </tbody>
            </table>

            <form id="dope-plugin-dialog-deactivate-form" action="<?php echo $this->controllerUrl ?> " method="post">
                <?php wp_nonce_field('dope_deactivate_plugin'); ?>
                <input type="hidden" name="action" value="dope_deactivate_plugin" />
                <input type="hidden" id="dope_pcount" value="<?php echo count($this->plugins); ?>" />
            </form>
        </div>
    </div>
</div>
