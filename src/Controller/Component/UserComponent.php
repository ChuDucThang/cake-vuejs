<?php
declare (strict_types = 1);

namespace App\Controller\Component;

use App\Controller\Component\CommonComponent;

class UserComponent extends CommonComponent
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->loadModel('Users');
    }

    public function getListUsers($data, $pageNumber): array
    {
        $field = [
            'Users.id',
            'Users.first_name',
            'Users.last_name', 
            'Users.account_code', 
            'Users.password',
            'Users.birth_date', 
            'Users.email',
            'Users.phone',
            'Users.address',
            'Users.avatar_path',
            'Users.role_type',
            'Users.del_flg'
        ];

        $query = $this->Users->find()->select($field);
        if (!empty($data['first_name'])) {
			$query->where([
				'lower(Users.first_name) like lower(:first_name)',
			])->bind(':first_name', '%' . $data['first_name'] . '%', 'string');
        }
        if (!empty($data['last_name'])) {
			$query->where([
				'lower(Users.last_name) like lower(:last_name)',
			])->bind(':last_name', '%' . $data['last_name'] . '%', 'string');
        }
        if (!empty($data['phone'])) {
            $query->where([
                'Users.phone' => $data['phone'],
            ]);
        }
        if (!empty($data['address'])) {
			$query->where([
				'lower(Users.address) like lower(:address)',
			])->bind(':address', '%' . $data['address'] . '%', 'string');
		}
        if (!empty($data['birth_date'])) {
            $query->where([
                'Users.birth_date = :birth_date',
            ])->bind(':birth_date', $data['birth_date']);
        }
        if (!empty($data['del_flg'])) {
			$query->where([
				'Users.del_flg' => 1,
			]);
		} else {
			$query->where([
				'Users.del_flg' => 0,
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

    public function getUsers($data): array
	{
		if (empty($data['id'])) {
			return ['result' => 'DATA_NOT_FOUND'];
		}
        $users = $this->Users->findById($data['id'])->first();
		if ($users) {
			return [
				'result' => 'SUCCESS',
				'data' => $users,
			];
		} else {
			return [
                'result' => 'VALID',
                'data' => []
            ];
		}
    }
    
    public function saveUsers($data): array
	{
        if(!empty($data['id'])){
            $users = $this->Users->findById($data['id'])->first();
            if (empty($users)) {
				return ['result' => 'DATA_NOT_FOUND'];
			}
            $users = $this->Users->patchEntity($users, $data);
        }else{
            $users = $this->Users->newEntity($data);
            $users->password = '123456';
        }
        
        $base64Data = $data['avatar_path'];
        if(empty($base64Data)){
            $users->avatar_path = "";
        }else{
            $users->avatar_path = $this->saveImage($base64Data);
        }
       
        $result = $this->Users->save($users);
		if ($users->hasErrors()) {
			return [
				'result' => 'DATA_VALID',
				'data' => $users->getErrors(),
			];
		}
		return [
			'result' => 'SUCCESS',
			'data' => $result,
		];
    }

    public function deleteUsers($data): array
	{   
        if(empty($data['id'])){
            return ['result' => 'DATA_NOT_FOUND'];
        }else {
            $users = $this->Users->findById($data['id'])->first();
            if(empty($users)){
                return ['result' => 'DATA_NOT_FOUND'];
            }else {
                $users->del_flg = 1;
			    $result = $this->Users->save($users);
                if ($users->hasErrors()) {
                    return [
                        'result' => 'DATA_VALID',
				        'data' => $users->getErrors(),
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

        $dir_to_save = $_SERVER['DOCUMENT_ROOT'] . "/webroot/img/user";
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