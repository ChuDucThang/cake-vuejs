<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\Api\ApiController;
use Cake\Http\Response;

/**
 * Api/Category Controller
 *
 * @method \App\Model\Entity\Api/Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoryController extends ApiController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function initialize(): void {
		parent::initialize();
		$this->loadComponent('Category');
	}

    public function getList(): Response
    {
        $this->request->allowMethod(['GET']);
		$inputData = $this->request->getQuery();
		try {
                $data = $this->Category->getListCategory($inputData, $this->pageNumber);
                if($data['result'] == 'SUCCESS'){
                    return $this->returnResponse('200' , $data['data'], $data['count'] . ' Record', $data['count']);
                }else {
                    return $this->returnResponse('200' , [], '0 Record', 0);
                }
			} catch (Exception $e) {
			    return $this->returnResponse('404',$data[], $e->getMessage());
		}
    }

    public function get():Response{
		$this->request->allowMethod(['GET']);
		$inputData = $this->request->getQuery();
		try{
			$data = $this->Category->getCategory($inputData);
			if ($data['result'] == 'SUCCESS') {
				return $this->returnResponse('200' , $data['data'], 'Data loaded', 1);
			} else if ($data['result'] == 'DATA_NOT_FOUND') {
				return $this->returnResponse('403', [], 'Data not found', 0);
			} else {
				return $this->returnResponse('404', [] , 'Data not valid', 0);
			}
		} catch (Exception $e) {
			return $this->returnResponse('404',$data[], $e->getMessage());
		}
	}

	public function save():Response{
		$this->request->allowMethod(['POST']);
		$inputData = $this->request->input('json_decode', true);
		try {
			$data = $this->Category->saveCategory($inputData);
			if ($data['result'] == 'SUCCESS') {
				return $this->returnResponse('200' , $data['data'], 'Category saved', 1);
			} elseif($data['result'] == 'DATA_NOT_FOUND'){
				return $this->returnResponse('403' , $data['data'], 'Data not found', 1);
			} else{
				return $this->returnResponse('404' , $data['data'], 'Data not valid', 1);
			}
		} catch(Exception $e) {
			return $this->returnResponse('404',$data[], $e->getMessage());
		}
	}

    public function delete(): Response {
		$this->request->allowMethod(['POST']);
		$inputData = $this->request->input('json_decode', true);
		try {
			$data = $this->Category->deleteCategory($inputData);
			if ($data['result'] == 'DATA_NOT_FOUND') {
				return $this->returnResponse('404', [], "Data not found", 0);
			} elseif ($data['result'] == 'SUCCESS') {
				return $this->returnResponse('200',[], "Category deleted", 0);
			} else {
				return $this->returnResponse('400',[], "Category valid", 0);
			}
		} catch (Exception $e) {
			return $this->createResponse([], FAILED, $e->getMessage());
		}
	}
}