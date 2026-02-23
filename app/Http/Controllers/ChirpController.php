<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with('user')
            ->latest()
            ->take(50)
            ->get();

        return view('home', ['chirps' => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'message' => [
                'required',
                'string',
                'max:255',
            ],
        ], [
            'message.required' => 'You should enter a message.',
            'message.max' => 'Your message should not exceed 255 characters.',
        ]);

        auth()->user()->chirps()->create($validation);

        return redirect('/')->with('success', 'Chirp created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        $validation = $request->validate([
            'message' => [
                'required',
                'string',
                'max:255',
            ],
        ], [
            'message.required' => 'You should enter a message.',
            'message.max' => 'Your message should not exceed 255 characters.',
        ]);

        $chirp->update($validation);

        return redirect('/')->with('success', 'Chirp updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return redirect('/')->with('success', 'Chirp deleted successfully');
    }
}
