// tests/Feature/CoordinatorTest.php
public function test_assign_professor_to_module()
{
    $coordinator = User::factory()->create(['role' => 'coordinator']);
    $filiere = Filiere::factory()->create(['coordonnateur_id' => $coordinator->id]);
    $module = Module::factory()->create(['filiere_id' => $filiere->id]);

    $response = $this->actingAs($coordinator)
                    ->post(route('coordinator.assign.store', $module), [
                        'professor_id' => User::factory()->create(['role' => 'professor'])->id
                    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('affectations', ['module_id' => $module->id]);
}