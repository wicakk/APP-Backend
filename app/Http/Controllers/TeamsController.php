<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamsController extends Controller
{
    public function index()
    {
        $teams = Teams::paginate(12);
        return view('pages.dashboard.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('pages.dashboard.teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:100',
            'phone'      => 'nullable|string|max:20',
            'bio'        => 'nullable|string|max:255',

            'linkedin'   => 'nullable|url|max:255',
            'instagram'  => 'nullable|url|max:255',

            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('teams', 'public');
        }

        Teams::create($validated);

        return redirect()->route('teams.index')->with('success', 'Team berhasil ditambahkan!');
    }

    public function edit(Teams $team)
    {
        return view('pages.dashboard.team.edit', compact('team'));
    }

    public function update(Request $request, Teams $team)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:100',
            'phone'      => 'nullable|string|max:20',
            'bio'        => 'nullable|string|max:255',

            'linkedin'   => 'nullable|url|max:255',
            'instagram'  => 'nullable|url|max:255',

            'photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($team->photo && Storage::disk('public')->exists($team->photo)) {
                Storage::disk('public')->delete($team->photo);
            }

            $validated['photo'] = $request->file('photo')->store('teams', 'public');
        }

        $team->update($validated);

        return redirect()->route('teams.index')->with('success', 'Team berhasil diperbarui!');
    }

    public function destroy(Teams $team)
    {
        if ($team->photo && Storage::disk('public')->exists($team->photo)) {
            Storage::disk('public')->delete($team->photo);
        }

        $team->delete();

        return back()->with('success', 'Team berhasil dihapus!');
    }
}
