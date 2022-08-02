<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'website_id' => 'required|exists:websites,id',
        ]);
        $user = User::where('email', '=', $request->email)->first();
        $website = Website::find($request->website_id);
        if ($user === null) {
            // Create a user if does not exists
            $user = User::create([
                'email' => $request->email,
            ]);
            $user->websites()->attach($website);
        }else{
            if ($user->websites()->where('website_id',$request->website_id)->exists()) {
                return response()->json(['Already subscribed to this website'], 200);
            }
            $user->websites()->attach($website);
        }
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
        ]);
        $user->update([
            'email' => $request->email,
        ]);

        return response()->json($user,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json('Done');
    }

    /**
     * Display a listing of the users in a particular website.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsersByWebsite(Website $website)
    {
        return response()->json($website->users,200);
    }
}
