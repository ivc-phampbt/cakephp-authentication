<?php
declare(strict_types=1);

namespace App\Controller;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Http\Exception\NotFoundException;
use Firebase\JWT\JWT;

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

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $result = $this->Authentication->getResult();
            if ($result->isValid()) {

                $privateKey = file_get_contents(CONFIG . 'jwt.key');
                $user = $result->getData();
                $payload = [
                    'iss' => 'myapp',
                    'sub' => $user->id,
                    'exp' => time() + 3600, // 1 hour
                ];

                $json = [
                    'token' => JWT::encode($payload, $privateKey, 'RS256'),
                ];
            } else {
                $this->response = $this->response->withStatus(401);
                $json = [
                    "message" => __('The Username or Password is Incorrect')
                ];
            }

            $this->RequestHandler->renderAs($this, 'json');
            $this->response->withType('application/json');

            $this->set(['json' => $json]);
            $this->viewBuilder()->setOption('serialize', 'json');
        } else {
            throw new NotFoundException();
        }
    }
}
