<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Uploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $r) { return view('admin.profile', ['user' => $r->user()]); }

    public function update(Request $r)
    {
        $u = $r->user();
        $d = $r->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|unique:users,email,' . $u->id,
            'avatar' => 'nullable|image|max:4096',
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $u->name = $d['name']; $u->email = $d['email'];
        if ($r->hasFile('avatar')) { Uploader::delete($u->avatar); $u->avatar = Uploader::store($r->file('avatar'), 'avatars'); }
        elseif ($r->boolean('remove_avatar')) { Uploader::delete($u->avatar); $u->avatar = null; }
        if (!empty($d['password'])) $u->password = Hash::make($d['password']);
        $u->save();
        return back()->with('ok', 'Profile updated.');
    }
}
