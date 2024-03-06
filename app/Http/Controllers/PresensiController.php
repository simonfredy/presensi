<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        return view('presensi.create', compact('cek'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $latitudekantor = 3.570764;
        $longitudekantor = 98.649164;
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];
        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();
        if($cek > 0)
        {
            $ket = "out";
        }
        else
        {
            $ket = "in";
        }
        $image = $request->image;
        $folderpath = "public/upload/absensi/";
        $formatname = $nik."-".$tgl_presensi."-".$ket;
        $imageparts = explode(";base64", $image);
        $imagebase64 = base64_decode($imageparts[1]);
        $filename = $formatname.".png";
        $file = $folderpath . $filename;

        if($radius > 30)
        {
            echo "error|Maaf. Anda berada di luar radius. Jarak anda ".$radius." meter dari lingkungan kantor|radius";
        }
        else
        {
            if($cek > 0)
            {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $filename,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                if($update)
                {
                    echo "success|Terima kasih. Hati-hati di jalan|out";
                    Storage::put($file, $imagebase64);
                }
                else
                {
                    echo "error|Maaf gagal presensi. Hubungi Tim IT|out";
                }
            }
            else
            {
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $filename,
                    'lokasi_in' => $lokasi
                ];
                $simpan = DB::table('presensi')->insert($data);
                if($simpan)
                {
                    echo "success|Terima kasih. Selamat bekerja!|in";
                    Storage::put($file, $imagebase64);
                }
                else
                {
                    echo "error|Maaf gagal presensi. Hubungi Tim IT|out";;
                }
            }
        }
    }
    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        if ($request->hasFile('foto'))
        {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        }
        else
        {
            $foto = $karyawan->foto;
        }
        if (empty($request->password))
        {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        }
        else
        {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }
        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if ($update)
        {
            if ($request->hasFile('foto'))
            {
                $folderPath = "public/upload/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data berhasil diubah']);
        }
        else
        {
            return Redirect::back()->with(['error' => 'Data gagal diubah']);
        }
    }
    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktoner", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
    }
    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;
        $histori = DB::table('presensi')->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')->where('nik', $nik)->orderBy('tgl_presensi')->get();
        return view('presensi.gethistori', compact('histori'));
    }
    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan_izin')->where('nik', $nik)->get();
        return view('presensi.izin', compact('dataizin'));
    }
    public function buatizin()
    {
        return view('presensi.buatizin');
    }
    public function storeizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan
        ];
        $simpan = DB::table('pengajuan_izin')->insert($data);

        if($simpan)
        {
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
        }
        else
        {
            return redirect('/presensi/izin')->with(['error' => 'Data gagal disimpan!']);
        }
    }

    public function monitoring()
    {
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')->select('presensi.*', 'nama_lengkap', 'nama_dept')->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')->where('tgl_presensi', $tanggal)->get();

        return view('presensi.getpresensi', compact('presensi'));
    }

    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')->first();
        return view('presensi.showmap', compact('presensi'));
    }

    public function laporan()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktoner", "November", "Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('namabulan', 'karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->where('nik', $nik)->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')->first();
        $presensi = DB::table('presensi')->where('nik', $nik)->whereRaw('MONTH(tgl_presensi) = "' . $bulan . '"')->whereRaw('YEAR(tgl_presensi) = "' . $tahun . '"')->get();
        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }
}
