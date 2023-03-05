<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;

class Ab_OrganizerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private static $user;
    private static $organizer;
    private static $organizerId;
    private static $eventId;

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

        $organizer = [
            'organizerName' => $faker->name(),
            'imageLocation' => UploadedFile::fake()->image('image.jpg')
        ];
        self::$organizer = $organizer;

    }

    public static function tearDownAfterClass(): void
    {
        self::$user = [];
    }

    public function test_preparation()
    {
        $response = $this->post('/register',self::$user);
        $response->assertStatus(302)
        ->assertRedirect('/');
    }

    protected function setUp(): void
    {
        parent::setUp();

        self::$organizerId = config('event.organizerId');
        self::$eventId = config('event.eventId');

    }

    public function sign()
    {
        return $this->post('login',[
            'email' => self::$user['email'],
            'password' => self::$user['password']
        ]);
    }

    public function test_user_can_access_organizer_page()
    {
        $response = $this->sign();

        $response = $this->get('/admin/v1/organizer');
        $response->assertStatus(200)
        ->assertSee('No',false)
        ->assertSee('Organizer Name',false)
        ->assertSee('Image',false)
        ->assertSee('Action',false);
    }

    public function test_user_can_access_organizer_create_form()
    {
        $response = $this->sign();

        $response = $this->get('/admin/v1/organizer/create');
        $response->assertStatus(200)
        ->assertSee('Organizer Name',false)
        ->assertSee('Image',false)
        ->assertSee('Save',false);
    }

    public function test_user_can_add_organizer()
    {
        $response = $this->sign();

        $response = $this->post('/admin/v1/organizer/store',self::$organizer);
        $response->assertStatus(302)
        ->assertRedirect('/admin/v1/organizer');
    }

    public function test_user_can_edit_single_organizer()
    {
        $response = $this->sign();

        dd(self::$organizerId);
        $response = $this->get('/admin/v1/organizer/'.config('event.organizerId').'/edit');
        $response->assertStatus(200);
        // ->assertSee('No',false)
        // ->assertSee('Organizer Name',false)
        // ->assertSee('Image',false)
        // ->assertSee('Action',false);
    }
}
