<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::paginate(12);
        return view('pages.dashboard.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('pages.dashboard.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string|max:10000',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer'   => $request->answer,
        ]);

        return redirect()->route('faq.index')->with('success', 'Add FAQ Success');
    }

    public function edit(Faq $faq)
    {
        return view('pages.dashboard.faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string|max:10000',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer'   => $request->answer,
        ]);

        return redirect()->route('faq.index')->with('success', 'Update FAQ Success');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faq.index')->with('success', 'Delete FAQ Success');
    }
}
