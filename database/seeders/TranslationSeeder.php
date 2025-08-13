<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Locale;
use App\Models\Tag;
use App\Models\Translation;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        $locales = [
            ['code' => 'en', 'name' => 'English'],
            ['code' => 'fr', 'name' => 'French'],
            ['code' => 'es', 'name' => 'Spanish'],
        ];

        foreach ($locales as $locale) {
            Locale::firstOrCreate(['code' => $locale['code']], ['name' => $locale['name']]);
        }

        $tags = ['web', 'mobile', 'desktop'];
        foreach ($tags as $tagName) {
            Tag::firstOrCreate(['name' => $tagName]);
        }

        $translations = [
            ['key' => 'morning', 'locale' => 'en', 'value' => 'Good morning', 'tags' => ['web', 'mobile', 'desktop']],
            ['key' => 'morning', 'locale' => 'fr', 'value' => 'Bonjour', 'tags' => ['web', 'mobile']],
            ['key' => 'morning', 'locale' => 'es', 'value' => 'Buenos días', 'tags' => ['web']],

            ['key' => 'afternoon', 'locale' => 'en', 'value' => 'Good afternoon', 'tags' => ['web', 'mobile', 'desktop']],
            ['key' => 'afternoon', 'locale' => 'fr', 'value' => 'Bon après-midi', 'tags' => ['web', 'mobile']],
            ['key' => 'afternoon', 'locale' => 'es', 'value' => 'Buenas tardes', 'tags' => ['web']],

            ['key' => 'evening', 'locale' => 'en', 'value' => 'Good evening', 'tags' => ['web', 'mobile', 'desktop']],
            ['key' => 'evening', 'locale' => 'fr', 'value' => 'Bonsoir', 'tags' => ['web', 'mobile']],
            ['key' => 'evening', 'locale' => 'es', 'value' => 'Buenas noches', 'tags' => ['web']],

            ['key' => 'goodbye', 'locale' => 'en', 'value' => 'Goodbye', 'tags' => ['web', 'mobile', 'desktop']],
            ['key' => 'goodbye', 'locale' => 'fr', 'value' => 'Au revoir', 'tags' => ['web', 'mobile']],
            ['key' => 'goodbye', 'locale' => 'es', 'value' => 'Adiós', 'tags' => ['web']],

            ['key' => 'see_you', 'locale' => 'en', 'value' => 'See you later', 'tags' => ['web', 'mobile', 'desktop']],
            ['key' => 'see_you', 'locale' => 'fr', 'value' => 'À plus tard', 'tags' => ['web', 'mobile']],
            ['key' => 'see_you', 'locale' => 'es', 'value' => 'Hasta luego', 'tags' => ['web']],

            ['key' => 'submit', 'locale' => 'en', 'value' => 'Submit', 'tags' => ['web', 'mobile', 'desktop']],
            ['key' => 'submit', 'locale' => 'fr', 'value' => 'Soumettre', 'tags' => ['web', 'mobile']],
            ['key' => 'submit', 'locale' => 'es', 'value' => 'Enviar', 'tags' => ['web']],

            ['key' => 'cancel', 'locale' => 'en', 'value' => 'Cancel', 'tags' => ['web', 'mobile', 'desktop']],
            ['key' => 'cancel', 'locale' => 'fr', 'value' => 'Annuler', 'tags' => ['web', 'mobile']],
            ['key' => 'cancel', 'locale' => 'es', 'value' => 'Cancelar', 'tags' => ['web']],

            ['key' => 'welcome', 'locale' => 'en', 'value' => 'Welcome to our app', 'tags' => ['web', 'mobile', 'desktop']],
            ['key' => 'welcome', 'locale' => 'fr', 'value' => 'Bienvenue sur notre application', 'tags' => ['web', 'mobile']],
            ['key' => 'welcome', 'locale' => 'es', 'value' => 'Bienvenido a nuestra aplicación', 'tags' => ['web']],

            ['key' => 'new_message', 'locale' => 'en', 'value' => 'You have a new message', 'tags' => ['web', 'mobile', 'desktop']],
            ['key' => 'new_message', 'locale' => 'fr', 'value' => 'Vous avez un nouveau message', 'tags' => ['web', 'mobile']],
            ['key' => 'new_message', 'locale' => 'es', 'value' => 'Tienes un nuevo mensaje', 'tags' => ['web']],

            ['key' => 'account_created', 'locale' => 'en', 'value' => 'Your account has been created', 'tags' => ['web', 'mobile', 'desktop']],
            ['key' => 'account_created', 'locale' => 'fr', 'value' => 'Votre compte a été créé', 'tags' => ['web', 'mobile']],
            ['key' => 'account_created', 'locale' => 'es', 'value' => 'Tu cuenta ha sido creada', 'tags' => ['web']],
        ];

        foreach ($translations as $item) {
            $locale = Locale::where('code', $item['locale'])->first();

            $translation = Translation::firstOrCreate(
                [
                    'key' => $item['key'],
                    'locale_id' => $locale->getKey()
                ],
                [
                    'value' => $item['value']
                ]
            );

            if (!empty($item['tags'])) {
                $tagIds = Tag::whereIn('name', $item['tags'])->pluck('id');
                $translation->tags()->sync($tagIds);
            }
        }
    }
}
