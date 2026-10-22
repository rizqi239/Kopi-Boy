<?php

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can record a stocktake and update menu stock', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $coffee = Menu::create(['name' => 'Kopi Susu', 'price' => 18000, 'stock' => 12]);
    $tea = Menu::create(['name' => 'Teh', 'price' => 10000, 'stock' => 3]);

    $response = $this->actingAs($admin)->post(route('stock-opnames.store'), [
        'counts' => [
            $coffee->id => 10,
            $tea->id => 5,
        ],
        'notes' => 'Pemeriksaan akhir hari',
    ]);

    $response->assertRedirect(route('stock-opnames.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('menus', ['id' => $coffee->id, 'stock' => 10]);
    $this->assertDatabaseHas('menus', ['id' => $tea->id, 'stock' => 5]);
    $this->assertDatabaseHas('stock_opnames', [
        'user_id' => $admin->id,
        'notes' => 'Pemeriksaan akhir hari',
    ]);
    $this->assertDatabaseHas('stock_opname_items', [
        'menu_id' => $coffee->id,
        'expected_stock' => 12,
        'counted_stock' => 10,
        'difference' => -2,
    ]);
    $this->assertDatabaseHas('stock_opname_items', [
        'menu_id' => $tea->id,
        'expected_stock' => 3,
        'counted_stock' => 5,
        'difference' => 2,
    ]);
});

test('stocktake requires a count for every menu and leaves stock unchanged when incomplete', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $coffee = Menu::create(['name' => 'Kopi Susu', 'price' => 18000, 'stock' => 12]);
    Menu::create(['name' => 'Teh', 'price' => 10000, 'stock' => 3]);

    $response = $this->actingAs($admin)->from(route('stock-opnames.index'))->post(route('stock-opnames.store'), [
        'counts' => [$coffee->id => 8],
    ]);

    $response->assertRedirect(route('stock-opnames.index'))
        ->assertSessionHasErrors('counts');

    $this->assertDatabaseHas('menus', ['id' => $coffee->id, 'stock' => 12]);
    $this->assertDatabaseCount('stock_opnames', 0);
});

test('customers cannot manage stock opname', function () {
    $customer = User::factory()->create(['role' => 'pelanggan']);

    $this->actingAs($customer)
        ->get(route('stock-opnames.index'))
        ->assertForbidden();
});

test('management page links to finances and only shows stock opname to admins', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $customer = User::factory()->create(['role' => 'pelanggan']);

    $this->actingAs($admin)
        ->get(route('management.index'))
        ->assertOk()
        ->assertSee(route('payments.index'))
        ->assertSee(route('stock-opnames.index'));

    $this->actingAs($customer)
        ->get(route('management.index'))
        ->assertOk()
        ->assertSee(route('payments.index'))
        ->assertDontSee(route('stock-opnames.index'));
});
