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
            'is_required' => 'required|boolean',
            'urutan' => 'required|integer|min:0',
            'placeholder' => 'nullable|string|max:150',
        ]);

        // Process Options
        $options = $request->input('options', []);
        $validated['field_options'] = !empty($options) ? array_values(array_filter($options)) : null;

        // Process Validation Rules
        $rules = [];
        if ($request->boolean('val_numeric')) $rules[] = 'numeric';
        if ($request->boolean('val_email')) $rules[] = 'email';
        if ($request->boolean('val_alphabet')) $rules[] = 'alpha';
        if ($request->filled('val_min')) $rules[] = 'min:' . $request->val_min;
        if ($request->filled('val_max')) $rules[] = 'max:' . $request->val_max;

        $validated['validation_rules'] = !empty($rules) ? implode('|', $rules) : null;

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
            'is_required' => 'required|boolean',
            'urutan' => 'required|integer|min:0',
            'placeholder' => 'nullable|string|max:150',
        ]);

        // Process Options
        $options = $request->input('options', []);
        $validated['field_options'] = !empty($options) ? array_values(array_filter($options)) : null;

        // Process Validation Rules
        $rules = [];
        if ($request->boolean('val_numeric')) $rules[] = 'numeric';
        if ($request->boolean('val_email')) $rules[] = 'email';
        if ($request->boolean('val_alphabet')) $rules[] = 'alpha';
        if ($request->filled('val_min')) $rules[] = 'min:' . $request->val_min;
        if ($request->filled('val_max')) $rules[] = 'max:' . $request->val_max;

        $validated['validation_rules'] = !empty($rules) ? implode('|', $rules) : null;

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
