<?php

namespace App\Http\Controllers;

use App\Http\Resources\PacientesCollection;
use App\Http\Resources\PacientesResource;
use App\Models\Pacientes;
use Illuminate\Http\Request;
use Validator;

class PacientesController extends Controller
{
    public function index()
    {
        try {
            $pacientes = Pacientes::all();
            return response()->json(['success' => true, 'data' => $pacientes]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao listar pacientes: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|unique:pacientes|max:14',
                'data_nascimento' => 'required|date',
                'telefone' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            $paciente = Pacientes::create($request->all());

            return response()->json(['success' => true, 'data' => $paciente], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao criar paciente: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $paciente = Pacientes::findOrFail($id);
            return response()->json(['success' => true, 'data' => $paciente]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao buscar paciente: ' . $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $paciente = Pacientes::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:14|unique:pacientes,cpf,' . $id,
                'data_nascimento' => 'required|date',
                'telefone' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            $paciente->update($request->all());

            return response()->json(['success' => true, 'data' => $paciente]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao atualizar paciente: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $paciente = Pacientes::findOrFail($id);
            $paciente->delete();

            return response()->json(['success' => true, 'message' => 'Paciente excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao excluir paciente: ' . $e->getMessage()], 500);
        }
    }
}
