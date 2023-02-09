<section class="px-4 xl:p-20 pt-[100px] pt-[300px] w-full ">
    <!--     Derniers projets -->
    <div class="flex justify-between mt-[100px] xl:mt-[300px]">
        <div class="w-1/2">
            <h2 class="text-2xl leading-snug normal-case xl:text-5xl">
                Mes derniers <span class="text-sky-500 font-display">projets</span><span
                    class="text-indigo-500 font-display">&nbsp;réalisés&nbsp;!</span>
            </h2>
        </div>
        <div class="flex flex-col items-end w-1/2 xl:flex-row xl:justify-end">
            <?php $link = get_field('button') ?>
            <?php $link_second = get_field('secondary_button') ?>
            <button onclick="window.open('<?= esc_url($link['url']) ?>','_blank')"
                    class="px-6 py-3 mb-4 text-xs bg-indigo-600 rounded xl:text-sm xl:px-10 xl:py-4 xl:mb-0 xl:mr-6">
                <?= esc_html($link['title']) ?>
            </button>

            <button onclick="window.open('<?= esc_url($link_second['url']) ?>','_blank')"
                    class="px-6 py-3 mb-4 text-xs bg-sky-600 rounded xl:mb-0 xl:text-sm xl:px-10 xl:py-4">
                <?= esc_html($link_second['title']) ?>
            </button>
        </div>
    </div>

    <div class="flex overflow-hidden flex-row flex-nowrap mt-10 xl:mt-20">
        <div class="flex flex-row flex-nowrap gap-[20px] xl:gap-[40px] animate-scrolling-article">

            <?php for ($y = 0; $y < 4; $y++): ?>
                <?php $i = 0 ?>
                <?php if (have_rows('images')): ?>
                    <?php while (have_rows('images')) : the_row(); ?>
                        <?php $img = get_sub_field('img') ?>
                        <div
                            class="flex flex-col <?= get_field('mobile') ? 'w-[360px] h-[730px] xl:w-[540px] xl:h-[1100px]' : 'w-[480px] h-[270px] xl:w-[960px] xl:h-[540px]' ?> p-10 xl:p-14 pb-4 relative">
                            <div class="custom-card w-full h-full shadow-innercustom bg-<?= $i ?> z-10 my-2"></div>
                        </div>
                        <style>
                            .bg-<?= $i ?> {
                                background: url("<?= $img['url'] ?>") center center no-repeat;
                                background-size: cover;
                            }
                        </style>
                        <?php $i++ ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            <?php endfor; ?>


            <style>
                @keyframes scroll-article {
                    0% {
                        transform: translateX(0);
                    }
                    100% {
                        transform: translateX(-<?= get_field('mobile') ? ((360+20)*$i) . 'px'  : ((480+40)*$i) . 'px' ?>);
                    }
                }

                @keyframes scroll-article-mobile {
                    0% {
                        transform: translateX(0);
                    }
                    100% {
                        transform: translateX(-<?= get_field('mobile') ? ((540+20)*$i) . 'px'  : ((960+40)*$i) . 'px' ?>);
                    }
                }

                .animate-scrolling-article {
                    animation: scroll-article <?= $i*2*3 ?>s linear infinite;
                }

                @media (max-width: 1280px) {
                    .animate-scrolling-article {
                        animation: scroll-article-mobile <?= $i*2*3 ?>s linear infinite;
                    }
                }
            </style>
        </div>
    </div>


    <section class="flex justify-between w-full mt-[100px] xl:mt-[300px] grid grid-cols-8 gap-10 xl:gap-20">
        <article class="col-span-8 xl:col-span-3">
            <h2 class="mb-6 text-2xl leading-snug normal-case xl:text-5xl">
                Résumé du projet
            </h2>
            <div class="flex flex-col gap-4 text-xs xl:text-base">
                <?php the_field('description'); ?>
            </div>
        </article>
        <article class="col-span-8 xl:col-start-5 xl:col-span-3">
            <h2 class="text-2xl leading-snug normal-case xl:text-5xl">
                Les technologies utilisées
            </h2>
            <!--            block technos -->
            <div class="grid grid-cols-4 mt-10 xl:mt-20">
                <?php if (have_rows('technos')): ?>
                    <?php while (have_rows('technos')) : the_row(); ?>
                        <?php $img = get_sub_field('img') ?>
                        <div class="flex relative justify-center items-center">
                            <img src="<?= get_template_directory_uri() ?>/assets/Ressources/icons/3d.svg" alt="wp-test"
                                 class="w-20 h-20">
                            <img src="<?= esc_url($img['url']) ?>" alt="<?= esc_url($img['alt']) ?>"
                                 class="absolute top-1/2 left-1/2 w-6 h-6 transform -translate-x-1/2 -translate-y-1/2 skew-y-30">
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </article>
    </section>

    <!--    Contact part -->
    <div
        class="flex justify-center items-center mt-[100px] xl:mt-[300px] bg-slate-1000 shadow-innercustom rounded p-12 xl:p-20">
        <div>
            <div class="flex justify-center items-center w-full">
                <h2 class="text-xl font-bold text-center xl:text-3xl">Développons <span
                        class="font-black text-indigo-500 xl:font-bold font-display">ensemble</span> vos projets</h2>
            </div>
            <p class="py-8 text-sm text-center xl:py-10 xl:text-sm">
                Une idée, un projet ?
                Je suis là pour répondre à vos demandes et vous accompagner.
                <br><br>
                N’hésitez pas, je serais ravi d’échanger avec vous sur votre projet !
            </p>
            <div class="flex justify-center items-center">
                <button onclick="location.href = '/contact'"
                        class="px-6 py-3 text-xs bg-indigo-600 rounded xl:text-sm xl:px-10 xl:py-4">Me contacter
                </button>
            </div>
        </div>
    </div>
</section>
