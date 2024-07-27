<?php

namespace App\Http\Controllers;

use App\Enums\AccountDesignation;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $accounts = User::query()
            ->latest()
            ->filter($request->only('search'))
            ->paginate(config('basicSetting.paginate'))
            ->withQueryString();
        return Inertia::render('Account/AccountIndex', [
            'accounts' => UserResource::collection($accounts),
            'filters' => $request->only('search')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accountDesignation = AccountDesignation::getValues();
        return Inertia::render('Account/AccountForm', [
            'accountDesignation' => $accountDesignation,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        User::create([
            'parent_id' => $request->user()->id,
            'designation' => $request->input('designation'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'email_verified_at' => now(),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('account.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $account)
    {
        $accountDesignation = AccountDesignation::getValues();
        return Inertia::render('Account/AccountForm', [
            'accountDesignation' => $accountDesignation,
            'account' => UserResource::make($account),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $account)
    {
        $account->update([
            'designation' => $request->input('designation'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'password' => $request->input('password') ? Hash::make($request->input('password')) : $account->password,
        ]);

        return redirect()->route('account.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account)
    {
        //
    }
}
