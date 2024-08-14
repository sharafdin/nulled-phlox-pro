<?php
/* The sidebar widget area is triggered if any of the areas have widgets. */
if ( auxin_primary_sidebar_has_content() ) {
    locate_template('sidebar-primary.php', true, false );
}

if ( auxin_secondary_sidebar_has_content() ) {
    locate_template('sidebar-secondary.php', true, false );
}
