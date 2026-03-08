<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    
    public function index()
    {
        $clients = Client::paginate(12);
        return view('pages.dashboard.client.index', compact('clients'));
    }

    public function create()
    {
        return view('pages.dashboard.client.create');
    }

    public function store(Request $request)
    {
        // $request->merge([
        //     'slug' => str_replace(['.', ','], '', $request->slug)
        // ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:5000',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $foto = $request->file('foto');
        $foto->storeAs('public', $foto->hashName());

        Client::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto->hashName()
        ]);

        return redirect()->route('client.index')->with('success', 'Add Client Success');
    }


    public function edit(Client $client)
    {
        return view('pages.dashboard.client.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        // $request->merge([
        //     'slug' => str_replace(['.', ','], '', $request->slug)
        // ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:5000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $client->title = $request->title;
        $client->slug = $request->slug;
        $client->deskripsi = $request->deskripsi;

        if ($request->file('foto')) {

            if ($client->foto !== "noimage.png") {
                Storage::disk('public')->delete('public/' . $client->foto);
            }

            $foto = $request->file('foto');
            $foto->storeAs('public', $foto->hashName());
            $client->foto = $foto->hashName();
        }

        $client->update();

        return redirect()->route('client.index')->with('success', 'Update Client Success');
    }


    public function destroy(Client $client)
    {
        if ($client->foto !== "noimage.png") {
            Storage::disk('public')->delete($client->foto);
        }

        $client->delete();

        return redirect()->route('client.index')->with('success', 'Delete Client Success');
    }

}
