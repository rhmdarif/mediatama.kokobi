<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserGroupController extends Controller
{
    //
    public function index($group_id)
    {
        $group = DB::table('groups')->find($group_id);
        $datas = DB::table('user_groups')->select('user_groups.*', 'users.name')->join('users', 'users.id', '=', 'user_groups.user_id')->where('group_id', $group_id)->get();
        return view('admin.user-group.index', compact('datas', 'group'));
    }

    public function accept_request($group_id, $id)
    {
        DB::table('user_groups')->where('id', $id)->update([
            'status' => 'active'
        ]);
        return ['status' => true, 'msg' => "Berhasil"];
    }

    public function decline_request($group_id, $id)
    {
        DB::table('user_groups')->where('id', $id)->delete();
        return ['status' => true, 'msg' => "Berhasil"];
    }

    public function users_not_this_group($group_id)
    {
        if(request()->has('name')) {
            return DB::table('users')->whereRaw("id NOT IN (SELECT user_id FROM user_groups WHERE group_id=?)", [$group_id])->where('name', 'like', '%'.request()->get('name').'%')->get();
        } else {
            return DB::table('users')->whereRaw("id NOT IN (SELECT user_id FROM user_groups WHERE group_id=?)", [$group_id])->get();
        }
    }

    public function add_users($group_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|array',
            'id.*' => 'exists:users,id'
        ]);

        if($validator->fails()) {
            return back() ->with("error", $validator->errors()->first());
        }

        foreach ($request->id as $key => $value) {
            DB::table('user_groups')->insert([
                'user_id' => $value,
                'group_id' => $group_id,
                'status' => 'active',
                'created_at' => date("Y-m-d H:i:s")
            ]);
        }

        return back()->with("success", "Pengguna telah ditambahkan");
    }
}
