<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    public function index()
    {
        $tarefas = Tarefa::orderBy('id', 'asc')->paginate(4);        
        return view('tarefas', compact('tarefas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'data_prevista' => 'nullable|date',
        ]);

        $tarefa = new Tarefa();
        $tarefa->descricao = $request->input('descricao');
        $tarefa->data_prevista = $request->input('data_prevista');
        $tarefa->status = 'pendente';
        $tarefa->save();

        return redirect()->route('tarefas.index')->with('success', 'Tarefa criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'data_prevista' => 'nullable|date'
        ]);

        $tarefa = Tarefa::findOrFail($id);
        $tarefa->descricao = $request->input('descricao');
        $tarefa->data_prevista = $request->input('data_prevista');
        $tarefa->status = $request->input('status');
        $tarefa->save();

        return redirect()->route('tarefas.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();

        return redirect()->route('tarefas.index')->with('success', 'Tarefa excluída com sucesso!');
    }

    public function exportarPdf()
    {
    $tarefas = Tarefa::orderBy('id', 'asc')->get();

    $pdf = Pdf::loadView('export.tarefas-pdf', compact('tarefas'));

    return $pdf->download('lista-de-tarefas.pdf');
    }
}
