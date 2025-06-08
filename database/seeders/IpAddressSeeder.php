<?php

namespace Database\Seeders;

use App\Models\IpAddress;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class IpAddressSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Generate IP addresses for different subnets
        $subnets = [
            '192.168.1',
            '192.168.10',
            '10.0.1',
            '172.16.1'
        ];

        foreach ($subnets as $subnet) {
            for ($i = 1; $i <= 50; $i++) {
                $status = $faker->randomElement(['available', 'assigned', 'reserved']);
                $type = $faker->randomElement(['static', 'dhcp', 'reserved']);

                IpAddress::create([
                    'ip_address' => $subnet . '.' . $i,
                    'subnet_mask' => '255.255.255.0',
                    'gateway' => $subnet . '.1',
                    'dns_primary' => '8.8.8.8',
                    'dns_secondary' => '8.8.4.4',
                    'type' => $type,
                    'status' => $status,
                    'assigned_to' => $status === 'assigned' ? $faker->name() : null,
                    'device_name' => $status === 'assigned' ? $faker->randomElement(['PC-', 'LAPTOP-', 'SERVER-', 'PRINTER-']) . strtoupper($faker->bothify('??##')) : null,
                    'mac_address' => $status === 'assigned' ? $faker->macAddress() : null,
                    'location' => $faker->randomElement(['Office Floor 1', 'Office Floor 2', 'Server Room', 'Meeting Room']),
                    'notes' => $faker->optional()->sentence(),
                ]);
            }
        }
    }
}
