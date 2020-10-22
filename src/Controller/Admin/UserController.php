<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
/**
 * Admin/User Controller
 *
 * @method \App\Model\Entity\Admin/User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('dashboard');
        $this->loadModel('User');
    }

    public function index()
    {
        $title = "Warehouse Management - User";
        $this->set(compact('title'));
    }
}
