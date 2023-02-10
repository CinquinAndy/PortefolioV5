<?php

use App\Blocs\BlocArticle;
use App\Blocs\BlocHero;
use Mailgun\Mailgun;

// call api func
function callAPI($token)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('secret' => env('CAPCHA'), 'response' => $token)
    ));

    return curl_exec($curl);
}

function traitement_formulaire_contact()
{
    unset($_GET['error'], $_GET['fine']);
    if (isset($_POST['envoyer-message']) && isset($_POST['message-verif'])) {
        $string_exp = "/^[A-Za-z0-9 .'-]+$/";
        $email_to = "contact@andy-cinquin.fr";
        $email_subject = "Mail - Andy Cinquin";
        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
        $phone_exp = '/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/';

        if (wp_verify_nonce($_POST['message-verif'], 'envoyer-message')) {
            // On vérifie que le champ "Pot de miel" est vide
            if (isset($_POST['raison']) && empty($_POST['raison'])) {
                if ($_POST['g-recaptcha-response'] != "") {
                    $make_call = callAPI($_POST['g-recaptcha-response']);
                    $response = json_decode($make_call);
                    if ($response->success === false) {
                        $url = add_query_arg('erreur', 'token-invalide', wp_get_referer());
                        wp_safe_redirect($url);
                        exit();
                    } else {
                        if ($_POST['name'] != "") {
                            $name = trim($_POST['name']);
                            $name = strip_tags($name);
                            $name = filter_var($name, FILTER_SANITIZE_STRING);
                            $name = htmlspecialchars($name);

                            if (!preg_match($string_exp, $name)) {
                                $url = add_query_arg('erreur', 'nom-invalide', wp_get_referer());
                                wp_safe_redirect($url);
                                exit();
                            }
                        }
                        if ($_POST['company'] != "") {
                            $company = trim($_POST['company']);
                            $company = strip_tags($company);
                            $company = filter_var($company, FILTER_SANITIZE_STRING);
                            $company = htmlspecialchars($company);

                            if (!preg_match($string_exp, $company)) {
                                $url = add_query_arg('erreur', 'entreprise-invalide', wp_get_referer());
                                wp_safe_redirect($url);
                                exit();
                            }
                        }
                        if ($_POST['email'] != "") {
                            $email = trim($_POST['email']);
                            $email = filter_var($email, FILTER_SANITIZE_STRING);
                            $email = htmlspecialchars($email);

                            if (!preg_match($email_exp, $email)) {
                                $url = add_query_arg('erreur', 'mail-invalide', wp_get_referer());
                                wp_safe_redirect($url);
                                exit();
                            }
                        }
                        if ($_POST['phone'] != "") {
                            $phone = trim($_POST['phone']);
                            $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
                            $phone = htmlspecialchars($phone);

                            if (!preg_match($phone_exp, $phone)) {
                                $url = add_query_arg('erreur', 'tel-invalide', wp_get_referer());
                                wp_safe_redirect($url);
                                exit();
                            }
                        }
                        if ($_POST['message'] != "") {
                            $message = trim($_POST['message']);
                            $message = strip_tags($message);
                            $message = htmlspecialchars($message);
                            $message = filter_var($message, FILTER_SANITIZE_STRING);

                            if (!preg_match($string_exp, $company)) {
                                $url = add_query_arg('erreur', 'message-invalide', wp_get_referer());
                                wp_safe_redirect($url);
                                exit();
                            }
                        }

                        $email_message = "
                            <html>
                            <body>
                            <div style = 'overflow: hidden;' >
                            <font size = '-1' >
                            <u ></u >
                            <div style = 'margin:0;padding:10px 0' bgcolor = '#ffffff' marginwidth = '0' marginheight = '0' >
                            <br >
                            <table border = '0' width = '100%' height = '100%' cellpadding = '0' cellspacing = '0' bgcolor = '#ffffff' >
                            <tbody ><tr > <td align = 'center' valign = 'top' bgcolor = '#ffffff' style = 'background-color:#ffffff' >
                            <table border = '0' width = '600' cellpadding = '0' cellspacing = '0' bgcolor = '#ffffff' > <tbody ><tr >
                            <td bgcolor = '#ffffff' style = 'background-color:#ffffff;padding-left:30px;padding-right:30px;font-size:14px;line-height:20px;font-family:Helvetica,sans-serif;color:#333' >
                            <div style = 'text-align:center;margin-bottom:10px;margin-top:20px' >
                            <img alt = ' ' height = '60' width = '250' style = 'height:60px;width:250px'
                            src = 'https://andy-cinquin.fr/themes/andycinquin/assets/Ressources/icons/LogoCinquinAndy.svg' >
                            </a >
                            </div >
                            Récapitulatif du mail en provenance de andy-cinquin.fr :
                            <br ><br >
                            Nom / Prénom : " . $name . "
                            <br>
                            Entreprise : " . $company . "
                            <br>
                            mail : <a style = 'font-style:italic;color:#627BDF'
                            href = 'mailto:" . $email . "'>
                            " . $email . "
                            </a >
                            <br>
                            Tél : " . $phone . "
                            <br>
                            <br>
                            Message :
                            <br>
                            <div style = 'text-align:center' >
                            <font color = '#888888' >
                            " . $message . "
                            <br></font>
                            <br>
                            <br>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            <br>
                            <br>
                            </div>
                            </font>
                            </div>
                            </body>
                            </html>";

                        $secret_mail_private = env("WP_MAILGUN_PRIVATE", "");
                        $secret_mail_public = env("WP_MAILGUN_PUBLIC", "");
                        $secret_mail_webhook = env("WP_MAILGUN_WEBHOOK", "");

                        $mg = Mailgun::create($secret_mail_private, 'https://api.mailgun.net');

                        // Now, compose and send your message.
                        // $mg->messages()->send($domain, $params);
                        $mg->messages()->send('sandbox4a143b58cf0a4ccdbfff1e1f410de28d.mailgun.org', [
                            'from' => 'postmaster@sandbox4a143b58cf0a4ccdbfff1e1f410de28d.mailgun.org',
                            'to' => 'contact@andy-cinquin.fr',
                            'subject' => 'Message de ' . $name . ' depuis le site andy-cinquin.fr',
                            'text' => $email_message
                        ]);

                        // You can see a record of this email in your logs: https://app.mailgun.com/app/logs.

                        // You can send up to 300 emails/day from this sandbox server.
                        // Next, you should add your own domain so you can send 10000 emails/month for free.
                        $url = add_query_arg('fine', 'message-valide', wp_get_referer());
                        wp_safe_redirect($url);
                        exit();
                    }
                }
            }

            // Si le champ anti bot n'était pas vide
            $url = add_query_arg('erreur', 'message-invalide', wp_get_referer());
            wp_safe_redirect($url);
            exit();
        }
    }
}

