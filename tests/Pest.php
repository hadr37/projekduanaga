<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class)
    ->beforeEach(function () {
        // Jalankan migrasi + seeder tanpa hardcode env
        $this->artisan('migrate:fresh', ['--seed' => true]);
    })
    ->in('Feature', 'Unit');
