<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

it('logs out the authenticated user', function (): void {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect(route('login'));
    expect(Auth::check())->toBeFalse();
});

it('requires authentication to logout', function (): void {
    $response = $this->post(route('logout'));

    $response->assertRedirect(route('login'));
});
