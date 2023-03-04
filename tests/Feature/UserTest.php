<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public $user;

    protected function setUp(): void
    {
        parent::setUp();

        $faker = Faker::create();
        $password = $faker->regexify('[0-9]{1}[!]{1}[A-Z]{1}[a-z]{4}[A-Z]{1}');
        $user = [
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'email' => $faker->email(),
            'password' => $password,
            'repeatPassword' => $password
        ];
        // $user = [
        //     'firstName' => 'Jana',
        //     'lastName' => 'Schuster',
        //     'email' => 'alivia.turner@hotmail.com',
        //     'password' => '7!KoafdO',
        //     'repeatPassword' => '7!KoafdO'
        // ];

        $this->user = $user;
    }

    public function test_user_can_access_registration_form()
    {
        $response = $this->get('/register');
        $response->assertStatus(200)
        ->assertSee('First Name',false)
        ->assertSee('Last Name',false)
        ->assertSee('Email Address',false)
        ->assertSee('Password',false)
        ->assertSee('Repeat Password',false)
        ->assertSee('Sign in',false)
        ->assertSee('Register',false);
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register',$this->user);
        $response->assertStatus(302)
        ->assertRedirect('/');
        sleep(5);
    }

    public function test_user_see_error_validation_on_registration_form()
    {
        $user = [
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'password' => '',
            'repeatPassword' => ''
        ];
        $response = $this->post('/register',$user);
        $response->assertStatus(302)
        ->assertRedirect('/')
        ->assertSessionHasErrors();
    }

    public function test_user_can_access_login_form()
    {
        $response = $this->get('/');
        $response->assertStatus(200)
        ->assertSee('Email')
        ->assertSee('Password')
        ->assertSee('Sign in')
        ->assertSee('Register');
    }

    public function test_user_can_login()
    {
        var_dump($this->user);
        $response = $this->post('/login',[
            'email' => $this->user['email'],
            'password' => $this->user['password']
        ]);
        $response->assertStatus(302)
        ->assertRedirect('/admin/v1/dashboard')
        ->assertSessionHas('success');
    }
}
