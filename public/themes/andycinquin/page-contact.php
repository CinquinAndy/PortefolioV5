<?php get_header(); ?>
<!-- HERO -->
<div class="flex relative justify-center items-center w-screen h-screen">
    <div class="grid absolute top-0 left-0 z-30 grid-cols-8 px-4 w-full xl:px-20">
        <form action="#" method="post"
              class="xl:col-start-3 col-span-8 xl:col-span-4 mt-[20vh] xl:mt-[15vh] grid grid-cols-3 xl:grid-cols-6 gap-10">
            <?php wp_nonce_field('envoyer-message', 'message-verif') ?>
            <div class="flex flex-col col-span-3 gap-2 xl:gap-4 xl:col-span-6">
                <h1 class="z-20 text-3xl font-bold tracking-widest uppercase xl:text-6xl">CONTACT</h1>
            </div>
            <div class="flex flex-col col-span-3 gap-2 xl:gap-4">
                <label for="name" class="text-xs xl:text-sm">Nom et prénom</label>
                <input type="text" name="name" id="name" class="text-xs xl:text-base border-0 bg-slate-1000 h-[50px]">
            </div>
            <div class="flex flex-col col-span-3 gap-2 xl:gap-4">
                <label for="email" class="text-xs xl:text-sm">Email</label>
                <input type="email" name="email" id="email"
                       class="text-xs xl:text-base border-0 bg-slate-1000 h-[50px]">
            </div>
            <div class="flex flex-col col-span-3 gap-2 xl:gap-4">
                <label for="phone" class="text-xs xl:text-sm">Téléphone</label>
                <input type="text" name="phone" id="phone" class="text-xs xl:text-base border-0 bg-slate-1000 h-[50px]">
            </div>
            <div class="flex flex-col col-span-3 gap-2 xl:gap-4">
                <label for="company" class="text-xs xl:text-sm">Société (Facultatif)</label>
                <input type="text" name="company" id="company"
                       class="text-xs xl:text-base border-0 bg-slate-1000 h-[50px]">
            </div>
            <input type="hidden" name="raison">
            <div class="flex flex-col col-span-3 gap-2 xl:gap-4 xl:col-span-6">
                <label for="message" class="text-xs xl:text-sm">Message</label>
                <textarea rows="6" name="message" id="message"
                          class="text-xs border-0 xl:text-base bg-slate-1000"></textarea>
                <p class="text-xs italic">Lors de la validation de ce formulaire, vous consentez à ce que les données
                    soumises soient collectées et stockées en vue d'être utilisées pour traiter votre demande de
                    contact.</p>
                <div class="flex justify-end items-center my-6 w-full text-center">
                    <div class="g-recaptcha" data-sitekey="6LexB0geAAAAAKnZLXhHzjig8vLyZdkxKhxHKfaY"
                         data-theme="dark"></div>
                </div>
                <div class="flex justify-end items-end mt-4">
                    <input type="submit"
                           class="px-6 py-3 text-xs bg-indigo-600 rounded hover:cursor-pointer xl:text-sm xl:px-20 xl:py-4"
                           name="envoyer-message" value="Envoyer le message">
                </div>
            </div>

        </form>

    </div>


    <div class="flex relative justify-center items-center w-screen h-screen">
        <h1 class="z-20 text-3xl font-light font-semibold tracking-widest uppercase xl:text-8xl"></h1>
        <div
            class="flex absolute top-1/2 left-1/2 z-10 justify-start items-center w-3/5 transform -translate-x-1/2 -translate-y-1/2">
            <img src="<?= get_template_directory_uri() ?>/assets/Ressources/icons/LogoCinquinAndy.svg"
                 alt="Développeur Freelance - Logo"
                 class="mb-32 ml-16 opacity-20 brightness-75 -rotate-12 w-112 h-112">
        </div>
    </div>
</div>
<?php get_footer(); ?>
