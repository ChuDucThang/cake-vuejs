<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\Component/Category;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\Component/Category Test Case
 */
class Component/CategoryTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\Component/Category
     */
    protected $Component/Category;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Component/Category = new Component/Category($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Component/Category);

        parent::tearDown();
    }
}
