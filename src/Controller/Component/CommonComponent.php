<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class CommonComponent extends Component {
    private $controller;
    //Get model in component
    public function initialize(array $config):void {
        $this->controller = $this->_registry->getController();
    }

    public function loadModel($model) {
        $this->$model = TableRegistry::get($model);
    }
}