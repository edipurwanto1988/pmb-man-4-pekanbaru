<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $sections = \App\Models\LandingPageSection::with('module')->orderBy('urutan')->get();
        $modules = \App\Models\LandingPageModule::all();
        return view('admin.landing.index', compact('sections', 'modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'landing_page_module_id' => 'required|exists:landing_page_modules,id',
        ]);

        $maxUrutan = \App\Models\LandingPageSection::max('urutan') ?? 0;
        $module = \App\Models\LandingPageModule::find($request->landing_page_module_id);
        
        $defaultContent = ['title' => 'Judul Baru'];
        if ($module->kode_modul == 'jurusan') $defaultContent['items'] = [];
        if ($module->kode_modul == 'faq') $defaultContent['items'] = [];
        if ($module->kode_modul == 'berita') $defaultContent['items'] = [];
        if ($module->kode_modul == 'galeri') $defaultContent['items'] = [];
        if ($module->kode_modul == 'alur') $defaultContent['items'] = [];

        \App\Models\LandingPageSection::create([
            'landing_page_module_id' => $request->landing_page_module_id,
            'urutan' => $maxUrutan + 1,
            'konten' => json_encode($defaultContent),
            'is_active' => false,
        ]);

        return redirect()->back()->with('success', 'Section added successfully.');
    }

    public function edit(string $id)
    {
        $section = \App\Models\LandingPageSection::with('module')->findOrFail($id);
        $content = json_decode($section->konten, true);
        return view('admin.landing.edit', compact('section', 'content'));
    }

    public function update(Request $request, string $id)
    {
        $section = \App\Models\LandingPageSection::findOrFail($id);
        $currentContent = json_decode($section->konten, true) ?? [];
        $data = $request->except(['_token', '_method', 'items', 'galeri_existing', 'galeri_new']);

        // Handle file uploads (top-level, e.g. hero image, sambutan image)
        foreach ($request->allFiles() as $key => $file) {
            if ($key === 'galeri_new') continue; // handled separately
            if (!is_array($file)) {
                $path = $file->store('landing-page', 'public');
                $data[$key] = 'storage/' . $path;
            }
        }

        // Merge simple fields
        foreach ($data as $key => $value) {
            $currentContent[$key] = $value;
        }

        // Handle dynamic items (Jurusan, FAQ, Alur)
        if ($request->has('items')) {
            $currentContent['items'] = $request->input('items');

            // Handle file uploads inside items
            if ($request->hasFile('items')) {
                foreach ($request->file('items') as $index => $itemFiles) {
                    foreach ($itemFiles as $key => $file) {
                        $path = $file->store('landing-page', 'public');
                        $currentContent['items'][$index][$key] = 'storage/' . $path;
                    }
                }
            }
        }

        // Handle Galeri items (foto upload per item)
        if ($request->has('galeri_existing') || $request->hasFile('galeri_new')) {
            $galeriItems = [];

            // Process existing items (keep or update caption, maybe replace foto)
            foreach ($request->input('galeri_existing', []) as $index => $existing) {
                $fotoPath = $existing['foto'] ?? '';

                // If user uploaded a new foto for this existing item
                if ($request->hasFile("galeri_new.{$index}.foto")) {
                    $file = $request->file("galeri_new.{$index}.foto");
                    $path = $file->store('landing-page/galeri', 'public');
                    $fotoPath = 'storage/' . $path;
                }

                $galeriItems[] = [
                    'foto'    => $fotoPath,
                    'caption' => $existing['caption'] ?? '',
                ];
            }

            // Process brand new items (high index, e.g. 1000+)
            if ($request->hasFile('galeri_new')) {
                foreach ($request->file('galeri_new') as $index => $newFiles) {
                    // Skip indices already handled (existing items replacements)
                    if (isset($request->input('galeri_existing', [])[$index])) continue;
                    if (isset($newFiles['foto'])) {
                        $path = $newFiles['foto']->store('landing-page/galeri', 'public');
                        $galeriItems[] = [
                            'foto'    => 'storage/' . $path,
                            'caption' => $request->input("galeri_new.{$index}.caption", ''),
                        ];
                    }
                }
            }

            $currentContent['items'] = $galeriItems;
        }

        $section->update([
            'konten'    => json_encode($currentContent),
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.landing-page.index')->with('success', 'Section updated successfully.');
    }

    public function destroy(string $id)
    {
        \App\Models\LandingPageSection::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Section deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);
        
        foreach ($request->order as $item) {
            \App\Models\LandingPageSection::where('id', $item['id'])->update(['urutan' => $item['position']]);
        }
        
        return response()->json(['status' => 'success']);
    }

    public function toggle($id)
    {
        $section = \App\Models\LandingPageSection::findOrFail($id);
        $section->update(['is_active' => !$section->is_active]);
        return response()->json(['status' => 'success', 'is_active' => $section->is_active]);
    }
}
