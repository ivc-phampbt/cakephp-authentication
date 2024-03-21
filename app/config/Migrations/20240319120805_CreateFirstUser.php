<?php
declare(strict_types=1);

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Migrations\AbstractMigration;

class CreateFirstUser extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up(): void
    {
        $table = $this->table('users');
        $user = [
            'id' => 1,
            'email' => 'pham.bqt@gmail.com',
            'password' =>  (new DefaultPasswordHasher)->hash('P@ss1234tai'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $table->insert($user)->saveData();
    }

    public function down(): void
    {
        $this->execute('DELETE FROM users where id=1');
    }
}
