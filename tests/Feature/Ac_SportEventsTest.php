<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;

class Ac_SportEventsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private static $user;
    private static $organizer;
    private static $event;
    private static $organizerId;
    private static $eventId;

    public static function setUpBeforeClass(): void
    {
        $faker = Faker::create();
        $password = $faker->regexify('[0-9]{1}[!]{1}[A-Z]{1}[a-z]{4}[A-Z]{1}');
        $user = [
            'firstName' => str_replace("'","",$faker->firstName()),
            'lastName' => str_replace("'","",$faker->lastName()),
            'email' => $faker->email(),
            'password' => $password,
            'repeatPassword' => $password
        ];
        self::$user = $user;

        $organizer = [
            'organizerName' => str_replace("'","",$faker->name()),
            'imageLocation' => UploadedFile::fake()->image('image.jpg')
        ];
        self::$organizer = $organizer;

        $event = [
            'eventDate' => $faker->date(),
            'eventType' => str_replace("'","",$faker->word()),
            'eventName' => str_replace("'","",$faker->word()),
            'organizerId' => (int)getenv('ORGANIZER_ID')
        ];
        self::$event = $event;

    }

    public function test_preparation_user()
    {
        $response = $this->post('/register',self::$user);
        $response->assertStatus(302)
        ->assertRedirect('/');

    }

    public function test_preparation_organizer()
    {
        $response = $this->sign();

        $response = $this->post('/admin/v1/organizer/store',self::$organizer);
        $response->assertStatus(302)
        ->assertRedirect('/admin/v1/organizer');
    }

    public static function tearDownAfterClass(): void
    {
        self::$user = [];
    }

    protected function setUp(): void
    {
        parent::setUp();

        self::$organizerId = (int)getenv('ORGANIZER_ID');
        self::$eventId = getenv('EVENT_ID');

    }

    public function sign()
    {
        return $this->post('login',[
            'email' => self::$user['email'],
            'password' => self::$user['password']
        ]);
    }

    public function test_user_can_access_sport_events_page()
    {
        $response = $this->sign();

        $response = $this->get('/admin/v1/sport-events');
        $response->assertStatus(200)
        ->assertSee('No',false)
        ->assertSee('Event Date',false)
        ->assertSee('Event Name',false)
        ->assertSee('Event Type',false)
        ->assertSee('Organizer Name',false)
        ->assertSee('Action',false);
    }

    public function test_user_can_access_sport_event_create_form()
    {
        $response = $this->sign();

        $response = $this->get('/admin/v1/sport-events/create');
        $response->assertStatus(200)
        ->assertSee('Event Date',false)
        ->assertSee('Event Name',false)
        ->assertSee('Event Type',false)
        ->assertSee('Organizer',false)
        ->assertSee('Save',false);
    }

    public function test_user_can_add_event()
    {
        self::$event['organizerId'] = self::$organizerId;
        $response = $this->sign();
        $response = $this->post('/admin/v1/sport-events/store',self::$event);
        $response->assertStatus(302)
        ->assertRedirect('/admin/v1/sport-events');
    }

    public function test_user_can_edit_single_organizer()
    {
        $response = $this->sign();

        $response = $this->get('/admin/v1/sport-events/'.self::$eventId.'/edit');
        $response->assertStatus(200)
        ->assertSee('value="'.self::$event['eventType'].'"',false)
        ->assertSee('value="'.self::$event['eventName'].'"',false);
    }

    public function test_user_can_update_event()
    {
        $faker = Faker::create();

        $event = [
            'eventDate' => $faker->date(),
            'eventType' => str_replace("'","",$faker->word()),
            'eventName' => str_replace("'","",$faker->word()),
            'organizerId' => (int)getenv('ORGANIZER_ID')
        ];

        $response = $this->sign();
        $response = $this->followingRedirects()
        ->put('/admin/v1/sport-events/'.self::$eventId.'/update',$event);

        self::$event['eventDate'] = $event['eventDate'];
        self::$event['eventType'] = $event['eventType'];
        self::$event['eventName'] = $event['eventName'];
        self::$event['organizerId'] = $event['organizerId'];

        $response->assertStatus(200)
        ->assertSee('value="'.self::$event['eventType'].'"',false)
        ->assertSee('value="'.self::$event['eventName'].'"',false);
    }

    public function test_user_can_delete_event()
    {
        $response = $this->sign();
        $response = $this->get('/admin/v1/sport-events/'.self::$eventId.'/delete');

        $response->assertStatus(302)
        ->assertRedirect('/admin/v1/sport-events');
    }
}
