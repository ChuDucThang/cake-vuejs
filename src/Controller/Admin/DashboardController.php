<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Http\Response;
use App\Controller\AppController;
use Cake\Routing\Router;

class DashboardController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('dashboard');
    }

    public function home(){
        $title = "Dashboard - Warehouse Management";
        $this->set(compact('title'));
    }
}