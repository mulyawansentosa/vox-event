<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;

class Aa_UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private static $user;

    public static function setUpBeforeClass(): void
    {
        $faker = Faker::create();
        $password = $faker->regexify('[0-9]{1}[!]{1}[A-Z]{1}[a-z]{4}[A-Z]{1}');
        $user = [
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'email' => $faker->email(),
            'password' => $password,
            'repeatPassword' => $password
        ];
        self::$user = $user;
    }

    public static function tearDownAfterClass(): void
    {
        self::$user = [];
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
        $response = $this->post('/register',self::$user);
        $response->assertStatus(302)
        ->assertRedirect('/');
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
        $response = $this->post('/login',[
            'email' => self::$user['email'],
            'password' => self::$user['password']
        ]);
        $response->assertStatus(302)
        ->assertRedirect('/admin/v1/organizer')
        ->assertSessionHas('success');
    }

    public function sign()
    {
        return $this->post('login',[
            'email' => self::$user['email'],
            'password' => self::$user['password']
        ]);
    }

    public function test_user_can_see_profile()
    {
        $response = $this->sign();

        $response = $this->get('/admin/v1/user');
        $response->assertStatus(200)
        ->assertSee('value="'.self::$user['firstName'].'"',false)
        ->assertSee('value="'.self::$user['lastName'].'"',false)
        ->assertSee('value="'.self::$user['email'].'"',false);
    }

    public function test_user_can_update_profile()
    {
        $faker = Faker::create();

        $user = [
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'email' => $faker->email()
        ];

        $response = $this->sign();
        $response = $this->followingRedirects()
        ->put('/admin/v1/user/update',$user);

        self::$user['firstName'] = $user['firstName'];
        self::$user['lastName'] = $user['firstName'];
        self::$user['email'] = $user['email'];

        $response->assertStatus(200)
        ->assertSee('value="'.$user['firstName'].'"',false)
        ->assertSee('value="'.$user['lastName'].'"',false)
        ->assertSee('value="'.$user['email'].'"',false);
    }

    public function test_user_can_change_password()
    {
        $faker = Faker::create();
        $password = $faker->regexify('[0-9]{1}[!]{1}[A-Z]{1}[a-z]{4}[A-Z]{1}');
        $changePassword = [
            'oldPassword' => self::$user['password'],
            'newPassword' => $password,
            'repeatPassword' => $password
        ];

        $response = $this->sign();
        $response = $this->put('/admin/v1/user/change_password',$changePassword);

        $response->assertStatus(302)
        ->assertRedirect('/admin/v1/user');
    }

    public function test_user_can_delete_profile()
    {
        $response = $this->sign();
        $response = $this->get('/admin/v1/user/delete');

        $response->assertStatus(302)
        ->assertRedirect('/');
    }
}
