<?php

use App\Livewire\ViolationList;
use App\Models\PpeViolation;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('unauthenticated users are redirected to login', function () {
    $this->get(route('violations.index'))
        ->assertRedirect(route('login'));
});

test('authenticated users can access the violations list', function () {
    $this->actingAs($this->user)
        ->get(route('violations.index'))
        ->assertOk();
});

test('violations are paginated to 10 per page', function () {
    PpeViolation::factory()->count(12)->create([
        'detected_at' => now(),
    ]);

    $this->actingAs($this->user);

    $component = Livewire::test(ViolationList::class);

    expect($component->instance()->violations->count())->toBe(10)
        ->and($component->instance()->violations->total())->toBe(12);

    $component->call('gotoPage', 2);

    expect($component->instance()->violations->count())->toBe(2)
        ->and($component->instance()->violations->total())->toBe(12);
});

test('user can confirm and cancel clearing all violations', function () {
    $this->actingAs($this->user);

    Livewire::test(ViolationList::class)
        ->assertSet('confirmingClearAll', false)
        ->call('confirmClearAll')
        ->assertSet('confirmingClearAll', true)
        ->call('cancelClearAll')
        ->assertSet('confirmingClearAll', false);
});

test('user can clear all violations and images', function () {
    Storage::fake('public');

    $violation = PpeViolation::factory()->create([
        'image_path' => 'ppe-violations/test-clear.jpg',
    ]);

    Storage::disk('public')->put($violation->image_path, 'fake content');
    Storage::disk('public')->assertExists($violation->image_path);

    $this->actingAs($this->user);

    Livewire::test(ViolationList::class)
        ->call('confirmClearAll')
        ->call('clearAll')
        ->assertSet('confirmingClearAll', false);

    expect(PpeViolation::count())->toBe(0);
    Storage::disk('public')->assertMissing($violation->image_path);
});
