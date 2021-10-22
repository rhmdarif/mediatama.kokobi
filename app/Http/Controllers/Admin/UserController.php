<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = DB::table('users')->select('*', DB::raw("(SELECT COUNT(*) FROM topics WHERE user_id=users.id) as total_topic"))->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $id)
    {
        //
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$id->id,
            'name' => 'required|string',
        ]);
        if($validator->fails()) {
            return back()->with(['status' => false, 'msg' => $validator->errors()->first()]);
        }

        DB::table('users')->where('id', $id->id)->update([
            'email' => $request->email,
            'name' => $request->name,
        ]);

        return back()->with(['status' => true, 'msg' => "Data telah diperbaharui"]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $id)
    {
        //
        DB::table('users')->where('id', $id->id)->delete();
        return back()->with(['status' => true, 'msg' => "Data telah dihapus"]);
    }
}
