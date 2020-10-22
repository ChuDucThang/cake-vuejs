<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Commodities Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 *
 * @method \App\Model\Entity\Commodity newEmptyEntity()
 * @method \App\Model\Entity\Commodity newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Commodity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Commodity get($primaryKey, $options = [])
 * @method \App\Model\Entity\Commodity findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Commodity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Commodity[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Commodity|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Commodity saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Commodity[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Commodity[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Commodity[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Commodity[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CommoditiesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('commodities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('img_path')
            ->maxLength('img_path', 100)
            ->allowEmptyString('img_path');

        $validator
            ->scalar('date_export')
            ->maxLength('date_export', 50)
            ->requirePresence('date_export', 'create')
            ->notEmptyString('date_export');

        $validator
            ->numeric('amount')
            ->allowEmptyString('amount');

        $validator
            ->integer('quantity')
            ->allowEmptyString('quantity');

        $validator
            ->integer('quantity_use')
            ->allowEmptyString('quantity_use');

        $validator
            ->integer('quantity_inventory')
            ->allowEmptyString('quantity_inventory');

        $validator
            ->scalar('note')
            ->maxLength('note', 4294967295)
            ->allowEmptyString('note');

        $validator
            ->notEmptyString('del_flg');

        $validator
            ->scalar('created_at')
            ->maxLength('created_at', 50)
            ->requirePresence('created_at', 'create')
            ->notEmptyString('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['category_id'], 'Categories'), ['errorField' => 'category_id']);

        return $rules;
    }
}
