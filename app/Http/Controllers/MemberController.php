<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function index()
    {
        $query = request('query');
        $members = DB::table('members');
        if (!is_null($query) && $query !== '') {
            $members->where('name', 'like', '%' . $query . '%')->orderBy('id', 'desc');
            return response(['data' => $members->paginate(10)], 200);
        }
        return response(['data' => $members->paginate(5)], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $errors = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        Member::create([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        return response([
            'message' => 'Member Created'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $errors = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        Member::where('id', $id)->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
        return response([
            'message' => 'Member Updated'
        ], 200);
    }
}
