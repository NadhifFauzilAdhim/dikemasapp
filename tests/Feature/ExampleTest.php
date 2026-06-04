<?php

test('redirects to login', function (): void {
    $response = $this->get('/');

    $response->assertStatus(302)
             ->assertRedirect('/login');
});