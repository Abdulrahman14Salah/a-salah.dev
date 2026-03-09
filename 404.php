<?php get_header(); ?>

<div class="container">

    <h1>Page Not Found</h1>

    <p>The page you are looking for does not exist.</p>

    <a href="<?php echo esc_url(home_url('/')); ?>">
        Back to homepage
    </a>

</div>

<?php get_footer(); ?>