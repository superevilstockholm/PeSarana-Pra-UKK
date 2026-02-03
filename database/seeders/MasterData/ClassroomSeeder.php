<?php

namespace Database\Seeders\MasterData;

use Illuminate\Database\Seeder;

use App\Models\MasterData\Classroom;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classrooms = [
            // RPL
            ["X RPL 1", "Rekayasa Perangkat Lunak"],
            ["X RPL 2", "Rekayasa Perangkat Lunak"],
            ["X RPL 3", "Rekayasa Perangkat Lunak"],
            ["XI RPL 1", "Rekayasa Perangkat Lunak"],
            ["XI RPL 2", "Rekayasa Perangkat Lunak"],
            ["XI RPL 3", "Rekayasa Perangkat Lunak"],
            ["XII RPL 1", "Rekayasa Perangkat Lunak"],
            ["XII RPL 2", "Rekayasa Perangkat Lunak"],
            ["XII RPL 3", "Rekayasa Perangkat Lunak"],
            // TITL
            ["X TITL 1", "Teknik Instalasi Tenaga Listrik"],
            ["X TITL 2", "Teknik Instalasi Tenaga Listrik"],
            ["X TITL 3", "Teknik Instalasi Tenaga Listrik"],
            ["XI TITL 1", "Teknik Instalasi Tenaga Listrik"],
            ["XI TITL 2", "Teknik Instalasi Tenaga Listrik"],
            ["XI TITL 3", "Teknik Instalasi Tenaga Listrik"],
            ["XII TITL 1", "Teknik Instalasi Tenaga Listrik"],
            ["XII TITL 2", "Teknik Instalasi Tenaga Listrik"],
            ["XII TITL 3", "Teknik Instalasi Tenaga Listrik"],
        ];

        foreach ($classrooms as $classroom) {
            Classroom::updateOrCreate([
                'name' => $classroom[0],
            ],[
                'name' => $classroom[0],
                'description' => $classroom[1],
            ]);
        }
    }
}
