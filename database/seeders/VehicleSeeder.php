<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Datos de ejemplo para probar Ficha de Vehículo, Boletas, Stickers y Actas
     * mientras no exista la conexión real con la API de SAP.
     */
    public function run(): void
    {
        $vehiculos = [
            [
                'placa' => 'HAB-1234',
                'chasis' => 'JHLRD78876C123456',
                'motor' => 'MT9988776',
                'marca' => 'Toyota',
                'modelo' => 'Corolla',
                'linea' => 'Sedán',
                'anio' => 2022,
                'color' => 'Blanco',
                'cilindraje' => '1800 cc',
            ],
            [
                'placa' => 'PBH-5678',
                'chasis' => '1FTFW1ET5DFA98765',
                'motor' => 'MT5544332',
                'marca' => 'Ford',
                'modelo' => 'F-150',
                'linea' => 'Pick-up',
                'anio' => 2021,
                'color' => 'Gris',
                'cilindraje' => '3500 cc',
            ],
            [
                'placa' => 'HAM-9012',
                'chasis' => 'MLHPM1234K1023456',
                'motor' => 'MT1122334',
                'marca' => 'Honda',
                'modelo' => 'CB190R',
                'linea' => 'Motocicleta',
                'anio' => 2023,
                'color' => 'Rojo',
                'cilindraje' => '184 cc',
            ],
        ];

        foreach ($vehiculos as $data) {
            Vehicle::updateOrCreate(['placa' => $data['placa']], $data);
        }
    }
}
