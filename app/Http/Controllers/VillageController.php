<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\Desa;
class VillageController extends Controller
{
    public function index()
    {
        return view('desamap', [
            'title' => 'Peta Desa',
            'desas' => Desa::all(),
        ]);

    }
    public function coba(Request $request)
    {
        $tahunTerpilih = $request->get('tahun', date('Y'));
        $tahunSekarang = date('Y');
        $tahunList = range(2020, $tahunSekarang);
        return view('admin.maps.desamap', [
            'app' => Application::all(),
            'title' => 'Peta Desa',
            'desas' => Desa::whereYear('updated_at', $tahunTerpilih)->get(),
            'tahunList' => array_reverse($tahunList),
            'tahunTerpilih' => $tahunTerpilih,
        ]);

    }

    public function sosialisasi()
    {
        return view('admin.maps.sosialisasimap', [
            'app' => Application::all(),
            'title' => 'Peta Desa',
            'desas' => Desa::with('sosialisasis')->get(),
        ]);

    }
    public function jenis()
    {
        return view('admin.maps.golonganmap', [
            'app' => Application::all(),
            'title' => 'Peta Desa',
            'desas' => Desa::with('kecamatan')->get(),
        ]);

    }
    public function all()
    {
        return view('admin.maps.allmap', [
            'app' => Application::all(),
            'title' => 'Peta Desa',
            'desas' => Desa::with('kecamatan')->get(),
        ]);

    }
}
