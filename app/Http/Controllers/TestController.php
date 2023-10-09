<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request) {
        
        $Bulan = [
            [
                'bulan' => '01',
                'name'  => 'Jan'
            ],
            [
                'bulan' => '02',
                'name'  => 'Feb'
            ],
            [
                'bulan' => '03',
                'name'  => 'Mar'
            ],
            [
                'bulan' => '04',
                'name'  => 'Apr'
            ],
            [
                'bulan' => '05',
                'name'  => 'Mei'
            ],
            [
                'bulan' => '06',
                'name'  => 'Jun'
            ],
            [
                'bulan' => '07',
                'name'  => 'Jul'
            ],
            [
                'bulan' => '08',
                'name'  => 'Ags'
            ],
            [
                'bulan' => '09',
                'name'  => 'Sep'
            ],
            [
                'bulan' => '10',
                'name'  => 'Okt'
            ],
            [
                'bulan' => '11',
                'name'  => 'Nov'
            ],
            [
                'bulan' => '12',
                'name'  => 'Des'
            ],
        ];

        $tahun = "";

        
        $makanan = array();

        
        $minuman = array();

        //  total menu per tahun paling kanan 
        $TotalMenuPerTahun = array();

        //  total per bulan atas ke bawah 
        $TotalPerBulan = array();

        // total menu perbulan kiri ke kanan berdasarkan bulan
        $arrTotalMenuPerBulan = array();

        // total pendatapan pertahun  pojok kanan bawah
        $subTotal = 0;

        // cek apakah data tahun yang dikirim dan data tahun tidak kosong
        if($request["tahun"] && $request["tahun"] != "") {
            
            $menu = json_decode(file_get_contents("http://tes-web.landa.id/intermediate/menu"), true); 
            $transaksi = json_decode(file_get_contents("http://tes-web.landa.id/intermediate/transaksi?tahun=".$request["tahun"]), true); 
            

            $tahun = $request["tahun"];
            
            foreach($menu as $menus) {

                
                if($menus["kategori"] == 'makanan') {
                    $makanan[]["makanan"] = $menus["menu"];
                }
                
                if($menus["kategori"] == 'minuman') {
                    $minuman[]["minuman"] = $menus["menu"];
                }
                
                
                foreach($Bulan as $namaBulan) {

                    $totalMenuPerBulan = 0;
                    $totalPerMenu = 0;
                    $totalPerBulan = 0;

                    foreach($transaksi as $transaksis) {
                        $timestamps = strtotime($transaksis['tanggal']);
                        $bulan = date("m", $timestamps);
                        
                        // jika bulan nya sama
                        if($bulan == $namaBulan['bulan']) {
                            // isi data total per bulan dengan data total di $transaksi
                            $totalPerBulan = $totalPerBulan + $transaksis["total"];
                        }

                        // jika menu nya sama
                        if($menus["menu"] == $transaksis["menu"]) {
                            // isi data total per menu dengan data total di $transaksi
                            $totalPerMenu = $totalPerMenu + $transaksis["total"];
                        }

                        // cek jika bulan nya sama dan menu nya sama
                        if($bulan == $namaBulan['bulan'] && $menus['menu'] == $transaksis["menu"]) {
                            // isi data total menu per bulan dengan data total di $transaksi
                            $totalMenuPerBulan = $totalMenuPerBulan + $transaksis["total"];
                        }
                        
                        // isi data array total perbulan dengan data total perbulan yang sudah dijumlahkan diatas berdasar bulan
                        $TotalPerBulan[$namaBulan["bulan"]] = $totalPerBulan;
                    }
                    // isi data array total menu per bulan dengan data total menu perbulan yang sudah dijumlahkan diatas berdasar menu
                    $arrTotalMenuPerBulan[$menus["menu"]][]["total"] = $totalMenuPerBulan;
                }
                // isi data array total menu per tahun dengan data total per menu yang sudah dijumlahkan diatas berdasar nama menu
                $TotalMenuPerTahun[$menus['menu']]["subtotal"] = $totalPerMenu;
            }
            // looping data array total per bulan
            foreach($TotalPerBulan as $totalPerBulan) {
                // tambah nilai subtotal dengan semua data total perbulan yang ada di data array total per bulan
                $subTotal += $totalPerBulan;
            }
        }

        return view('home', [
            "namaBulan" => $Bulan,
            "tahun" => $tahun,
            "makanan" => $makanan,
            "minuman" => $minuman,
            "totalMenuPerBulan" => $arrTotalMenuPerBulan,
            "totalPerBulan" => $TotalPerBulan,
            "totalMenuPerTahun" => $TotalMenuPerTahun,
            "subTotal" => $subTotal,
        ]);
    }
}
