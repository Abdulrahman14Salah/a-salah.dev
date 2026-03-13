<?php

if (! defined('ABSPATH')) {
    exit;
}

?>

</main>

<footer class="site-footer" style="background-color: blue;">

    <div class="container">

        <p>
            © <?php echo date('Y'); ?>
            <?php bloginfo('name'); ?>
        </p>

    </div>

</footer>

<?php wp_footer(); ?>

</body>

</html>