add_action('template_redirect', 'traitement_formulaire_contact');

function andycinquin_enqueue_styles_scripts()
{
    if (!is_home() && !is_single()) {
//        différent des articles / et page d'article général (home : general articles ) & single (article spécifique)
    }

    if (is_page('contact')) {
//        page de contact

    }

    if (is_front_page()) {
//        page d'accueil

    }
    if (is_home()) {
//        blog general
        wp_enqueue_script('andycinquin-script-app-webpack', get_template_directory_uri() . '/assets/app.js', 'andycinquin-script-app-webpack', '1', true);
        wp_enqueue_script('andycinquin-script-app', get_template_directory_uri() . '/assets/js/app.js', 'andycinquin-script-app', '1', true);
    }

    $dependencies = [];
    wp_register_style('btn', get_template_directory_uri() . '/assets/css/btn.css');
    $dependencies[] = 'btn';
    wp_register_style('carroussel', get_template_directory_uri() . '/assets/css/carroussel.css');
    $dependencies[] = 'carroussel';
    wp_register_style('distorsions', get_template_directory_uri() . '/assets/css/distorsions.css');
    $dependencies[] = 'distorsions';
    wp_register_style('main', get_template_directory_uri() . '/assets/css/main.css');
    $dependencies[] = 'main';
    wp_register_style('nav', get_template_directory_uri() . '/assets/css/nav.css');
    $dependencies[] = 'nav';

    wp_enqueue_style('andycinquin-style', get_stylesheet_uri(), $dependencies);

    wp_enqueue_script('andycinquin-script-nav', get_template_directory_uri() . '/assets/js/nav.js', 'andycinquin-script-nav', '1', true);

    if (!is_admin()) {
        // optimisation
        wp_dequeue_style('wp-block-library');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');

        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');

        wp_deregister_script('wp-embed');
        wp_deregister_script('wp-emoji');
        wp_deregister_script('jquery');  // Bonus: remove jquery too if it's not required
    }
}

add_action('wp_enqueue_scripts', 'andycinquin_enqueue_styles_scripts');

add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    register_nav_menu('andycinquin_menu', 'menu personnalisée pour andycinquin');
    add_theme_support('editor-styles');
});

add_filter('block_categories_all', function (array $categories) {
    return array_merge(
        $categories,
        [
            [
                'slug' => 'andycinquin',
                'title' => 'Andy Cinquin',
            ],
        ]
    );
}, 10, 1);

function add_type_attribute($tag, $handle, $src)
{
    // if not your script, do nothing and return original $tag
    if ('andycinquin-script-app' !== $handle) {
        return $tag;
    }
    // change the script tag by adding type="module" and return it.
    $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    return $tag;
}

add_filter('script_loader_tag', 'add_type_attribute', 10, 3);

BlocHero::register();
BlocArticle::register();
