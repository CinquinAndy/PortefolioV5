<?php

namespace App\Blocs;

use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\WysiwygEditor;

class BlocHero extends Bloc
{
    public static $name = 'hero';
    public static $label = 'Hero';
    public static $icon = 'admin-home';

    protected static function fields(): array
    {
        return [
            Text::make('Titre de la page', 'hero_title')->required()->placeholder("Titre de la page"),
            Repeater::make('Services', 'services')->required()->fields([
                Text::make('Titre', 'title')->required()->placeholder("Titre du service"),
                WysiwygEditor::make('Description', 'description')->toolbar('basic')->mediaUpload(false)->tabs('visual'),
                Image::make('Image', 'img')->required()
            ]),
        ];
    }
}
?>
