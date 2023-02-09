<?php get_header(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"
        integrity="sha512-dLxUelApnYxpLt6K2iomGngnHO83iUvZytA3YjDUCjT0HDOHKXnVYdf3hU4JjM8uEhxf9nD1/ey98U3t2vZ0qQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- HERO -->
<div class="flex justify-center items-center w-screen h-screen fixed -z-10 pointer-events-none brightness-75">
    <h1 class="z-20 text-3xl font-light font-semibold tracking-widest uppercase xl:text-8xl">
        <?= is_home() ? single_post_title() : get_the_title(); ?>
    </h1>
    <div
        class="flex absolute top-1/2 left-1/2 z-10 justify-start items-center w-3/5 transform -translate-x-1/2 -translate-y-1/2">
        <img src="<?= get_template_directory_uri() ?>/assets/Ressources/icons/LogoCinquinAndy.svg"
             class="mb-32 ml-16 opacity-20 brightness-75 -rotate-12 w-112 h-112" alt="Logo avatar andy cinquin">
    </div>
    <!--    PAGE -->
    <div class="flex absolute bottom-0 left-0 justify-center items-center p-8 mb-12 xl:p-20 xl:mb-0">
        <h2 class="text-sm tracking-wider opacity-20 origin-bottom-left -rotate-90 font-body xl:text-xl">‣
            <?= is_home() ? single_post_title() : get_the_title(); ?>
        </h2>
    </div>
</div>

<section class="z-50 min-h-screen xl:hidden">
    <div class="w-full flex flex-col gap-20 pt-[50vh] px-8">
        <?php foreach (get_posts(array('numberposts' => -1)) as $post): ?>
            <a href="<?= esc_url(get_permalink($post)) ?>" class="relative h-full">
                <?= get_the_post_thumbnail($post, 'large', "object-cover h-full") ?>
                <h1 class="absolute bottom-4 -left-4 glassmorph p-4 z-20 text-slate-50 text-2xl font-black"><?= $post->post_title ?></h1>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<main class="hidden xl:block fixed top-0 left-0 xl:h-screen xl:w-screen z-30">
    <div class="scrollable absolute w-full top-0 left-0  py-[50vh]">
        <div class="block-container w-full flex justify-between flex-col">
            <?php foreach (get_posts(array('numberposts' => 50)) as $post): ?>
                <a href="<?= esc_url(get_permalink($post)) ?>"
                   class="image-container w-1/2">
                    <h1 class="absolute glassmorph p-8 bottom-32 left-1/4 z-20 text-slate-50 text-3xl font-black"><?= $post->post_title ?></h1>
                    <img class="images-three absolute h-2/3 object-cover"
                         src="<?= get_the_post_thumbnail_url($post) ?>"
                         alt="<?= get_post_meta($post->ID, '_wp_attachment_image_alt', true) ?>">
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
