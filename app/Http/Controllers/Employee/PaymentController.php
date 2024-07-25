<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Payment;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = $this->search($request);

        $academicYears = AcademicYear::all();
        $classrooms = Classroom::all();
        return view('employee.payments.index', compact('students', 'academicYears', 'classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($nisn)
    {
        // Cari siswa berdasarkan NISN atau lemparkan pengecualian jika tidak ditemukan
        $student = Student::where('nisn', $nisn)->firstOrFail();

        // Mendapatkan tahun ajaran siswa saat ini
        $currentAcademicYearId = $student->academic_year_id;
        $currentAcademicYear = AcademicYear::find($currentAcademicYearId);

        // Mengurai tahun ajaran siswa
        $currentYearRange = explode('-', $currentAcademicYear->name);
        $currentStartYear = (int) $currentYearRange[0];
        $currentEndYear = (int) $currentYearRange[1];

        // Mengambil semua tahun ajaran, memfilter berdasarkan tahun ajaran siswa, dan mengurutkan berdasarkan nama
        $academicYears = AcademicYear::all()
            ->filter(function ($item) use ($currentStartYear) {
                $yearRange = explode('-', $item->name);
                $startYear = (int) $yearRange[0];
                return $startYear >= $currentStartYear;
            })
            ->sortBy(function ($item) {
                $yearRange = explode('-', $item->name);
                return (int) $yearRange[0]; // Mengurutkan berdasarkan tahun mulai
            });

        // Mendapatkan tanggal saat ini
        $currentDate = now();
        $academicYears = $academicYears->map(function ($item) use ($currentDate, $student) {
            $yearRange = explode('-', $item->name);
            $startYear = (int) $yearRange[0];
            $endYear = (int) $yearRange[1];
            
            // Mendefinisikan rentang waktu tahun ajaran
            $startDate = Carbon::create($startYear, 6, 1);
            $endDate = Carbon::create($endYear, 5, 31);

            // Menentukan apakah tahun ajaran aktif
            $isActive = $currentDate->between($startDate, $endDate);

            // Cek apakah pembayaran lengkap
            $payments = Payment::where('student_id', $student->id)
                ->where('academic_year_id', $item->id)
                ->whereBetween('month', [1, 12])
                ->pluck('month')
                ->toArray();

            $isComplete = count($payments) === 12;

            // Menambahkan flag aktif dan kelengkapan pembayaran ke setiap item
            $item->isActive = $isActive;
            $item->isComplete = $isComplete;

            return $item;
        });

        return view('employee.payments.show', compact('student', 'academicYears'));
    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }

    public function showDetailPayment($nisn, $academicYear)
    {
        $academicYearDetail = AcademicYear::where('name', $academicYear)->firstOrFail();
        $student = Student::where('nisn', $nisn)->firstOrFail();

        // Ambil semua pembayaran untuk siswa ini pada tahun ajaran tertentu
        $payments = Payment::where('student_id', $student->id)
            ->where('academic_year_id', $academicYearDetail->id)
            ->get()
            ->keyBy('month');

        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return view('employee.payments.detail', compact('student', 'academicYearDetail', 'months', 'payments'));
    }

    
    public function storePayment(Student $student, $academicYear, $month)
    {
        
        // Buat data pembayaran baru
        $payment = new Payment();
        $payment->student_id = $student->id;
        $payment->month = $month;
        $payment->payment_date = Carbon::now(); // Tanggal pembayaran adalah hari ini
        $payment->academic_year_id = $academicYear;

        // Simpan data pembayaran ke dalam database
        $payment->save();

        // Redirect kembali atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Pembayaran berhasil disimpan.');
    }

    private function search(Request $request)
    {
        $query = Student::with('user', 'classroom', 'academicYear');

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
