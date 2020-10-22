<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\CategoryComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\CategoryComponent Test Case
 */
class CategoryComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\CategoryComponent
     */
    protected $Category;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Category = new CategoryComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Category);

        parent::tearDown();
    }
}
