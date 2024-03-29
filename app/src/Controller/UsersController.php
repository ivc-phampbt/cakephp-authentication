<?php
declare(strict_types=1);

namespace App\Controller;
use App\Form\LoginForm;
use Cake\Http\Exception\NotFoundException;
use Firebase\JWT\JWT;
use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['webLogin']);
    }

    public function webLogin()
    {
        $this->request->allowMethod(['get', 'post']);
        $loginForm = new LoginForm();
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $this->redirect("/home");
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (!$loginForm->validate($data)) {
                $this->Flash->error(__('Invalid username or password'));
            }

            if ($result && $result->isValid()) {
                $this->redirect("/home");
            } else {
                $this->Flash->error(__('Invalid username or password'));
            }
        }

        $this->set(compact('loginForm'));
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(["action" => 'webLogin']);
    }
}
