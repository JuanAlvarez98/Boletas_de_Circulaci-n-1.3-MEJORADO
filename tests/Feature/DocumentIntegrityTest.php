<?php

namespace Tests\Feature;

use App\Models\BoletaCirculacion;
use App\Models\Role;
use App\Models\Sticker;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\DocumentSequenceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentIntegrityTest extends TestCase
{
    use RefreshDatabase;

    private function operator(): User
    {
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Operador', 'slug' => 'operator', 'description' => 'Pruebas']);
        $user->roles()->attach($role);

        return $user;
    }

    private function vehicle(string $plate): Vehicle
    {
        return Vehicle::create(['placa' => $plate, 'chasis' => 'CH-'.$plate, 'marca' => 'Toyota', 'modelo' => 'Hilux', 'propietario_nombre' => 'Persona de prueba']);
    }

    public function test_boleta_cannot_be_linked_to_another_vehicle(): void
    {
        $user = $this->operator();
        $first = $this->vehicle('AAA-001');
        $second = $this->vehicle('BBB-002');
        $boleta = BoletaCirculacion::create(['folio' => 'BC-2026-999999', 'vehicle_id' => $first->id, 'user_id' => $user->id,
            'fecha_emision' => today(), 'fecha_vigencia' => today()->addYear(), 'estado' => 'vigente']);

        $this->actingAs($user)->post(route('stickers.store'), ['vehicle_id' => $second->id, 'boleta_id' => $boleta->id])
            ->assertSessionHasErrors('boleta_id');
        $this->assertDatabaseCount('stickers', 0);
    }

    public function test_cancelling_sticker_preserves_record_and_reason(): void
    {
        $user = $this->operator();
        $vehicle = $this->vehicle('CCC-003');
        $sticker = Sticker::create(['codigo' => 'STK-2026-999999', 'verification_token' => fake()->uuid(), 'vehicle_id' => $vehicle->id,
            'user_id' => $user->id, 'fecha_emision' => today(), 'estado' => 'activo']);

        $this->actingAs($user)->delete(route('stickers.destroy', $sticker), ['motivo_anulacion' => 'Documento impreso con datos incorrectos'])
            ->assertRedirect(route('stickers.index'));
        $this->assertDatabaseHas('stickers', ['id' => $sticker->id, 'estado' => 'anulado', 'anulado_por' => $user->id]);
        $this->assertDatabaseHas('audit_logs', ['action' => 'sticker.anulado', 'auditable_id' => $sticker->id]);
    }

    public function test_document_sequences_do_not_repeat(): void
    {
        $service = app(DocumentSequenceService::class);
        $this->assertNotSame($service->next('boleta', 'BC'), $service->next('boleta', 'BC'));
    }
}
