<?php

namespace App\Http\Controllers;

use App\Models\MasterKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MasterKaryawanController extends Controller
{
    public function index()
    {
        $master_karyawans = MasterKaryawan::latest()->paginate(10);
        return view('master_karyawan.index', compact('master_karyawans'));
    }

    public function create()
    {
        return view('master_karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => [
                'required',
                'regex:/^[\pL\s]+$/u' // hanya huruf (unicode) & spasi
            ],
            'nomor_ktp' => [
                'required',
                'digits:16', // harus tepat 16 digit
                'unique:master_karyawans,nomor_ktp' // tidak boleh duplikat
            ],
            'nomor_telp' => [
                'required',
                'unique:master_karyawans,nomor_telp',
                'regex:/^(\d+|https?:\/\/wa\.me\/\d+)$/'
                // boleh angka biasa ATAU format wa.me (http/https)
            ],
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat_ktp' => 'required|string',
            'status_karyawan' => 'required',
            'tanggal_mulai_bekerja' => 'required|date',
            'penempatan' => 'required',
            'jabatan' => 'required',
        ], [
            // Custom messages biar lebih jelas
            'nama_lengkap.regex' => 'Nama lengkap hanya boleh huruf dan spasi.',
            'nomor_ktp.digits' => 'Nomor KTP harus tepat 16 digit.',
            'nomor_ktp.unique' => 'Nomor KTP sudah terdaftar.',
            'nomor_telp.regex' => 'Nomor telepon harus angka atau format https://wa.me/628xxxx.',
            'nomor_telp.unique' => 'Nomor telepon sudah terdaftar.',
        ]);

        MasterKaryawan::create(array_merge(
            $request->all(),
            ['create_by' => Auth::id()]
        ));

        return redirect()->route('master_karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit(MasterKaryawan $master_karyawan)
    {
        return view('master_karyawan.edit', compact('master_karyawan'));
    }

    public function update(Request $request, $id)
    {
        $master_karyawan = MasterKaryawan::findOrFail($id);

        $request->validate([
            'nama_lengkap' => [
                'required',
                'regex:/^[A-Za-z\s]+$/u'
            ],
            'nomor_ktp' => [
                'required',
                'digits:16',
                Rule::unique('master_karyawans', 'nomor_ktp')->ignore($master_karyawan->id)
            ],
            'nomor_telp' => [
                'required',
                Rule::unique('master_karyawans', 'nomor_telp')->ignore($master_karyawan->id),
                'regex:/^(?:\d+|https:\/\/wa\.me\/\d+)$/'
            ],
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat_ktp' => 'required|string',
            'status_karyawan' => 'required',
            'tanggal_mulai_bekerja' => 'required|date',
            'penempatan' => 'required',
            'jabatan' => 'required',
        ]);

        $master_karyawan->update(array_merge(
            $request->all(),
            ['modify_by' => Auth::id()]
        ));

        return redirect()->route('master_karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function show(MasterKaryawan $master_karyawan)
    {
        return view('master_karyawan.show', compact('master_karyawan'));
    }

    public function destroy(MasterKaryawan $master_karyawan)
    {
        $master_karyawan->delete();
        return redirect()->route('master_karyawan.index')->with('success', 'Data karyawan berhasil dihapus.');
    }
}
