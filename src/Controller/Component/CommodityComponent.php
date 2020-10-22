<?php
declare (strict_types = 1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;

class CommodityComponent extends CommonComponent
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->loadModel('Commodities');
        $this->loadModel('Categories');
    }

    public function getListCommodity($data, $pageNumber): array
    {
        $field = [
            'Categories.id',
            'Categories.name',
            'Commodities.id',
            'Commodities.name',
            'Commodities.category_id',
            'Commodities.img_path',
            'Commodities.date_export',
            'Commodities.amount',
            'Commodities.quantity',
            'Commodities.quantity_use',
            'Commodities.quantity_inventory',
            'Commodities.note',
            'Commodities.del_flg',
            'Commodities.created_at',
            'Commodities.updated_at'
        ];
        $query = $this->Commodities->find()->select($field)
                ->join([
                    'table' => 'categories',
                    'alias' => 'Categories',
                    'type' => 'left',
                    'conditions' => 'Commodities.category_id = Categories.id',
                ]);
        if(!empty($data['name'])){
            $query->where([
				'lower(Commodities.name) like lower(:name)',
			])->bind(':name', '%' . $data['name'] . '%', 'string');
        }
        if (!empty($data['date_export'])) {
            $query->where([
                'Commodities.date_export = :date_export',
            ])->bind(':date_export', $data['date_export']);
        }
        if (!empty($data['created_at'])) {
            $query->where([
                'Commodities.created_at = :created_at',
            ])->bind(':created_at', $data['created_at']);
        }

        if (!empty($data['del_flg'])) {
			$query->where([
				'Commodities.del_flg' => 1,
			]);
		} else {
			$query->where([
				'Commodities.del_flg' => 0,
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

    public function getCommodity($data): array
	{
		if (empty($data['id'])) {
			return ['result' => 'DATA_NOT_FOUND'];
		}
        $comd = $this->Commodities->findById($data['id'])->first();
		if ($comd) {
			return [
				'result' => 'SUCCESS',
				'data' => $comd,
			];
		} else {
			return [
                'result' => 'VALID',
                'data' => []
            ];
		}
    }

    public function saveCommodity($data): array
	{
        if(!empty($data['id'])){
            $comd = $this->Commodities->findById($data['id'])->first();
            if (empty($comd)) {
				return ['result' => 'DATA_NOT_FOUND'];
			}
            $comd = $this->Commodities->patchEntity($comd, $data);
        }else{
            $comd = $this->Commodities->newEntity($data);
        }
        
        $base64Data = $data['img_path'];
        if(empty($base64Data)){
            $comd->img_path = "";
        }else{
            $comd->img_path = $this->saveImage($base64Data);
        }
       
        $result = $this->Commodities->save($comd);
		if ($comd->hasErrors()) {
			return [
				'result' => 'DATA_VALID',
				'data' => $comd->getErrors(),
			];
		}
		return [
			'result' => 'SUCCESS',
			'data' => $result,
		];
    }

    public function deleteCommodity($data): array
	{   
        if(empty($data['id'])){
            return ['result' => 'DATA_NOT_FOUND'];
        }else {
            $comd = $this->Commodities->findById($data['id'])->first();
            if(empty($comd)){
                return ['result' => 'DATA_NOT_FOUND'];
            }else {
                $comd->del_flg = 1;
			    $result = $this->Commodities->save($comd);
                if ($comd->hasErrors()) {
                    return [
                        'result' => 'DATA_VALID',
				        'data' => $comd->getErrors(),
                    ];
                }
                return [
                    'result' => 'SUCCESS',
			        'data' => $result,
                ];
            }
        }
        
    }

    public function saveImage($base64Data){
        if(preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)){
            $data = substr($base64Data, strpos($base64Data, ',') + 1);
            $type = strtolower($type[1]);

            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new \Exception('Invalid image type');
            }
    
            $data = base64_decode($data);
    
            if ($data === false) {
                return $base64Data;
            }
        }else{
            return $base64Data;
        }

        $fullname = uniqid() . ".$type";

        $dir_to_save = $_SERVER['DOCUMENT_ROOT'] . "/webroot/img/commodity";
            if (!is_dir($dir_to_save)) {
            mkdir($dir_to_save);
        }

        if(file_put_contents($dir_to_save . "/" . $fullname, $data)){
            $result = $fullname;
        }else{
            $result =  "";
        }

        return $result;
    }
}