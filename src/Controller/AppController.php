<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\I18n\I18n;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Authentication.Authentication');
        $this->Authentication->allowUnauthenticated(['login', 'register', 'changeLang', 'changeLangDefault', 'default']);

        $this->loadComponent('Auth', ['authorize' => 'Controller']);
        $this->Auth->allow();
        // I18n::setLocale('en_US');
        if ($this->request->getSession()->check('Config.language')) {
            I18n::setLocale($this->request->getSession()->read('Config.language'));
        }else{
            $this->request->getSession()->write('Config.language', I18n::getLocale());
        }

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);
 
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $data = $this->Authentication->getResult()->getData();       
        $this->set(['users' => $data]);
    }

    public function changeLangDefault()
    {
        $this->request->getSession()->write('Config.language', 'vi_VN');
        return $this->redirect($this->referer());
    }

    public function changeLang()
    {
        $this->request->getSession()->write('Config.language', 'en_US');
        return $this->redirect($this->referer());
    }

    public function isAuthorized($user) {
        if (in_array($this->request->action,['index'])) {
            return (bool)($user['role_type'] === 1);
        }

        return parent::isAuthorized($user);
    }

}
