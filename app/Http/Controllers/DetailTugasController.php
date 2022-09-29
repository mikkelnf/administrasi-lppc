<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Semesterkuliah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailTugasController extends Controller
{
    public function edit1(Request $request, Angkatan $angkatan, Semesterkuliah $semester)
    {
        $i_s = $semester->id;

        if($i_s == 1){
            $tugas = 
            [$request->_token,
            $request->tugas1,
            $request->tugas2,
            $request->tugas3,
            $request->tugas4,
            $request->tugas5,
            $request->tugas6,
            $request->tugas7,
            $request->tugas8,
            $request->tugas9,
            $request->tugas10,
            $request->tugas11,
            $request->tugas12,
            $request->tugas13,
            $request->tugas14
            ];
            for($i = 1; $i <= 14; $i++){
                $detail_tugas[] = DB::table('detailtugas')->where('id_semesterkuliah', $semester->id)->where('nomor_tugas', $i)->update(['nama_tugas' => $tugas[$i]]);
            }
        }
        if($i_s == 2 || $i_s == 5){
            $tugas = 
            [$request->_token,
            $request->tugas1,
            $request->tugas2,
            $request->tugas3,
            $request->tugas4,
            $request->tugas5,
            $request->tugas6
            ];
            for($i = 1; $i <= 6; $i++){
                $detail_tugas[] = DB::table('detailtugas')->where('id_semesterkuliah', $semester->id)->where('nomor_tugas', $i)->update(['nama_tugas' => $tugas[$i]]);
            }
        }
        if($i_s == 3 || $i_s == 8){
            $tugas = 
            [$request->_token,
            $request->tugas1,
            $request->tugas2,
            $request->tugas3
            ];
            for($i = 1; $i <= 3; $i++){
                $detail_tugas[] = DB::table('detailtugas')->where('id_semesterkuliah', $semester->id)->where('nomor_tugas', $i)->update(['nama_tugas' => $tugas[$i]]);
            }
        }
        if($i_s == 4){
            $tugas = 
            [$request->_token,
            $request->tugas1,
            $request->tugas2,
            $request->tugas3,
            $request->tugas4
            ];
            for($i = 1; $i <= 4; $i++){
                $detail_tugas[] = DB::table('detailtugas')->where('id_semesterkuliah', $semester->id)->where('nomor_tugas', $i)->update(['nama_tugas' => $tugas[$i]]);
            }
        }
        if($i_s == 6 || $i_s == 7){
            $tugas = 
            [$request->_token,
            $request->tugas1,
            $request->tugas2,
            ];
            for($i = 1; $i <= 2; $i++){
                $detail_tugas[] = DB::table('detailtugas')->where('id_semesterkuliah', $semester->id)->where('nomor_tugas', $i)->update(['nama_tugas' => $tugas[$i]]);
            }
        }

        return back()->with('pesan', 'Detail tugas berhasil diedit');
    }

    public function edit2(Request $request, User $user, Semesterkuliah $semester)
    {
        $i_s = $semester->id;

        if($i_s == 1){
            $tugas = 
            [$request->_token,
            $request->tugas1,
            $request->tugas2,
            $request->tugas3,
            $request->tugas4,
            $request->tugas5,
            $request->tugas6,
            $request->tugas7,
            $request->tugas8,
            $request->tugas9,
            $request->tugas10,
            $request->tugas11,
            $request->tugas12,
            $request->tugas13,
            $request->tugas14
            ];
            for($i = 1; $i <= 14; $i++){
                $detail_tugas[] = DB::table('detailtugas')->where('id_semesterkuliah', $semester->id)->where('nomor_tugas', $i)->update(['nama_tugas' => $tugas[$i]]);
            }
        }
        if($i_s == 2 || $i_s == 5){
            $tugas = 
            [$request->_token,
            $request->tugas1,
            $request->tugas2,
            $request->tugas3,
            $request->tugas4,
            $request->tugas5,
            $request->tugas6
            ];
            for($i = 1; $i <= 6; $i++){
                $detail_tugas[] = DB::table('detailtugas')->where('id_semesterkuliah', $semester->id)->where('nomor_tugas', $i)->update(['nama_tugas' => $tugas[$i]]);
            }
        }
        if($i_s == 3 || $i_s == 8){
            $tugas = 
            [$request->_token,
            $request->tugas1,
            $request->tugas2,
            $request->tugas3
            ];
            for($i = 1; $i <= 3; $i++){
                $detail_tugas[] = DB::table('detailtugas')->where('id_semesterkuliah', $semester->id)->where('nomor_tugas', $i)->update(['nama_tugas' => $tugas[$i]]);
            }
        }
        if($i_s == 4){
            $tugas = 
            [$request->_token,
            $request->tugas1,
            $request->tugas2,
            $request->tugas3,
            $request->tugas4
            ];
            for($i = 1; $i <= 4; $i++){
                $detail_tugas[] = DB::table('detailtugas')->where('id_semesterkuliah', $semester->id)->where('nomor_tugas', $i)->update(['nama_tugas' => $tugas[$i]]);
            }
        }
        if($i_s == 6 || $i_s == 7){
            $tugas = 
            [$request->_token,
            $request->tugas1,
            $request->tugas2,
            ];
            for($i = 1; $i <= 2; $i++){
                $detail_tugas[] = DB::table('detailtugas')->where('id_semesterkuliah', $semester->id)->where('nomor_tugas', $i)->update(['nama_tugas' => $tugas[$i]]);
            }
        }
        
        return back()->with('pesan', 'Detail tugas berhasil diedit');
    }
}
