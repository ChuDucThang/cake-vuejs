<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Http\Response;
use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Core\Configure;


class AuthenticationController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('authentication');
    }

    public function login(){
        $title = "Login - Warehouse Management";
        if ($this->request->is('post')) {
            $inputData = $this->request->getData();
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
        $this->set(compact('title'));
        return $this->render('login');
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