<?php

namespace App\Form;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class LoginForm extends Form
{
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema->addFields([
            'email' => [
                'type' => 'string',
                'length' => 255
            ],
            'password' => [
                'type' => 'string',
                'length' => 255
            ]
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        return $validator
            ->notEmptyString('email')
            ->email('email')
            ->maxLength('email', 50)
            ->notEmptyString('password')
            ->maxLength('password', 50);
    }
}
