<?php

use App\Models\Expense;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('finance totals completed customer purchases and displays their customer and products', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $customer = User::factory()->create(['role' => 'pelanggan', 'name' => 'Pelanggan Kedai']);

    $paidOrder = Order::create([
        'invoice' => 'INV-PAID-001',
        'user_id' => $customer->id,
        'total' => 25000,
        'payment_method' => 'Cash',
        'status' => 'paid',
    ]);
    OrderItem::create([
        'order_id' => $paidOrder->id,
        'name' => 'Kopi Susu',
        'price' => 25000,
        'quantity' => 1,
        'subtotal' => 25000,
    ]);
    Payment::create([
        'order_id' => $paidOrder->id,
        'amount' => 25000,
        'method' => 'Cash',
        'status' => 'completed',
        'paid_at' => now(),
    ]);

    $pendingOrder = Order::create([
        'invoice' => 'INV-PENDING-001',
        'user_id' => $customer->id,
        'total' => 18000,
        'payment_method' => 'Cash',
        'status' => 'pending',
    ]);
    Payment::create([
        'order_id' => $pendingOrder->id,
        'amount' => 18000,
        'method' => 'Cash',
        'status' => 'pending',
    ]);

    $this->actingAs($admin)
        ->get(route('management.finance'))
        ->assertOk()
        ->assertSee('Rp25.000')
        ->assertSee('Pelanggan Kedai')
        ->assertSee('Kopi Susu × 1')
        ->assertSee('Transaksi pelanggan lunas')
        ->assertDontSee('INV-PENDING-001')
        ->assertViewHas('financeSummary', ['revenue' => 25000, 'transactions' => 1])
        ->assertViewHas('payments', fn ($payments) => $payments->count() === 1);
});

test('customers cannot access the finance view', function () {
    $customer = User::factory()->create(['role' => 'pelanggan']);

    $this->actingAs($customer)
        ->get(route('management.finance'))
        ->assertForbidden();
});

test('admin can record an expense and the finance summary subtracts it from revenue', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('management.expenses.store'), [
            'category' => 'Bahan baku',
            'amount' => 45000,
            'expense_date' => now()->toDateString(),
            'description' => 'Pembelian biji kopi',
        ])
        ->assertRedirect(route('management.finance'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('expenses', [
        'user_id' => $admin->id,
        'category' => 'Bahan baku',
        'amount' => 45000,
        'description' => 'Pembelian biji kopi',
    ]);

    $this->actingAs($admin)
        ->get(route('management.finance'))
        ->assertOk()
        ->assertSee('Pembelian biji kopi')
        ->assertSee('Bahan baku')
        ->assertViewHas('financeSummary', fn ($summary) => $summary['expenses'] == 45000 && $summary['balance'] == -45000);
});

test('customers cannot record an expense', function () {
    $customer = User::factory()->create(['role' => 'pelanggan']);

    $this->actingAs($customer)
        ->post(route('management.expenses.store'), [
            'category' => 'Bahan baku',
            'amount' => 45000,
            'expense_date' => now()->toDateString(),
        ])
        ->assertForbidden();

    expect(Expense::count())->toBe(0);
});

test('admin can edit and delete an expense', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $expense = Expense::create([
        'user_id' => $admin->id,
        'category' => 'Bahan',
        'amount' => 100000,
        'expense_date' => now()->toDateString(),
        'description' => 'Pembelian awal',
    ]);

    $this->actingAs($admin)
        ->put(route('management.expenses.update', $expense), [
            'category' => 'Bahan baku',
            'amount' => 125000,
            'expense_date' => now()->toDateString(),
            'description' => 'Pembelian susu dan kopi',
        ])
        ->assertRedirect(route('management.finance'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('expenses', [
        'id' => $expense->id,
        'category' => 'Bahan baku',
        'amount' => 125000,
        'description' => 'Pembelian susu dan kopi',
    ]);

    $this->actingAs($admin)
        ->delete(route('management.expenses.destroy', $expense))
        ->assertRedirect(route('management.finance'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('expenses', ['id' => $expense->id]);
});

test('customers cannot edit or delete expenses', function () {
    $customer = User::factory()->create(['role' => 'pelanggan']);
    $expense = Expense::create([
        'user_id' => $customer->id,
        'category' => 'Bahan',
        'amount' => 100000,
        'expense_date' => now()->toDateString(),
    ]);

    $this->actingAs($customer)
        ->put(route('management.expenses.update', $expense), [
            'category' => 'Diubah',
            'amount' => 200000,
            'expense_date' => now()->toDateString(),
        ])
        ->assertForbidden();

    $this->actingAs($customer)
        ->delete(route('management.expenses.destroy', $expense))
        ->assertForbidden();

    $this->assertDatabaseHas('expenses', ['id' => $expense->id, 'category' => 'Bahan']);
});
