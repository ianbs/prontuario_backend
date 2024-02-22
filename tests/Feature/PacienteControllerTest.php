<?php

namespace Tests\Feature;

use App\Models\Pacientes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PacienteControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_pacientes()
    {
        Pacientes::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/pacientes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'nome', 'cpf', 'data_nascimento', 'telefone', 'email', 'created_at', 'updated_at'],
                ],
            ]);
    }

    /** @test */
    public function it_can_create_a_paciente()
    {
        $data = [
            'nome' => 'John Doe',
            'cpf' => '12345678901',
            'data_nascimento' => '1990-01-01',
            'telefone' => '123456789',
            'email' => 'john@example.com',
        ];

        $response = $this->postJson('/api/v1/pacientes', $data);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => $data,
            ]);
    }

    /** @test */
    public function it_can_show_a_paciente()
    {
        $paciente = Pacientes::factory()->create();

        $response = $this->getJson('/api/v1/pacientes/' . $paciente->id);

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'data' => $paciente->toArray()]);
    }

    /** @test */
    public function it_can_update_a_paciente()
    {
        $paciente = Pacientes::factory()->create();

        $data = [
            'nome' => 'Jane Doe',
            'cpf' => '98765432109',
            'data_nascimento' => '1995-06-15',
            'telefone' => '987654321',
            'email' => 'jane@example.com',
        ];

        $response = $this->putJson('/api/v1/pacientes/' . $paciente->id, $data);

        $this->assertDatabaseHas('pacientes', $data);
        $response->assertStatus(200)
            ->assertJson(['success' => true, 'data' => $data]);
    }

    /** @test */
    public function it_can_destroy_a_paciente()
    {
        $paciente = Pacientes::factory()->create();

        $response = $this->deleteJson('/api/v1/pacientes/' . $paciente->id);

        $this->assertSoftDeleted($paciente);
        $response->assertStatus(200)
            ->assertJson(['success' => true, 'message' => 'Paciente excluído com sucesso']);
    }
}
