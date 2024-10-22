<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pembelianModel;
use App\Models\detailPembelianModel;
use App\Models\pakaianModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class pembelianDetailController extends Controller
{
    // Function to add a pembelian detail to an existing pembelian
    // public function addPembelianDetail(Request $request, $pembelian_id)
    // {
    //     // Gets current user
    //     $user = Auth::user();

    //     // Check if user is an pengguna
    //     if ($user->user_level === 'PENGGUNA') {
    //         // Validation rules
    //         $validator = Validator::make($request->all(), [
    //             'items' => 'required|array',
    //             'items.*.pakaian_id' => 'required|integer|exists:pakaian,pakaian_id',
    //             'items.*.pembelian_detail_jumlah' => 'required|integer|min:1',
    //         ]);

    //         // If validation fails
    //         if ($validator->fails()) {
    //             return response()->json($validator->errors()->toJson(), 400);
    //         }

    //         $totalPrice = 0;
    //         $details = [];

    //         foreach ($request->items as $item) {
    //             // Get the pakaian details
    //             $pakaian = pakaianModel::find($item['pakaian_id']);

    //             // Calculate the total price for the detail
    //             $pembelian_detail_total_harga = $pakaian->pakaian_harga * $item['pembelian_detail_jumlah'];

    //             // Save the pembelian detail
    //             $detail = detailPembelianModel::create([
    //                 'pembelian_id' => $pembelian_id,
    //                 'pakaian_id' => $item['pakaian_id'],
    //                 'pembelian_detail_jumlah' => $item['pembelian_detail_jumlah'],
    //                 'pembelian_detail_total_harga' => $pembelian_detail_total_harga,
    //             ]);

    //             $details[] = $detail;
    //             $totalPrice += $pembelian_detail_total_harga;
    //         }

    //         // Update the total price in pembelian
    //         $pembelian = pembelianModel::find($pembelian_id);
    //         $pembelian->pembelian_total_harga += $totalPrice;
    //         $pembelian->save();

    //         return response()->json(['status' => true, 'message' => 'Pembelian details added and total updated', 'data' => $details], 200);
    //     } else {
    //         return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
    //     }
    // }

    // Function to add a pembelian detail to an existing pembelian
    public function addPembelianDetail(Request $request, $pembelian_id)
    {
        // Gets current user
        $user = Auth::user();

        // Check if user is an pengguna
        if ($user->user_level === 'PENGGUNA') {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'items' => 'required|array',
                'items.*.pakaian_id' => 'required|integer|exists:pakaian,pakaian_id',
                'items.*.pembelian_detail_jumlah' => 'required|integer|min:1',
            ]);

            // If validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            // Get the existing pembelian
            $pembelian = pembelianModel::find($pembelian_id);
            if (!$pembelian) {
                return response()->json(['status' => false, 'message' => 'Pembelian not found'], 404);
            }

            $totalPrice = 0;
            $details = [];

            foreach ($request->items as $item) {
                // Get the pakaian details
                $pakaian = pakaianModel::find($item['pakaian_id']);

                // Check stock
                if ($pakaian->pakaian_stok < $item['pembelian_detail_jumlah']) {
                    return response()->json(['status' => false, 'message' => 'Insufficient stock for ' . $pakaian->pakaian_nama], 400);
                }

                // Calculate the total price for the detail
                $pembelian_detail_total_harga = $pakaian->pakaian_harga * $item['pembelian_detail_jumlah'];
                $totalPrice += $pembelian_detail_total_harga;

                // Save the pembelian detail
                $details[] = detailPembelianModel::create([
                    'pembelian_id' => $pembelian_id,
                    'pakaian_id' => $item['pakaian_id'],
                    'pembelian_detail_jumlah' => $item['pembelian_detail_jumlah'],
                    'pembelian_detail_total_harga' => $pembelian_detail_total_harga,
                ]);

                // Decrease stock
                $pakaian->pakaian_stok -= $item['pembelian_detail_jumlah'];
                $pakaian->save();
            }

            // Update the total price in pembelian
            $pembelian->pembelian_total_harga += $totalPrice;
            $pembelian->save();

            return response()->json(['status' => true, 'message' => 'Pembelian detail added and total updated', 'data' => $details], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }
    }
}