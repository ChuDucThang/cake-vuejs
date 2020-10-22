<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\Http\Response;
use App\Controller\AppController;


class LoginController extends ApiController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('authentication');
    }

    public function login():Response{
       if ($this->request->is('post')) {
            $this->inputData = $this->request->input('json_decode', true);
            if(empty($inputData['account_code'])){
                $this->Flash->error('Please input account code');
            }
            elseif (empty($inputData['password'])) {
                $this->Flash->error('Please input password');
            }           
            $result = $this->Authentication->getResult();
            // If the user is logged in send them away.
            if ($result->isValid()) {
                $target = $this->Authentication->getLoginRedirect() ?? '/admin';
                return $this->redirect($target);
            }
        } else{
            $inputData = [
                'account_code' => 'ADMIN',
                'password' => '123456'
            ];
            $this->set(compact('inputData'));
        }
        $login = $this->Authentication->getLoginRedirect() ?? '/admin/login';
        return $this->redirect($login);
    }

    public function register(){

    }

    public function logout()
    {
        $this->Authentication->logout();
        $target = $this->Authentication->getLoginRedirect() ?? '/admin/login';
        return $this->redirect($target);
    }

}