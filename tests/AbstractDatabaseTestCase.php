<?php

namespace Tests;

use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * AbstractDatabaseTestCase class
 */
abstract class AbstractDatabaseTestCase extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Seed DB before every test?
     *
     * @var bool
     */
    protected bool $seed = true;
}
