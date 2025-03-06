<?php

namespace Database\Seeders;

use App\Models\Drug;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        Drug::factory()->create([
            'name' => 'Morfina',
            'description' => 'Opioide potente utilizado para el alivio del dolor severo.',
            'price' => 1200.00, // MXN
            'quantity' => 20,
        ]);

        Drug::factory()->create([
            'name' => 'Oxicodona',
            'description' => 'Analgésico opioide para el tratamiento del dolor moderado a severo.',
            'price' => 1000.00, // MXN
            'quantity' => 15,
        ]);

        Drug::factory()->create([
            'name' => 'Fentanilo',
            'description' => 'Opioide sintético extremadamente fuerte para el dolor crónico.',
            'price' => 3000.00, // MXN
            'quantity' => 10,
        ]);
        Drug::factory()->create([
            'name' => 'Tramadol',
            'description' => 'Analgésico opioide utilizado para el tratamiento del dolor moderado.',
            'price' => 600.00, // MXN
            'quantity' => 20,
        ]);
        Drug::factory()->create([
            'name' => 'Metilfenidato',
            'description' => 'Estimulante usado comúnmente para tratar el TDAH.',
            'price' => 850.00, // MXN
            'quantity' => 30,
        ]);
        Drug::factory()->create([
            'name' => 'Olanzapina',
            'description' => 'Medicamento antipsicótico para esquizofrenia y trastornos afectivos.',
            'price' => 650.00, // MXN
            'quantity' => 15,
        ]);
        Drug::factory()->create([
            'name' => 'Alprazolam',
            'description' => 'Benzodiacepina utilizada para tratar trastornos de ansiedad y pánico.',
            'price' => 350.00, // MXN
            'quantity' => 30,
        ]);
        Drug::factory()->create([
            'name' => 'Clonazepam',
            'description' => 'Medicamento utilizado para tratar trastornos de pánico y epilepsia.',
            'price' => 400.00, // MXN
            'quantity' => 20,
        ]);
    }
}
