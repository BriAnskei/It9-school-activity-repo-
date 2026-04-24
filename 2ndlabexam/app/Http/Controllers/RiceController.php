<?php

namespace App\Http\Controllers;

use App\Models\Rice;
use Illuminate\Http\Request;

class RiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rices = Rice::all();
        return view('index', compact('rices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Rice::create($request->all());
        return redirect()->route('rices.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rice = Rice::findOrFail($id);
        return view('show', compact('rice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rice = Rice::findOrFail($id);
        return view('edit', compact('rice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rice = Rice::findOrFail($id);
        $rice->update($request->all());
        return redirect()->route('rices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rice = Rice::findOrFail($id);
        $rice->delete();
        return redirect()->route('rices.index');
    }
}
