<?php

namespace Tests\Feature;

use App\Models\Tarea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TareaTest extends TestCase
{
    public function test_CrearTareaConInformacion()
    {
        $datosAInsertar = [
            "titulo" => "Hacer tal cosa",
            "contenido" => "Es hacerlo",
            "estado" => "incompleto",
            "autor" => "Anonimo"
        ];

        $response = $this->post('/api/v1/tarea', $datosAInsertar);

        $response->assertStatus(200);
        $response->assertJsonFragment(
            [ "mensaje" => "Tarea creada correctamente." ]
        );
    }

    public function test_CrearTareaSinInformacion()
    {
        $response = $this->post('/api/v1/tarea');

        $response->assertStatus(401);
    }

    public function test_ListarTareas()
    {
        $response = $this->get('/api/v1/tarea');

        $response->assertStatus(200);
    }

    public function test_ListarUnaTareaQueSiExiste()
    {
        $response = $this->get('/api/v1/tarea/1');

        $response->assertStatus(200);

    }

    public function test_ListarUnaTareaQueNoExiste()
    {
        $response = $this->get('/api/v1/tarea/9999999');

        $response->assertStatus(404);
    }

    public function test_ModificarUnaTareaQueSiExiste()
    {
        $tarea = new Tarea();

        $tarea->titulo = "titulo";
        $tarea->contenido = "contenido";
        $tarea->estado = "estado";
        $tarea->autor = "autor";

        $tarea->save();

        $datosAInsertar = [
            "titulo" => "tituloNuevo",
            "contenido" => "contenidoNuevo",
            "estado" => "estadoNuevo",
            "autor" => "autorNuevo"
        ];

        $response = $this->put('/api/v1/tarea/1', $datosAInsertar);

        $response->assertStatus(200);
    }

    public function test_ModificarUnaTareaQueNoExiste()
    {
        $response = $this->put('/api/v1/tarea/9999999');

        $response->assertStatus(404);
    }

    public function test_EliminarUnaTareaQueSiExiste()
    {
        $response = $this->delete('/api/v1/tarea/1');

        $response->assertStatus(200);
    }

    public function test_EliminarUnaTareaQueNoExiste()
    {
        $response = $this->delete('/api/v1/tarea/9999999');

        $response->assertStatus(404);
    }
}
