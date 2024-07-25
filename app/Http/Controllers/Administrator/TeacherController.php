<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->searchUsers($request);

        return view('administrator.teachers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB
            'name' => 'required',
            'username' => 'required|min:5|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'phone' => ['nullable', 'regex:/^[0-9]+$/', 'unique:users,phone'],
        ]);

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/photos/user');
            $validatedData['photo'] = basename($photoPath);
        } else {
            $validatedData['photo'] = null;
        }

        // Menambahkan password & role default
        $validatedData['role_id'] = 3;
        $validatedData['password'] = bcrypt('password123');
        
        // Simpan data ke database
        $user = User::create($validatedData);

        return redirect()->route('administrator.teachers.index')->with('success', 'Wali Kelas baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $teacher)
    {
        $user = $teacher;
        return view('administrator.teachers.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $teacher)
    {
        $user = $teacher;
        
        $validatedData = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB
            'name' => 'required',
            'username' => ['required', 'min:5', 'unique:users,username,' . $user->id],
            'email' => ['nullable', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'regex:/^[0-9]+$/'],
            'password' => ['nullable', 'min:5'],
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete('public/photos/user/' . $user->photo);
            }

            $photoPath = $request->file('photo')->store('public/photos/user');
            $validatedData['photo'] = basename($photoPath);
        } else {
            $validatedData['photo'] = $user->photo;
        }

        // Simpan data ke database
        $user->update($validatedData);

        return redirect()->route('administrator.teachers.index')->with('success', 'Data wali kelas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $teacher)
    {
        if ($teacher->photo) {
            Storage::delete('public/photos/user/'. $teacher->photo);
        }

        $teacher->delete();

        return redirect()->route('administrator.teachers.index')->with('success', 'Data wali kelas berhasil dihapus');
    }

    private function searchUsers(Request $request)
    {
        $query = User::where('role_id', 3);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('username')) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        return $query->orderBy('name')->paginate(10)->appends($request->all());
    }
}
