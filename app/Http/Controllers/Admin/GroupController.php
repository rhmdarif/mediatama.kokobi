<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    //
    public function index()
    {
        $groups = DB::table('groups')->select("*", DB::raw("(SELECT COUNT(*) FROM topics WHERE group_id=groups.id) as total_topic"))->orderByDesc('id')->get();
        return view('admin.group.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.group.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:groups,name'
        ]);

        if($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        DB::table('groups')->insert([
            'name' => $request->name,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        return back()->with('success', "Group berhasil ditambahkan");
    }

    public function show($id)
    {
        return DB::table('groups')->find($id) ?? [];
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:groups,name'
        ]);

        if($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $group = DB::table('groups')->find($id);

        if($group == null) {
            return back()->with('error', "Group tidak ditemukan");
        }

        DB::table('groups')->where('id', $group->id)->update([
            'name' => $request->name,
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        return back()->with('success', "Group berhasil ditambahkan");
    }

    public function destroy($id)
    {
        DB::table('groups')->where('id', $id)->delete();
        return back()->with('success', "Group berhasil dihapus");
    }
}
