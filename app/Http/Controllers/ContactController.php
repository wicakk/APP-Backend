<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

// Tampilkan di dashboard admin
    public function index()
    {
        $contacts = Contact::paginate(10);
        return view('pages.dashboard.contact.index', compact('contacts'));
    }

    // Simpan dari form landing page
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s\'.-]+$/'
            ],
            'last_name' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s\'.-]+$/'
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255'
            ],
            'phone' => [
                'nullable',
                'regex:/^\+?[0-9]{9,15}$/'
            ],
            'message' => [
                'required',
                'string',
                'max:2000'
            ],
        ]);

        Contact::create($validated);

        return back()->with('success', 'Message sent successfully!');
    }

    // Tandai semua contact sebagai sudah dibaca
    public function markAllRead()
    {
        Contact::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'Semua notifikasi telah dibaca');
    }

    // Hapus pesan (opsional)
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Message deleted');
    }
}
