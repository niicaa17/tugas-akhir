<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Umkm;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::with('umkm')->paginate(10);
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mode singleton: pastikan profil UMKM sudah ada
        if (!Umkm::exists()) {
            return redirect()->route('umkms.index')
                ->with('error', 'Lengkapi profil UMKM dulu sebelum menambah anggota.');
        }

        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string',
            'alamat_karyawan' => 'required|string',
            'telepon_karyawan' => 'required|string',
            'jabatan' => 'required|string',
        ]);

        $umkm = Umkm::first();
        if (!$umkm) {
            return redirect()->route('umkms.index')
                ->with('error', 'Profil UMKM belum ada.');
        }

        $validated['umkm_id'] = $umkm->id;

        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Anggota UMKM berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string',
            'alamat_karyawan' => 'required|string',
            'telepon_karyawan' => 'required|string',
            'jabatan' => 'required|string',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'Anggota UMKM berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Anggota UMKM berhasil dihapus');
    }
}
