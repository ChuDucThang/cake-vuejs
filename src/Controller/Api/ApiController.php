<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Http\Response;
use Cake\I18n\I18n;

/**
 * Api/Api Controller
 *
 * @method \App\Model\Entity\Api/Api[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApiController extends AppController
{
    public $pageNumber = 1;
    public $inputData = [];
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    public function initialize(): void
    {
        parent::initialize();
        $this->__getPageNumber();
    }

    protected function returnResponse($status_code = "200", $data, $message = "Success", $count = 0, $page = 0):Response
    {
        return $this->response->withType("application/json")->withStringBody(json_encode(array(
            'status_code' => $status_code,
            'data' => $data,
            'message' => $message,
            'count' => $count,
            'page' => $page === 0 ? $this->pageNumber : $page,
            "totalPage" => ceil($count / 10),
            "datetime" => time()
        )));
    }

    private function __getPageNumber()
    {
        $page = $this->getRequest()->getQuery('page');
        try {
            if (isset($page)) {
                $this->pageNumber = intval($page);
            }
        } catch (Exception $e) {
            Log::write('error', $e->getMessage());
        }
    }
}
