<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('new self-registered users are always set as pelanggan', function () {
    $response = $this->post('/register', [
        'name' => 'Pelanggan Baru',
        'email' => 'pelangganbaru@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('users', [
        'email' => 'pelangganbaru@example.com',
        'role' => 'pelanggan',
    ]);
});
