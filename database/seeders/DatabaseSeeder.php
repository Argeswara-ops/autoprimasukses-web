<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@autoprimasukses.com')],
            [
                'name' => 'Administrator APS',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin123!')),
            ]
        );

        $products = [
            ['Huber Epoxy Hardener KL 0.2 Lt 0000 - CLEAR', '0.2 Lt', 6, 22000],
            ['Huber Epoxy Hardener KL 0.05 Lt 0000 - CLEAR', '0.05 Lt', 12, 9000],
            ['Huber Epoxy Primer KL 0.2 Lt HB009 - GREY', '0.2 Lt', 12, 21000],
            ['Huber Epoxy Primer KL 0.8 Lt HB009 - GREY', '0.8 Lt', 6, 71000],
            ['Huber Degreaser KL 1 Lt 0000 - CLEAR', '1 Lt', 6, 45000],
            ['Huber Clear LC 001 Clearcoats KL 0.8 Lt 0000 - CLEAR', '0.8 Lt', 6, 66000],
            ['Huber Clear LC 001 Hardener KL 0.2 Lt 0000 - CLEAR', '0.2 Lt', 6, 35000],
            ['Huber PU QS 401 Hardener KL 0.2 Lt 0000 - TRANSPARANT', '0.2 Lt', 6, 74000],
            ['Huber PU QS 401 Primer KL 0.8 Lt HB009 - GREY', '0.8 Lt', 6, 25000],
            ['Huber Epoxy FD Hardener KL 0.2 Lt 0000 - TRANSPARANT', '0.2 Lt', 6, 71000],
            ['Huber Epoxy FD Primer KL 0.8 Lt HB009 - GREY', '0.8 Lt', 6, 27000],
            ['Huber PP Primer KL 0.2 Lt 0000 - CLEAR', '0.2 Lt', 12, 20000],
            ['Huber PP Primer KL 1 Lt 0000 - CLEAR', '1 Lt', 6, 70000],
            ['Huber Epoxy Filler EF Hardener KL 0.2 Lt 0000 - TRANSPARANT', '0.2 Lt', 6, 23000],
            ['Huber Epoxy Filler EF Primer KL 0.8 Lt HB009 - GREY', '0.8 Lt', 6, 58000],
            ['Huber Clear GP 101 Clearcoats KL 0.8 Lt 0000 - CLEAR', '0.8 Lt', 6, 80000],
            ['Huber Clear GP 101 Hardener KL 0.2 Lt 0000 - CLEAR', '0.2 Lt', 6, 34000],
            ['Huber PU Clear Doff Hardener KL 0.2 Lt 0000 - CLEAR', '0.2 Lt', 6, 41000],
            ['Huber PU Clear Doff KL 0.8 Lt 0000 - CLEAR', '0.8 Lt', 6, 104000],
            ['Huber Clear MS 201 Hardener KTK 0.5 Lt 0000 - TRANSPARANT', '0.5 Lt', 6, 92000],
            ['Huber Clear MS 201 Clearcoat KTK 1 Lt 0000 - CLEAR', '1 Lt', 6, 192000],
            ['Huber PU Thinner KL 1 Lt 0000 - CLEAR', '1 Lt', 6, 47000],
            ['Huber PU Clear Base 2K PL 20 Lt H000 - CLEAR', '20 Lt', 1, 2068000],
            ['Huber T200 Basecoat SB PL 20 Lt H000 - CLEAR BASE', '20 Lt', 1, 2068000],
            ['Huber T200 Basecoat SB PL 20 Lt H001 - CLEAR BASE Transparant', '20 Lt', 1, 2068000],
        ];

        foreach ($products as [$name, $size, $boxContent, $price]) {
            $nl = strtolower($name);
            if (str_contains($nl, 'degreaser')) {
                $category = 'Degreaser';
            } elseif (str_contains($nl, 'thinner')) {
                $category = 'Thinner';
            } elseif (str_contains($nl, 'basecoat') || str_contains($nl, 'top coat')) {
                $category = 'Basecoat';
            } elseif (str_contains($nl, 'hardener')) {
                $category = 'Hardener';
            } elseif (str_contains($nl, 'primer') || str_contains($nl, 'filler') || str_contains($nl, 'putty')) {
                $category = 'Primer';
            } elseif (str_contains($nl, 'clear')) {
                $category = 'Clearcoats';
            } else {
                $category = 'Clearcoats';
            }

            Product::updateOrCreate(
                ['name' => $name, 'size' => $size],
                [
                    'sku' => 'APS-'.substr(md5($name.$size), 0, 8),
                    'category' => $category,
                    'brand' => 'Huber',
                    'stock' => 0,
                    'box_content' => $boxContent,
                    'unit_per_box' => $boxContent,
                    'selling_price' => $price,
                    'purchase_price' => $price,
                ]
            );
        }
    }
}
