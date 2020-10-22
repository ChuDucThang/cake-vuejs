<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommoditiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommoditiesTable Test Case
 */
class CommoditiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CommoditiesTable
     */
    protected $Commodities;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Commodities',
        'app.Categories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Commodities') ? [] : ['className' => CommoditiesTable::class];
        $this->Commodities = $this->getTableLocator()->get('Commodities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Commodities);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
