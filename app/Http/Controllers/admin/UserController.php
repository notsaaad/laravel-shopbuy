<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\user\createRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allUsers = User::get();
        $allCount = count($allUsers);
        $adminCount    = 0;
        $customerCount = 0;
        foreach ($allUsers as $user) {
          if($user->role == 'admin'){
            $adminCount++;
          }else if($user->role == 'customer'){
            $customerCount++;
          }
        }
        $users = User::paginate(SELF::Pagination_count);
        return view('admin.users.index', compact('users', 'customerCount', 'adminCount', 'allCount'));
    }

    function deleteAll(Request $request){
      $ids = $request->ids;
      User::whereIn('id', $ids)->delete();
      return response()->json(["success"=>"users Deleted"]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(createRequest $request)
    {
        User::create([
          'name'     => $request->user_username,
          'password' => $request->user_password,
          'email'    => $request->user_email,
          'role'     => $request->role,
        ]);

        return back()->with(['success'=> 'user Created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $user = User::findOrFail($id);
      return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          $request->validate([
            'user_username' => 'required|string|max:255',
            'user_email'    => 'required|email|max:255|unique:users,email,'.$id,
            'role'          => 'required|string',
            'user_password'      => 'nullable|string|confirmed',
        ]);
        $data = [
          'name'    => $request->user_username,
          'email'   => $request->user_email,
          'role'    => $request->role,
        ];
        if ($request->filled('password')) {
          $data['password'] = $request->user_password;
      }

        User::where('id', $id)->update($data);

        return redirect()->route('users.index')->with(['success'=> $request->user_username . ' updated (' . $id . ')' ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      $user = User::findOrFail($id);
      $user->delete();

      return back()->with(['success'=> "Delete User id $id successfuly"]);
    }
}
