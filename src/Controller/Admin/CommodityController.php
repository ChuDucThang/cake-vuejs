<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

class CommodityController extends AppController
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
        $this->loadModel('Commodity');
    }

    public function index()
    {
        $title = "Warehouse Management - Commodity";
        $this->set(compact('title'));
    }
}
