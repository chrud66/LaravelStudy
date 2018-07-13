<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
//use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    //use DatabaseMigrations;

    protected $baseUrl;
    protected $user;
    protected $article;
    protected $userPayload = [
        'name' => 'foo',
        'email' => 'foo@bar.com',
        'password' => 'password',
    ];

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $user = [
            'email' => 'chrud66@example.com',
        ];

        $this->browse(function (Browser $browser) use ($user) {
            //$browser->driver->executeScript('window.scrollTo(0, 500);');
            $browser->visit('http://kcklaravel.com:8080/login')
                ->type('email', $user['email'])
                ->type('password', 'password')->driver->executeScript('window.scrollTo(0, 500);');

            $browser->press(__('auth.title_login'))
                ->assertPathIs('/home');
        });
    }
}
