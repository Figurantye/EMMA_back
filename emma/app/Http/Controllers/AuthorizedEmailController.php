<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorizedEmailRequest;
use App\Models\AuthorizedEmail;
use Illuminate\Http\Request;

class AuthorizedEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorizeAdmin();
        return AuthorizedEmail::all();
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
    public function store(StoreAuthorizedEmailRequest $request)
    {
        return AuthorizedEmail::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthorizedEmail $authorizedEmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuthorizedEmail $authorizedEmail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AuthorizedEmail $authorizedEmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorizeAdmin();
        $email = AuthorizedEmail::findOrFail($id);
        $email->delete();
        return response()->noContent();
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Acesso negado');
        }
    }
}
