<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as Controller;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kampus;
use App\Models\Jurusan;
use App\Models\JurusanKampus;
use App\Models\UserFollowKampus;

class CariKampusController extends Controller
{
    public function carikampus(Request $request)
    {
        $req = $request->all();

        if (!isset($req['kampus_name'])) {
            $kampus = Kampus::with('kota');
        } else {
            if ($req['kampus_name'] == "") {
                $kampus = Kampus::with('kota');
            } else {
                $kampus = Kampus::with('kota')
                    ->where('name', 'like', '%' . $req['kampus_name'] . '%');
            }

            if (isset($req["provinsi_id"])) {
                $kota = Kota::where('provinsi_id', $req["provinsi_id"])->pluck('id');
                $kampus = $kampus->whereIn('kota_id', $kota);
            }

            if (isset($req["jurusan_id"])) {
                $kampus_id = JurusanKampus::whereIn('jurusan_id', [$req["jurusan_id"]])->pluck('kampus_id');
                $kampus = $kampus->whereIn('id', $kampus_id);
            }

            if (isset($req["statuskampus_id"])) {
                $status_kampus = explode(",", $req["statuskampus_id"]);
                $kampus = $kampus->whereIn('statuskampus_id', $status_kampus);
            }

            if (isset($req["jeniskampus_id"])) {
                $jenis_kampus = explode(",", $req["jeniskampus_id"]);
                $kampus = $kampus->whereIn('jeniskampus_id', $jenis_kampus);
            }

            if (isset($req["is_politeknik"])) {
                $kampus = $kampus->where('is_politeknik', $req["is_politeknik"]);
            }
        }

        $kampus = $kampus->get();

        return response()->json([
            'success' => true,
            'data' => $kampus,
        ], 200);
    }

    public function jurusankampus(Request $request)
    {
        $req = $request->all();

        $jurusan = JurusanKampus::with([
            'jurusan' => function ($query) {
                $query->select('id', 'name');
            }, 'kampus' => function ($query2) {
                $query2->select('id', 'name');
            }
        ])
            // ->select('id')
            ->where('kampus_id', $req['kampus_id'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jurusan,
        ], 200);
    }

    public function jurusankampus_byname(Request $request)
    {
        $req = $request->all();

        $kampus = Kampus::where('name', $req['kampus_name'])->first();
        $jurusan = JurusanKampus::with([
            'jurusan' => function ($query) {
                $query->select('id', 'name');
            }, 'kampus' => function ($query2) {
                $query2->select('id', 'name');
            }
        ])
            // ->select('id')
            ->where('kampus_id', $kampus->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jurusan,
        ], 200);
    }

    public function followingkampus(Request $request)
    {
        $req = $request->all();

        $followingkampus = UserFollowKampus::with([
            'user' => function ($query) {
                $query->select('id');
            }, 'kampus' => function ($query2) {
                $query2->select('id', 'name');
            }
        ])
            ->where('user_id', auth('api')->id())
            ->get();

        return response()->json([
            'success' => true,
            'data' => $followingkampus,
        ], 200);
    }

    public function followkampus(Request $request)
    {
        $req = $request->all();

        $follow = UserFollowKampus::where('kampus_id', $req['kampus_id'])
            ->where('user_id', auth('api')->id())
            ->count();

        if ($follow > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kampus sudah kamu follow',
            ], 422);
        } else {
            UserFollowKampus::create([
                'kampus_id' => $req['kampus_id'],
                'user_id' => auth('api')->id(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil follow kampus',
        ], 200);
    }

    public function unfollowkampus(Request $request)
    {
        $req = $request->all();

        $follow = UserFollowKampus::where('kampus_id', $req['kampus_id'])
            ->where('user_id', auth('api')->id())
            ->count();

        if ($follow > 0) {
            UserFollowKampus::where('kampus_id', $req['kampus_id'])
                ->where('user_id', auth('api')->id())
                ->delete();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kampus sudah tidak kamu follow',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil unfollow kampus',
        ], 200);
    }
}
