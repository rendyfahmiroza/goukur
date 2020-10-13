<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petugas = User::whereIn('hak_akses', [1,2])->get();
        return response()->json($petugas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $petugas = new User;
        $petugas->name = $request->name;
        $petugas->email = $request->email;
        $petugas->password = Hash::make($request->password);
        $petugas->status = $request->status;
        $petugas->kantah = $request->kantah;
        $petugas->hak_akses = $request->hak_akses;
        $petugas->no_telepon = $request->no_telepon;
        $petugas->telegram_id = $request->telegram_id;
        $petugas->save();

        return response()->json($petugas, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $petugas = User::find($id);
        return response()->json($petugas, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $petugas)
    {
        $petugas->name = $request->name;
        $petugas->email = $request->email;
        $petugas->kantah = $request->kantah;
        $petugas->no_telepon = $request->no_telepon;
        $petugas->telegram_id = $request->telegram_id;
        $petugas->status = $request->status;
        if ($request->password != null) {
            $petugas->password = Hash::make($request->password);
        }
        $petugas->update();
        // $petugas->fill($request->all());
        // $petugas->save();
        return response()->json($petugas, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $petugas)
    {
        $petugas->delete();
        return response()->json($petugas, 200);
    }
}
