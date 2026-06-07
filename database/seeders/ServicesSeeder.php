<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name'        => 'Holzbau & Zimmerei',
                'description' => 'Dachstühle, Holzrahmenbau und Stützen-Balken-Konstruktionen aus unserer eigenen Werkstatt.',
                'price'       => 1800.00,
            ],
            [
                'name'        => 'Renovationen & Umbauten',
                'description' => 'Bestehende Gebäude modernisieren, Bausubstanz erhalten und nachhaltig aufwerten.',
                'price'       => 2200.00,
            ],
            [
                'name'        => 'Innenausbau & Schreinerei',
                'description' => 'Massgeschneiderte Küchen, Einbauschränke, Treppen und Fensterfronten nach Mass.',
                'price'       => 1500.00,
            ],
            [
                'name'        => 'Gewerbebau',
                'description' => 'Hallen, Bürogebäude und Lagerinfrastruktur — termingerecht und schlüsselfertig.',
                'price'       => 5000.00,
            ],
            [
                'name'        => 'Dach & Fassade',
                'description' => 'Neue Dacheindeckungen, Dachausbauten, hinterlüftete Fassaden nach Minergie-Standard.',
                'price'       => 2800.00,
            ],
            [
                'name'        => 'Bauleitung & Planung',
                'description' => 'Bauleitung, Koordination der Handwerker und Interessenvertretung gegenüber Behörden.',
                'price'       => 1200.00,
            ],
        ];

        foreach ($services as $service) {
            DB::table('services')->insertOrIgnore(
                array_merge($service, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
