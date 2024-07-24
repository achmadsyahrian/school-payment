<?php

return [
    'required' => 'Kolom :attribute wajib diisi.',
    'attributes' => [
        'name' => 'nama',
        'role_id' => 'level',
        'phone' => 'telepon',
        'gender' => 'jenis kelamin',
        'spp_fee' => 'biaya spp',
        'user_id' => 'wali kelas',
        'address' => 'alamat',
    ],
    'regex' => 'Kolom :attribute harus memenuhi format yang benar.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'min' => [
        'string' => 'Kolom :attribute harus memiliki setidaknya :min karakter.',
        'integer' => 'Kolom :attribute harus memiliki setidaknya :min karakter.',
    ],
    'same' => 'Kolom :attribute harus sama dengan :other.',
    'max' => [
        'file' => 'Ukuran file :attribute tidak boleh melebihi :max kilobyte.', 
        'string' => 'Panjang karakter :attribute tidak boleh melebihi :max karakter.', 
    ],
    'unique' => 'Data :attribute sudah terdaftar dalam sistem, harap cek kembali.',
    'image' => 'Kolom :attribute harus berupa file gambar.',
    'numeric' => 'Kolom :attribute hanya boleh berisi angka.',
    'integer' => 'Kolom :attribute hanya boleh berisi angka.',
    'uploaded' => 'Ukuran file yang diunggah pada kolom :attribute terlalu besar. Maksimum 2MB.',
    'after_or_equal' => 'Kolom :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'custom' => [
        'photo' => [
            'mimes' => 'Kolom :attribute harus berupa file dengan tipe: jpeg, png, jpg.',
        ],
    ],
];
