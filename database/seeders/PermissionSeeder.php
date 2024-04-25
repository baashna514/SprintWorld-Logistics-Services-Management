<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'SPRINT REF view']);
        Permission::create(['name' => 'SPRINT REF update']);

        Permission::create(['name' => 'AWB Number view']);
        Permission::create(['name' => 'AWB Number update']);

        Permission::create(['name' => 'DEPARTURE STATUS view']);
        Permission::create(['name' => 'DEPARTURE STATUS update']);

        Permission::create(['name' => 'PCS view']);
        Permission::create(['name' => 'PCS update']);

        Permission::create(['name' => 'GROSS WEIGHT view']);
        Permission::create(['name' => 'GROSS WEIGHT update']);

        Permission::create(['name' => 'CW PRE-ALERT view']);
        Permission::create(['name' => 'CW PRE-ALERT update']);

        Permission::create(['name' => 'CW PRINT view']);
        Permission::create(['name' => 'CW PRINT update']);

        Permission::create(['name' => 'DESTINATION view']);
        Permission::create(['name' => 'DESTINATION update']);

        Permission::create(['name' => 'SHIPPER view']);
        Permission::create(['name' => 'SHIPPER update']);

        Permission::create(['name' => 'CLIENT view']);
        Permission::create(['name' => 'CLIENT update']);

        Permission::create(['name' => 'ORIGINAL DOCUMENTS STATUS view']);
        Permission::create(['name' => 'ORIGINAL DOCUMENTS STATUS update']);

        Permission::create(['name' => 'PRE-ALERT DOCS APPROVED? view']);
        Permission::create(['name' => 'PRE-ALERT DOCS APPROVED? update']);

        Permission::create(['name' => 'FREIGHT CHARGE view']);
        Permission::create(['name' => 'FREIGHT CHARGE update']);

        Permission::create(['name' => 'AIRLINE view']);
        Permission::create(['name' => 'AIRLINE update']);

        Permission::create(['name' => 'DEP AIRPORT view']);
        Permission::create(['name' => 'DEP AIRPORT update']);

        Permission::create(['name' => 'TRANSP COST view']);
        Permission::create(['name' => 'TRANSP COST update']);

        Permission::create(['name' => 'TRANSPORTER view']);
        Permission::create(['name' => 'TRANSPORTER update']);

        Permission::create(['name' => 'SECURITY CHARGE view']);
        Permission::create(['name' => 'SECURITY CHARGE update']);

        Permission::create(['name' => 'WAREHOUSE view']);
        Permission::create(['name' => 'WAREHOUSE update']);

        Permission::create(['name' => 'COLL DATE view']);
        Permission::create(['name' => 'COLL DATE update']);

        Permission::create(['name' => 'FLIGHT DATE view']);
        Permission::create(['name' => 'FLIGHT DATE update']);

        Permission::create(['name' => 'PRE-ALERT view']);
        Permission::create(['name' => 'PRE-ALERT update']);

        Permission::create(['name' => 'CUSTOMS ENTRY view']);
        Permission::create(['name' => 'CUSTOMS ENTRY update']);

        Permission::create(['name' => 'MUCR CLOSED view']);
        Permission::create(['name' => 'MUCR CLOSED update']);

        Permission::create(['name' => 'FWB / FHL view']);
        Permission::create(['name' => 'FWB / FHL update']);

        Permission::create(['name' => 'DOCS TO PRINT view']);
        Permission::create(['name' => 'DOCS TO PRINT update']);

        Permission::create(['name' => 'ENTRY COST view']);
        Permission::create(['name' => 'ENTRY COST update']);

        Permission::create(['name' => 'MISC CHARGES view']);
        Permission::create(['name' => 'MISC CHARGES update']);

        Permission::create(['name' => 'IMPORTS HANDLING COST view']);
        Permission::create(['name' => 'IMPORTS HANDLING COST update']);

        Permission::create(['name' => 'CUSTOMS TAXES view']);
        Permission::create(['name' => 'CUSTOMS TAXES update']);

        Permission::create(['name' => 'OVERSEAS CHARGES view']);
        Permission::create(['name' => 'OVERSEAS CHARGES update']);

        Permission::create(['name' => 'INVOICE NUMBER view']);
        Permission::create(['name' => 'INVOICE NUMBER update']);

        Permission::create(['name' => 'INVOICE VALUE view']);
        Permission::create(['name' => 'INVOICE VALUE update']);

        Permission::create(['name' => 'INVOICE AMOUNT COMMENTS view']);
        Permission::create(['name' => 'INVOICE AMOUNT COMMENTS update']);

        Permission::create(['name' => 'GROSS PROFIT view']);
        Permission::create(['name' => 'GROSS PROFIT update']);

        Permission::create(['name' => 'EXPECTED TRANSPORT COST view']);
        Permission::create(['name' => 'EXPECTED TRANSPORT COST update']);

    }
}
