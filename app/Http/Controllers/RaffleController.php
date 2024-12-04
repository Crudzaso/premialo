<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Para registrar errores

class RaffleController extends Controller
{
    public function index()
    {
        try {
            $raffles = Raffle::all();
            return view('raffles.index', compact('raffles'));
        } catch (\Exception $e) {
            Log::error('Error fetching raffles: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar rifas.');
        }
    }

    public function create()
    {
        return view('raffles.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required',
                'price' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'status' => 'required|in:active,inactive',
            ]);

            Raffle::create($request->all());

            return redirect()->route('raffles.index')->with('success', 'Rifa creada correctamente!');
        } catch (\Exception $e) {
            Log::error('Error creating raffle: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear rifa.');
        }
    }

    public function edit(Raffle $raffle)
    {
        return view('raffles.edit', compact('raffle'));
    }

    public function update(Request $request, Raffle $raffle)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required',
                'price' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'status' => 'required|in:active,inactive',
            ]);

            $raffle->update($request->all());

            return redirect()->route('raffles.index')->with('success', 'Rifa actualizada correctamente!');
        } catch (\Exception $e) {
            Log::error('Error updating raffle: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el usuario');
        }
    }

    public function destroy(Raffle $raffle)
    {
        try {
            $raffle->delete();

            return redirect()->route('raffles.index')->with('success', 'Rifa eliminada correctamente!');
        } catch (\Exception $e) {
            Log::error('Error deleting raffle: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar rifa.');
        }
    }
}
