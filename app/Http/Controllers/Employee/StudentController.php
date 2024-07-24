<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->search($request);

        $classrooms = Classroom::all();
        $academicYears = AcademicYear::all();
        return view('employee.students.index', compact('data', 'classrooms', 'academicYears'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = Classroom::all();
        $academicYears = AcademicYear::all();
        return view('employee.students.create', compact('classrooms', 'academicYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input untuk User
        $validatedDataUser = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB
            'name' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'phone' => ['nullable', 'regex:/^[0-9]+$/'],
        ]);

        // Validasi input untuk Student
        $validatedDataStudent = $request->validate([
            'nisn' => ['required', 'unique:students,nisn', 'regex:/^[0-9]+$/'],
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'address' => 'nullable',
            'birth_date' => 'nullable|date',
        ]);

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/photos/user');
            $validatedDataUser['photo'] = basename($photoPath);
        } else {
            $validatedDataUser['photo'] = null;
        }

        // Menambahkan password & role default untuk User
        $validatedDataUser['role_id'] = 4;
        $validatedDataUser['username'] = $validatedDataStudent['nisn'];
        $validatedDataUser['password'] = bcrypt($validatedDataStudent['nisn']);

        // Simpan data User ke database
        $user = User::create($validatedDataUser);

        // Menambahkan user_id ke data Student
        $validatedDataStudent['user_id'] = $user->id;

        // Simpan data Student ke database
        Student::create($validatedDataStudent);

        return redirect()->route('employee.students.index')->with('success', 'Siswa baru berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $classrooms = Classroom::all();
        return view('employee.students.edit', compact('student', 'classrooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // Validasi input untuk User
        $validatedDataUser = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB
            'name' => 'required',
            'email' => 'nullable|email|unique:users,email,' . $student->user_id,
            'phone' => ['nullable', 'regex:/^[0-9]+$/'],
            'password' => 'nullable|min:5|confirmed'
        ]);

        // Validasi input untuk Student
        $validatedDataStudent = $request->validate([
            'nisn' => ['required', 'unique:students,nisn,' . $student->id, 'regex:/^[0-9]+$/'],
            'classroom_id' => 'required|exists:classrooms,id',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'address' => 'nullable',
            'birth_date' => 'nullable|date',
        ]);

        // Proses upload foto jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($student->user->photo) {
                Storage::delete('public/photos/user/'. $student->user->photo);
            }
            
            $photoPath = $request->file('photo')->store('public/photos/user');
            $validatedDataUser['photo'] = basename($photoPath);
        } else {
            $validatedDataUser['photo'] = $student->user->photo;
        }

        // Update password jika ada input baru
        if ($request->filled('password')) {
            $validatedDataUser['password'] = bcrypt($request->password);
        } else {
            unset($validatedDataUser['password']);
        }

        // Update data User di database
        $student->user->update($validatedDataUser);

        // Update data Student di database
        $student->update($validatedDataStudent);

        return redirect()->route('employee.students.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if ($student->user->photo) {
            Storage::delete('public/photos/user/'. $student->user->photo);
        }

        $student->user->delete();
        $student->delete();

        return redirect()->route('employee.students.index')->with('success', 'Data siswa berhasil dihapus');
    }

    private function search(Request $request)
    {
        $query = Student::with('user', 'classroom');

        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('email')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->email . '%');
            });
        }

        if ($request->filled('phone')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->phone . '%');
            });
        }

        if ($request->filled('nisn')) {
            $query->where('nisn', 'like', '%' . $request->nisn . '%');
        }

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }
        
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        // Ubah query untuk mengurutkan berdasarkan nama user dan classroom_id
        return $query->join('users', 'students.user_id', '=', 'users.id')
                    ->select('students.*')
                    ->orderBy('users.name', 'asc')
                    ->paginate(10)
                    ->appends($request->all());
    }


}
