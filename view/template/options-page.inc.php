<?php

/*
 * Copyright 2013, Darius Glockenmeier.
 * 
 * Description of options-page
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package your_package_name_here
 * 
 */

/* NOTES:
 * page: my-plugin
 * group: my-settings-group
 * page view callback: my-options-page
 * section: section-one
 * field: field-one
 * 
 */
?>
<div class="wrap">
    <h2><?php echo $this->page_title ?></h2>
    <form action="options.php" method="POST">
        <?php settings_fields($this->option_group) ?>
        <?php do_settings_sections($this->page) ?>
        <?php submit_button() ?>
    </form>
</div>
