<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Factory;
use App\Models\Doctor;
use App\Models\User;
use App\Http\Controllers\DoctorController;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testDestroy(): void
{

    // Create a user with the delete-doctor permission
   // $docteur = Doctor::factory()->create();
    //$user->givePermissionTo('delete-doctor');
    //$this->assertModelExists($user);

$user =User::find(1);
    // Create a doctor to be deleted
    $doctor = Doctor::factory()->create();

     // Send a DELETE request to the route with the doctor's ID
    $response = $this->actingAs($user)->delete('/doctors/'.$doctor->id);

    // Check that the response has a redirect status code
    $response->assertStatus(302);

    // Check that the doctor has been deleted from the database
    $this->assertDatabaseMissing('doctors', ['id' => $doctor->id]);

    // Check that the response redirected to the doctors index route
    $response->assertRedirect(route('doctors.index'));

    // Check that the success message is present in the session
    $this->assertEquals('Médecin supprimé avec succès', session('message'));
    $this->assertEquals('success', session('type'));


}

}
