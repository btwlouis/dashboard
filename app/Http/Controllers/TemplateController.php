<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Spatie\Activitylog\Models\Activity;

class TemplateController extends Controller
{
    
    public function index()
    {
        $templates = Template::all();

        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'content' => 'required|min:10',
        ]);

        Template::create($data);

        activity()->log('Template ' . $request->name . ' wurde erstellt.');

        return redirect()->route('templates.index')
            ->with('success', 'Template erfolgreich erstellt.');
    }

    public function show(Template $template)
    {
        return view('templates.show', compact('template'));
    }

    public function edit(Template $template)
    {
        return view('templates.edit', compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name' => 'required',
            'content' => 'required|min:10',
        ]);

        $template->update($request->all());

        activity()->log('Template ' . $template->name . ' wurde aktualisiert.');

        return redirect()->route('templates.index')
            ->with('success', 'Template erfolgreich aktualisiert.');
    }

    public function destroy(Template $template)
    {
        $template->delete();

        activity()->log('Template ' . $template->name . ' wurde gelöscht.');

        return redirect()->route('templates.index')
            ->with('success', 'Template erfolgreich gelöscht.');
    }
}
