<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPettycash;

class KategoriPettycashSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ================== ACCOMMODATION ==================
            ['kategori' => 'Accomdation', 'sub_kategori' => 'Hotel'],
            ['kategori' => 'Accomdation', 'sub_kategori' => 'Fuel'],
            ['kategori' => 'Accomdation', 'sub_kategori' => 'E-toll'],
            ['kategori' => 'Accomdation', 'sub_kategori' => 'Parking Fee'],
            ['kategori' => 'Accomdation', 'sub_kategori' => 'Other Accomdation'],

            // ================== APARTMENT UTILITIES ==================
            ['kategori' => 'Apartment Utilities', 'sub_kategori' => 'Unit Payment'],
            ['kategori' => 'Apartment Utilities', 'sub_kategori' => 'Unit Utilities'],
            ['kategori' => 'Apartment Utilities', 'sub_kategori' => 'Token Electricity'],
            ['kategori' => 'Apartment Utilities', 'sub_kategori' => 'Wifi'],
            ['kategori' => 'Apartment Utilities', 'sub_kategori' => 'SIM Router'],
            ['kategori' => 'Apartment Utilities', 'sub_kategori' => 'Other Apartment Utilities'],

            // ================== UNIT FACILITIES ==================
            ['kategori' => 'Unit Facilities', 'sub_kategori' => 'Remot'],
            ['kategori' => 'Unit Facilities', 'sub_kategori' => 'Tissue Box'],
            ['kategori' => 'Unit Facilities', 'sub_kategori' => 'Laundry'],
            ['kategori' => 'Unit Facilities', 'sub_kategori' => 'Bedcover Set'],
            ['kategori' => 'Unit Facilities', 'sub_kategori' => 'Other Unit Facilities'],

            // ================== AMENITIES ==================
            ['kategori' => 'Amenities', 'sub_kategori' => 'Tissue'],
            ['kategori' => 'Amenities', 'sub_kategori' => 'Toiletries'],
            ['kategori' => 'Amenities', 'sub_kategori' => 'Gas'],
            ['kategori' => 'Amenities', 'sub_kategori' => 'Galon'],
            ['kategori' => 'Amenities', 'sub_kategori' => 'Snack'],
            ['kategori' => 'Amenities', 'sub_kategori' => 'Coffee'],
            ['kategori' => 'Amenities', 'sub_kategori' => 'Tea Bag'],
            ['kategori' => 'Amenities', 'sub_kategori' => 'Sugar'],
            ['kategori' => 'Amenities', 'sub_kategori' => 'Other Aminities'],

            // ================== MAINTENANCE SERVICE ==================
            ['kategori' => 'Maintenance Service', 'sub_kategori' => 'AC Cleaning'],
            ['kategori' => 'Maintenance Service', 'sub_kategori' => 'Engineer'],
            ['kategori' => 'Maintenance Service', 'sub_kategori' => 'Other Maintenance Service'],

            // ================== AGENCY FEE ==================
            ['kategori' => 'Agency Fee', 'sub_kategori' => 'Laundry Parfume'],
            ['kategori' => 'Agency Fee', 'sub_kategori' => 'Toilet Bag'],
            ['kategori' => 'Agency Fee', 'sub_kategori' => 'Trash Bag'],

            // ================== TRANSFER OTHER AGENCY ==================
            ['kategori' => 'Transfer Other Agency', 'sub_kategori' => 'Vixal'],
            ['kategori' => 'Transfer Other Agency', 'sub_kategori' => 'Baygon'],
            ['kategori' => 'Transfer Other Agency', 'sub_kategori' => 'Dish Soap'],
            ['kategori' => 'Transfer Other Agency', 'sub_kategori' => 'Insect Trap'],
            ['kategori' => 'Transfer Other Agency', 'sub_kategori' => 'Other Cleaniless'],

            // ================== CLEANLINESS ==================
            ['kategori' => 'Cleanliness', 'sub_kategori' => 'Laundry Parfume'],
            ['kategori' => 'Cleanliness', 'sub_kategori' => 'Toilet Bag'],
            ['kategori' => 'Cleanliness', 'sub_kategori' => 'Trash Bag'],
            ['kategori' => 'Cleanliness', 'sub_kategori' => 'Vixal'],
            ['kategori' => 'Cleanliness', 'sub_kategori' => 'Baygon'],
            ['kategori' => 'Cleanliness', 'sub_kategori' => 'Dish Soap'],
            ['kategori' => 'Cleanliness', 'sub_kategori' => 'Insect Trap'],
            ['kategori' => 'Cleanliness', 'sub_kategori' => 'Other Cleaniless'],

            // ================== ENTERTAIN ==================
            ['kategori' => 'Entertaint', 'sub_kategori' => 'Community Fund'],
            ['kategori' => 'Entertaint', 'sub_kategori' => 'Employees Birthday'],
            ['kategori' => 'Entertaint', 'sub_kategori' => 'Other Entertain'],
        ];

        foreach ($data as $item) {
            KategoriPettycash::create($item);
        }
    }
}
