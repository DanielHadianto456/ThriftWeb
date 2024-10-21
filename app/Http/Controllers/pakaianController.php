<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pakaianModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class pakaianController extends Controller
{
    // Function used to get all data from pakaian table
    public function getAll()
    {
        // Gets current user
        $user = Auth::user();

        // Check if user is an admin
        if ($user->user_level === 'ADMIN') {
            // Get all data from pakaian table
            $data = pakaianModel::with([
                'kategori'
            ])->get();
            return response()->json(['status' => true, 'message' => 'Data fetched', 'data' => $data], 200);
        } else {
            // If user is not an admin
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }
    }

    // Function used to add more data entry
    public function addPakaian(Request $req)
    {
        // Gets current user
        $user = Auth::user();

        // Check if user is an admin
        if ($user->user_level === 'ADMIN') {
            // Validation rules
            $validator = Validator::make($req->all(), [
                'kategori_pakaian_id' => 'required|integer',
                'pakaian_nama' => 'required|string|max:50',
                'pakaian_harga' => 'required|string|max:50',
                'pakaian_stok' => 'required|string|max:100',
                'pakaian_gambar_url' => 'required|string|max:50',
            ]);

            // If validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            // Save data
            $save = pakaianModel::create([
                'kategori_pakaian_id' => $req->get('kategori_pakaian_id'),
                'pakaian_nama' => $req->get('pakaian_nama'),
                'pakaian_harga' => $req->get('pakaian_harga'),
                'pakaian_stok' => $req->get('pakaian_stok'),
                'pakaian_gambar_url' => $req->get('pakaian_gambar_url'),
            ]);

            // If data is saved
            if ($save) {
                return response()->json(['status' => true, 'message' => 'Data saved'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Data not saved'], 500);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }
    }

    // Function used to update data entry
    public function editPakaian(Request $req, $id)
    {
        // Gets current user
        $user = Auth::user();

        if ($user->user_level === 'ADMIN') {
            // Validation rules
            $validator = Validator::make($req->all(), [
                'kategori_pakaian_id' => 'nullable|integer',
                'pakaian_nama' => 'nullable|string|max:50',
                'pakaian_harga' => 'nullable|string|max:50',
                'pakaian_stok' => 'nullable|string|max:100',
                'pakaian_gambar_url' => 'nullable|string|max:50',
            ]);

            // If validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            // Update data
            $update = [
                'kategori_pakaian_id' => $req->get('kategori_pakaian_id') ?? pakaianModel::select('kategori_pakaian_id')->where('pakaian_id', $id)->first()->kategori_pakaian_id,
                'pakaian_nama' => $req->get('pakaian_nama') ?? pakaianModel::select('pakaian_nama')->where('pakaian_id', $id)->first()->pakaian_nama,
                'pakaian_harga' => $req->get('pakaian_harga') ?? pakaianModel::select('pakaian_harga')->where('pakaian_id', $id)->first()->pakaian_harga,
                'pakaian_stok' => $req->get('pakaian_stok') ?? pakaianModel::select('pakaian_stok')->where('pakaian_id', $id)->first()->pakaian_stok,
                'pakaian_gambar_url' => $req->get('pakaian_gambar_url') ?? pakaianModel::select('pakaian_gambar_url')->where('pakaian_id', $id)->first()->pakaian_gambar_url,
            ];

            $save = pakaianModel::where('pakaian_id', $id)->update($update);

            // If data is updated
            if ($save) {
                return response()->json(['status' => true, 'message' => 'Data updated'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Data not updated'], 500);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }
    }

    // Function used to delete data entry
    public function deletePakaian($id)
    {
        // Gets current user
        $user = Auth::user();

        // Checks if user is an admin
        if ($user->user_level === 'ADMIN') {
            // Deletes data
            $delete = pakaianModel::where('pakaian_id', $id)->delete();

            // If data is deleted
            if ($delete) {
                return response()->json(['status' => true, 'message' => 'Data deleted'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Data not deleted'], 500);
            }
        } else {
            // If user is not an admin
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }
    }

    //function used to add Stock
    public function addStock(Request $request, $id){

        //Gets current user
        $user = Auth::user();

        //Checks if user is an admin
        if($user->user_level === "ADMIN"){

            //Validation rules
            $validator = Validator::make($request->all(), [
                'pakaian_stok' => 'required|integer',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

            //Gets current stock
            $pakaian = pakaianModel::find($id);

            if($pakaian){

                //Adds stock
                $pakaian->pakaian_stok += $request->get('pakaian_stok');

                $pakaian->save();

                return response()->json(['status' => true, 'message' => 'Stock added'], 200);
            
            } else {

                return response()->json(['status' => false, 'message' => 'Stock not added'], 500);

            }

        } else {

            //If user is not an admin
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);

        }

    }
}