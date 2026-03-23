<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\JenisSuratField;

class JenisSuratFieldController extends Controller
{
    public function index(JenisSurat $jenisSurat)
    {
        $fields = $jenisSurat->fields;
        return view('admin.master.fields.index', compact('jenisSurat', 'fields'));
    }

    public function store(Request $request, JenisSurat $jenisSurat)
    {
        $validated = $request->validate([
            'field_key' => 'required|string|max:50',
            'field_label' => 'required|string|max:100',
            'field_type' => 'required|in:text,textarea,select,date,file,number,radio,checkbox',
            'field_options' => 'nullable|json',
            'is_required' => 'required|boolean',
            'urutan' => 'required|integer|min:0',
            'placeholder' => 'nullable|string|max:150',
            'validation_rules' => 'nullable|string|max:255',
        ]);

        $jenisSurat->fields()->create($validated);

        return redirect()->route('admin.master.fields.index', $jenisSurat)
            ->with('success', 'Field form dinamis berhasil ditambahkan.');
    }

    public function update(Request $request, JenisSurat $jenisSurat, JenisSuratField $field)
    {
        $validated = $request->validate([
            'field_key' => 'required|string|max:50',
            'field_label' => 'required|string|max:100',
            'field_type' => 'required|in:text,textarea,select,date,file,number,radio,checkbox',
            'field_options' => 'nullable|json',
            'is_required' => 'required|boolean',
            'urutan' => 'required|integer|min:0',
            'placeholder' => 'nullable|string|max:150',
            'validation_rules' => 'nullable|string|max:255',
        ]);

        $field->update($validated);

        return redirect()->route('admin.master.fields.index', $jenisSurat)
            ->with('success', 'Field form dinamis berhasil diperbarui.');
    }

    public function destroy(JenisSurat $jenisSurat, JenisSuratField $field)
    {
        $field->delete();
        return redirect()->route('admin.master.fields.index', $jenisSurat)
            ->with('success', 'Field form dinamis berhasil dihapus.');
    }
}
