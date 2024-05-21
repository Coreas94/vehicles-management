<?php

namespace Tests\Feature;

use App\Http\Controllers\VehicleController;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Validation\Factory as ValidationFactory;

class createVehicleTest extends TestCase
{
    public function testStore()
    {
        $user = User::factory()->create();

        $this->app->instance(ValidationFactory::class, $this->createMock(ValidationFactory::class));

        $request = new Request([
            'brand' => 'Subaru',
            'model' => 'BRZ',
            'license_plate' => 'BRZ123',
            'year' => 2018,
            'price' => 12000,
            'user_id' => $user->id,
        ]);

        $controller = new VehicleController();

        $response = $controller->store($request);

        $this->assertIsObject($response);
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));

        $vehicle = Vehicle::where('license_plate', 'BRZ123')->first();
        $this->assertNotNull($vehicle);
        $this->assertEquals('Subaru', $vehicle->brand);
        $this->assertEquals('BRZ', $vehicle->model);
    }
}
