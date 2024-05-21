<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as ValidationFactory;
use Mockery\MockInterface;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test store method of UserController.
     */
    public function testStore()
    {
        $this->app->instance(ValidationFactory::class, $this->createMock(ValidationFactory::class));

        // Se crea un request falso
        $request = new Request([
            'name' => 'Josue',
            'surname' => 'Coreas',
            'email' => 'jos94@gmail.com',
        ]);

        $controller = new UserController();

        $response = $controller->store($request);

        $this->assertIsObject($response);
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));

        $user = User::where('email', 'jos94@gmail.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Josue', $user->name);
        $this->assertEquals('Coreas', $user->surname);
    }
}
