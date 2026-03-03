<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PriorityBobot;

class PriorityBobotController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $bobots = PriorityBobot::when($search, fn($q) => $q->where('kategori', 'like', "%{$search}%")
            ->orWhere('label', 'like', "%{$search}%")
            ->orWhere('kode', 'like', "%{$search}%"))
            ->orderBy('kategori')->orderBy('kode')->get();
        return view('admin.master.priority-bobot.index', compact('bobots'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:50',
            'kode' => 'required|string|max:50|unique:priority_bobot',
            'label' => 'required|string|max:100',
            'bobot' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        PriorityBobot::create($validated);

        return redirect()->route('admin.master.priority-bobot.index')
            ->with('success', 'Bobot Prioritas berhasil ditambahkan.');
    }

    public function update(Request $request, PriorityBobot $priorityBobot)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:50',
            'kode' => 'required|string|max:50|unique:priority_bobot,kode,' . $priorityBobot->id,
            'label' => 'required|string|max:100',
            'bobot' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $priorityBobot->update($validated);

        return redirect()->route('admin.master.priority-bobot.index')
            ->with('success', 'Bobot Prioritas berhasil diperbarui.');
    }

    public function destroy(PriorityBobot $priorityBobot)
    {
        $priorityBobot->delete();
        return redirect()->route('admin.master.priority-bobot.index')
            ->with('success', 'Bobot Prioritas berhasil dihapus.');
    }
}
