<?php get_header(); ?>

<?php $my_current_lang = apply_filters('wpml_current_language', NULL);
// Check WPML current lang and put in in variable to create custom logic - Nutn0n, Nov 28, 2022.
?>
    <main class="main-content">

        <?php the_content(); ?>

    </main>
<?php get_footer(); ?>