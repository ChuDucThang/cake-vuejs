<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class CategoryController extends AppController
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
        $this->loadModel('Category');
    }

    public function index()
    {
        $title = "Warehouse Management - Category";
        $this->set(compact('title'));
    }
}
