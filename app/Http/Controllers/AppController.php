<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gasto;
use App\Models\TipoPago;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;

class AppController extends Controller
{
    public $gastos;
    public $tiposPago;
    public $gasto;
    public $total;

    public function index()
    {
        $this->getData();
        return $this->renderIndex();
    }

    public function eliminar($id_gasto)
    {
        //ToDo: Completar el código para eliminar un registro
        return '{"mensaje":"El registro ha sido eliminado"}';
    }

    public function guardar(Request $req)
    {
        //ToDo: Completar el código para validar
        $validated = $req->validate([
            'fecha' => 'required|date',
            'monto' => 'required|numeric|gt:0',
            'id_tipo_pago' => 'nullable',
            'descripcion' => 'nullable',
        ], [
            'fecha.required' => 'El campo fecha es obligatorio',
            'monto.required' => 'El campo monto es obligatorio',
            'monto.numeric' => 'El campo monto debe ser numérico',
            'monto.gt' => 'El campo monto debe ser mayor a 0',
        ]);

        $datosValidados = [
            'fecha' => $validated['fecha'],
            'monto' => $validated['monto'],
            'id_tipo_pago' => $validated['id_tipo_pago'],
            'descripcion' => $validated['descripcion']
        ];

        //ToDo: Completar el código para guardar registros
        if ($req->has('id_gasto')) {
            // Actualiza el registro existente
            // ...
        } else {
            // Inserta un nuevo registro
            // ...
        }

        return redirect()->route('index');
    }

    public function editar($id_gasto)
    {
        $this->getData();
        $this->gasto = Gasto::where('id_gasto', $id_gasto)->first();
        return $this->renderIndex(['gasto' => $this->gasto]);
    }

    private function getData()
    {
        $this->gastos = Gasto::paginate(5);
        $this->tiposPago = [];
        // ToDo: Completa el código para recuperar los datos del catálogo de tipo de pago
        $this->total = $this->calcularTotal($this->gastos);
    }

    private function renderIndex($adicionales = [])
    {
        $params = array_merge($adicionales, [
            'gastos' => $this->gastos,
            'tiposPago' => $this->tiposPago,
            'total' => $this->total,
        ]);

        return view('index', $params);
    }

    private function calcularTotal($listaGastos)
    {
        $total = 0;
        //ToDo: Completar el código para calcular el total
        return $total;
    }
}
