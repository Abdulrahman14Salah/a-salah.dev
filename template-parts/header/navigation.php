<nav class="main-navigation">

    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'menu',
        )
    );
    ?>

</nav>