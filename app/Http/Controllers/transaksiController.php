<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pembelianModel;
use App\Models\pakaianModel;
use App\Models\metodePembayaranModel;
use App\Models\detailPembelianModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class transaksiController extends Controller
{
    //FUnction used to get all transaction data
    public function getAllPembelian()
    {

        $user = Auth::user();

        if ($user->user_level === 'ADMIN' || $user->user_level === 'PENGGUNA') {

            $data = pembelianModel::with([
                'user',
                // 'pembelian',
                'metodePembayaran'
            ])->get();
            return response()->json(['status' => true, 'message' => 'Data fetched', 'data' => $data], 200);

        } else {

            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);

        }

    }
    public function addPembelian2(Request $req)
    {
        // Get the authenticated user
        $user = Auth::user();

        //Gets transaction data
        $data = pembelianModel::where('user_id', $user->user_id)
        ->orderBy('pembelian_tanggal', 'desc')
        ->first();

        // Check if the user is pengguna
        if ($user->user_level === 'PENGGUNA') {

            // Check if the transaction is already paid
            if($data->status === 'BELUM_LUNAS'){
                return response()->json(['status' => false, 'message' => 'Last transaction has not been paid'], 400);
            }

            // Validation rules
            $validator = Validator::make($req->all(), [
                'metode_pembayaran_jenis' => 'required|string|max:50',  // Required if no existing payment method ID
                'metode_pembayaran_nomor' => 'nullable|string|max:50',  // Optional for new payment methods (e.g., COD doesn't need a number)
                'items' => 'required|array',  // Expecting an array of items
                'items.*.pakaian_id' => 'required|integer',  // Validate each item in the array
                'items.*.jumlah' => 'required|integer|min:1',  // Ensure quantity is valid
            ]);

            // If validation fails
            if ($validator->fails()) {

                return response()->json($validator->errors()->toJson(), 400);

            }

            // Begin a database transaction to ensure all-or-nothing behavior
            DB::beginTransaction();

            $metodePembayaranId = null;

            try {

                // Create a new payment method
                $metodePembayaran = metodePembayaranModel::create([
                    'user_id' => $user->user_id,
                    'metode_pembayaran_jenis' => $req->get('metode_pembayaran_jenis'),
                    'metode_pembayaran_nomor' => $req->get('metode_pembayaran_nomor'),
                ]);

                // Use the newly created payment method's ID
                $metodePembayaranId = $metodePembayaran->metode_pembayaran_id;

                $total_harga = 0;

                foreach ($req->items as $item) {
                    $pakaian = pakaianModel::find($item['pakaian_id']);
                    if ($pakaian->pakaian_stok < $item['jumlah']) {
                        return response()->json(['status' => false, 'message' => 'Insufficient stock for ' . $pakaian->pakaian_nama], 400);
                    }
                    $total_harga += $pakaian->pakaian_harga * $item['jumlah'];
                }

                // Create pembelian
                $pembelian = pembelianModel::create([
                    'user_id' => $user->user_id,
                    'metode_pembayaran_id' => $metodePembayaranId,
                    'pembelian_total_harga' => $total_harga,
                ]);

                // Create pembelian details and decrease stock
                foreach ($req->items as $item) {
                    $pakaian = pakaianModel::find($item['pakaian_id']);
                    detailPembelianModel::create([
                        'pembelian_id' => $pembelian->pembelian_id,
                        'pakaian_id' => $item['pakaian_id'],
                        'pembelian_detail_jumlah' => $item['jumlah'],
                        'pembelian_detail_total_harga' => $pakaian->pakaian_harga * $item['jumlah'],
                    ]);
                    $pakaian->pakaian_stok -= $item['jumlah'];
                    $pakaian->save();
                }


                // Commit the transaction
                DB::commit();

                return response()->json(['status' => true, 'message' => 'Transaction and payment method saved', 'data' => $pembelian], 200);


            } catch (\Exception $e) {

                // If anything goes wrong, rollback the transaction
                DB::rollBack();
                return response()->json(['status' => false, 'message' => 'Failed to save transaction', 'error' => $e->getMessage()], 500);

            }

        } else {

            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);

        }

    }

    //Function used to update transaction status
    public function updateStatus($id)
    {

        $user = Auth::user();
        $data = pembelianModel::find($id);

        if ($user->user_level === 'ADMIN' && $data->status === 'BELUM_LUNAS') {

            $data->status = 'LUNAS';
            $data->save();
            return response()->json(['status' => true, 'message' => 'Transaction status updated'], 200);

        } else {

            return response()->json(['status' => false, 'message' => 'Failed to update'], 403);

        }

    }

    //Function used to delete transaction
    public function deleteTransaction($id)
    {

        $user = Auth::user();
        $data = pembelianModel::find($id);

        if ($user->user_level === 'ADMIN' && $data->status === 'LUNAS') {

            $data->delete();
            return response()->json(['status' => true, 'message' => 'Transaction deleted'], 200);

        } else {
            
            return response()->json(['status' => false, 'message' => 'Failed to delete'], 403);

        }

    }


    // public function addPembelianBACKUP(Request $req)
    // {
    //     // Get the authenticated user
    //     $user = Auth::user();

    //     // Check if the user is an admin
    //     if ($user->user_level === 'ADMIN' || $user->user_level === 'PENGGUNA') {

    //         // Validation rules
    //         $validator = Validator::make($req->all(), [
    //             'metode_pembayaran_id' => 'nullable|integer',  // Payment method ID is optional if creating a new one
    //             'metode_pembayaran_jenis' => 'required_without:metode_pembayaran_id|string|max:50',  // Required if no existing payment method ID
    //             'metode_pembayaran_nomor' => 'nullable|string|max:50',  // Optional for new payment methods (e.g., COD doesn't need a number)
    //             'items' => 'required|array',  // Expecting an array of items
    //             'items.*.pakaian_id' => 'required|integer',  // Validate each item in the array
    //             'items.*.jumlah' => 'required|integer|min:1',  // Ensure quantity is valid
    //         ]);

    //         // If validation fails
    //         if ($validator->fails()) {

    //             return response()->json($validator->errors()->toJson(), 400);

    //         }

    //         // Begin a database transaction to ensure all-or-nothing behavior
    //         DB::beginTransaction();

    //         $metodePembayaranId = null;

    //         try {

    //             // Check if an existing payment method is provided
    //             if ($req->has('metode_pembayaran_id')) {

    //                 // Use existing payment method
    //                 $metodePembayaranId = $req->get('metode_pembayaran_id');

    //             } else {

    //                 // Create a new payment method if no ID is provided
    //                 $metodePembayaran = metodePembayaranModel::create([
    //                     'user_id' => $user->user_id,
    //                     'metode_pembayaran_jenis' => $req->get('metode_pembayaran_jenis'),
    //                     'metode_pembayaran_nomor' => $req->get('metode_pembayaran_nomor'),
    //                 ]);

    //                 // Use the newly created payment method's ID
    //                 $metodePembayaranId = $metodePembayaran->metode_pembayaran_id;

    //             }

    //             // Create the new pembelian (transaction)
    //             $pembelian = pembelianModel::create([
    //                 'user_id' => $user->user_id,
    //                 'metode_pembayaran_id' => $metodePembayaranId,
    //                 'pembelian_tanggal' => now(),
    //                 'pembelian_total_harga' => 0, // This will be calculated below
    //             ]);

    //             $totalPrice = 0;

    //             // Loop through each item and insert into pembelian_detail
    //             foreach ($req->items as $item) {
    //                 // Retrieve item price from PakaianModel
    //                 $pakaian = pakaianModel::find($item['pakaian_id']);
    //                 if (!$pakaian) {
    //                     // If item doesn't exist, rollback and return an error
    //                     DB::rollBack();
    //                     return response()->json(['status' => false, 'message' => 'Item not found'], 404);
    //                 }

    //                 // Calculate the total price for the item (price * quantity)
    //                 $itemTotalPrice = $pakaian->pakaian_harga * $item['jumlah'];
    //                 $totalPrice += $itemTotalPrice;

    //                 // Insert into pembelian_detail
    //                 detailPembelianModel::create([
    //                     'pembelian_id' => $pembelian->pembelian_id,
    //                     'pakaian_id' => $pakaian->pakaian_id,
    //                     'pembelian_detail_jumlah' => $item['jumlah'],
    //                     'pembelian_detail_total_harga' => $itemTotalPrice,
    //                 ]);

    //             }

    //             // Update the total price of the pembelian
    //             $pembelian->pembelian_total_harga = $totalPrice;
    //             $pembelian->save();

    //             // Commit the transaction
    //             DB::commit();

    //             return response()->json(['status' => true, 'message' => 'Transaction and payment method saved', 'data' => $pembelian], 200);


    //         } catch (\Exception $e) {

    //             // If anything goes wrong, rollback the transaction
    //             DB::rollBack();
    //             return response()->json(['status' => false, 'message' => 'Failed to save transaction', 'error' => $e->getMessage()], 500);

    //         }

    //     } else {

    //         return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);

    //     }

    // }


}