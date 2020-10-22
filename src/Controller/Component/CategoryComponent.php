<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;
use Cake\Controller\ComponentRegistry;

/**
 * Category component
 */
class CategoryComponent extends CommonComponent
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->loadModel('Categories');
    }

    public function getListCategory($data, $pageNumber): array
    {
        $field = [
            'Categories.id',
            'Categories.name',
            'Categories.del_flg'
        ];
        $query = $this->Categories->find()->select($field);
        if(!empty($data['name'])){
            $query->where([
				'lower(Categories.name) like lower(:name)',
			])->bind(':name', '%' . $data['name'] . '%', 'string');
        }

        if (!empty($data['del_flg'])) {
			$query->where([
				'Categories.del_flg' => 1,
			]);
		} else {
			$query->where([
				'Categories.del_flg' => 0,
			]);
        }

        $count = $query->count();
        $query->limit(10)->page($pageNumber);
        if($count > 0){
            return [
                'result' => 'SUCCESS',
                'count' => $count,
                'data' => $query->all(),
            ];
        }else {
            return ['result' => 'DATA_NOT_FOUND'];
        }

    }

    public function getCategory($data): array
	{
		if (empty($data['id'])) {
			return ['result' => 'DATA_NOT_FOUND'];
		}
        $cats = $this->Categories->findById($data['id'])->first();
		if ($cats) {
			return [
				'result' => 'SUCCESS',
				'data' => $cats,
			];
		} else {
			return [
                'result' => 'VALID',
                'data' => []
            ];
		}
    }

    public function saveCategory($data): array
    {
         if(!empty($data['id'])){
            $cats = $this->Categories->findById($data['id'])->first();
            if (empty($cats)) {
				return ['result' => 'DATA_NOT_FOUND'];
			}
            $cats = $this->Categories->patchEntity($cats, $data);
        }else{
            $cats = $this->Categories->newEntity($data);
        }
        $result = $this->Categories->save($cats);
		if ($cats->hasErrors()) {
			return [
				'result' => 'DATA_VALID',
				'data' => $cats->getErrors(),
			];
		}
		return [
			'result' => 'SUCCESS',
			'data' => $result,
		];
    }

    public function deleteCategory($data): array
	{   
        if(empty($data['id'])){
            return ['result' => 'DATA_NOT_FOUND'];
        }else {
            $cats = $this->Categories->findById($data['id'])->first();
            if(empty($cats)){
                return ['result' => 'DATA_NOT_FOUND'];
            }else {
                $cats->del_flg = 1;
			    $result = $this->Categories->save($cats);
                if ($cats->hasErrors()) {
                    return [
                        'result' => 'DATA_VALID',
				        'data' => $cats->getErrors(),
                    ];
                }
                return [
                    'result' => 'SUCCESS',
			        'data' => $result,
                ];
            }
        }
        
    }

}
