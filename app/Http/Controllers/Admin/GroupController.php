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
        $groups = DB::table('groups')
                    ->select("*",
                        DB::raw("(SELECT COUNT(*) FROM user_groups WHERE status='pending' AND group_id=groups.id) as total_request"),
                        DB::raw("(SELECT COUNT(*) FROM topics WHERE group_id=groups.id) as total_topic"),
                        DB::raw("(SELECT COUNT(*) FROM topic_comments WHERE topic_id IN (SELECT id FROM topics WHERE group_id=groups.id)) as total_komentar")
                    )->orderByDesc('id')->get();

        // return $groups;
        return view('admin.group.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.group.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:groups,name',
            'passcode' => 'required|string|unique:groups,passcode',
            'invite_code' => 'required|string|unique:groups,invite_code',
        ]);

        if($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        DB::table('groups')->insert([
            'name' => $request->name,
            'passcode' => $request->passcode,
            'invite_code' => $request->invite_code,
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
            'name' => 'required|string|unique:groups,name,'.$id,
            'passcode' => 'required|string|unique:groups,passcode,'.$id,
            'invite_code' => 'required|string|unique:groups,invite_code,'.$id,
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
            'passcode' => $request->passcode,
            'invite_code' => $request->invite_code,
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        return back()->with('success', "Group berhasil perbaharui");
    }

    public function destroy($id)
    {
        DB::table('groups')->where('id', $id)->delete();
        return back()->with('success', "Group berhasil dihapus");
    }
}
