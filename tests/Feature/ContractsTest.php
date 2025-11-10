<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContractsTest extends TestCase
{
    use RefreshDatabase;

    public function test_finance_dashboard_shows_contract_count()
    {
        $user = User::factory()->create();

        // create 3 contracts
        $now = Carbon::now();
        DB::table('contracts')->insert([
            ['customer' => 'C1', 'products' => 'P1', 'accesories' => 'A1', 'created_at' => $now, 'updated_at' => $now],
            ['customer' => 'C2', 'products' => 'P2', 'accesories' => 'A2', 'created_at' => $now, 'updated_at' => $now],
            ['customer' => 'C3', 'products' => 'P3', 'accesories' => 'A3', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->actingAs($user)
            ->get(route('dashboards.finance'))
            ->assertStatus(200)
            ->assertSee('3');
    }

    public function test_contracts_page_lists_contracts()
    {
        $user = User::factory()->create();

        $now = Carbon::now();
        DB::table('contracts')->insert([
            ['customer' => 'ACME Corp', 'products' => 'Widgets', 'accesories' => 'None', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->actingAs($user)
            ->get(route('dashboards.contracts'))
            ->assertStatus(200)
            ->assertSee('ACME Corp');
    }
}
