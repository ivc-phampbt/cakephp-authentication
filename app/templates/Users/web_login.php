<?= $this->Flash->render() ?>
<?php $this->Form->setConfig('autoSetCustomValidity', false); ?>
<?= $this->Form->create($loginForm, ['novalidate' => true]) ?>
    <?= $this->Form->control('email'); ?>
    <?= $this->Form->control('password'); ?>
    <?= $this->Form->button('Login') ?>
<?= $this->Form->end() ?>
