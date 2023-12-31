<?php

namespace Database\Seeders;

use App\Events\GenerateDataStore;
use App\Models\License;
use App\Models\Package;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedBrand extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('staffs')->delete();
        DB::table('positions')->delete();
        DB::table('departments')->delete();
        DB::table('stores')->delete();
        DB::table('packages')->delete();
        DB::table('licenses')->delete();

        $faker = \Faker\Factory::create();
        // package
        $package = Package::create([
            'code' => 'basic',
            'name' => 'Gói cơ bản',
            'amount' => 10000000,
            'max_user' => 10,
            'status' => Package::STATUS_ACTIVE,
            'modules' => json_encode(["staff"])
        ]);

        // store
        $store = Store::create([
            'business_type_id' => 2,
            'name' => 'Cửa hàng cafe TT',
            'phone' => $faker->phoneNumber(),
            'address' => $faker->address(),
            'status' => Store::STATUS_ACTIVE,
        ]);

        // license
        License::create([
            'store_id' => $store->id,
            'package_id' => $package->id,
            'status' => License::STATUS_ACTIVE,
        ]);
        event(new GenerateDataStore($store));
    }
}
