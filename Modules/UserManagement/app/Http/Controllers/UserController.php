<?php

namespace Modules\UserManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\UserManagement\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);

        return view('usermanagement::index', compact('users'));
    }

    public function create()
    {
        return view('usermanagement::form');
    }

    public function store(UserRequest $request)
    {
        User::create($request->validated());

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('usermanagement::form', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']); // kosong = password tidak diganti
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diubah.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
