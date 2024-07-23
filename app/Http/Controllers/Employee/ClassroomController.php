<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->search($request);
        $teachers = User::where('role_id', 3)->get();

        return view('employee.classrooms.index', compact('data', 'teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::where('role_id', 3)
                    ->whereDoesntHave('classroom')
                    ->get();   
        return view('employee.classrooms.create', compact('teachers'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|unique:classrooms,name',
            'user_id' => 'required',
            'spp_fee' =>'required|min:1',
        ]);

        // Hapus karakter titik dari price
        $validatedData['spp_fee'] = str_replace('.', '', $request->spp_fee);
        
        // Simpan data ke database
        $classroom = Classroom::create($validatedData);

        return redirect()->route('employee.classrooms.index')->with('success', 'Kelas baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        $teachers = User::where('role_id', 3)
                        ->whereDoesntHave('classroom')
                        ->orWhere('id', $classroom->user_id)
                        ->get();   
        return view('employee.classrooms.edit', compact('classroom', 'teachers'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|unique:classrooms,name,' . $classroom->id,
            'user_id' => 'required|exists:users,id',
            'spp_fee' => 'required|min:1',
        ]);

        // Hapus karakter titik dari spp_fee
        $validatedData['spp_fee'] = str_replace('.', '', $request->spp_fee);
        
        // Update data kelas
        $classroom->update($validatedData);

        return redirect()->route('employee.classrooms.index')->with('success', 'Kelas berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        // Hapus data kelas
        $classroom->delete();

        return redirect()->route('employee.classrooms.index')->with('success', 'Kelas berhasil dihapus');
    }

    private function search(Request $request)
    {
        $query = Classroom::query();

        if ($request->filled('name')) { $query->where('name', 'like', '%' . $request->name . '%'); }
        if ($request->filled('user_id')) { $query->where('user_id', $request->user_id); }
        if ($request->filled('spp_fee')) { 
            $requestSppFee = str_replace('.', '', $request->spp_fee);
            $query->where('spp_fee', '<=', $requestSppFee); 
        }

        return $query->orderBy('name')->paginate(10)->appends($request->all());
    }
    
}
