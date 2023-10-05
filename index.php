<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 */

get_header(); ?>

<?
if( is_front_page()  ){
    get_template_part( 'template-parts/main/top-categories' );
    get_template_part( 'template-parts/main/top-popular-courses' );
    get_template_part( 'template-parts/main/feedback' );
    get_template_part( 'template-parts/main/top-news' );
 }
?>
<?  
if(is_single()){
    get_template_part( 'course_detail-page' );
}
?>
<?
the_content();

get_footer();

?>