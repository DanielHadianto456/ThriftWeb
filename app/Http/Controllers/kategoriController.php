<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategoriModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class kategoriController extends Controller
{
    // Function used to get all data from kategori_pakaian table
    public function getAll()
    {

        //Gets current user
        $user = Auth::user();

        //Check if user is an admin
        if ($user->user_level === 'ADMIN') {

            //Get all data from kategori_pakaian table
            $data = kategoriModel::all();
            return response()->json(['status' => true, 'message' => 'Data fetched', 'data' => $data], 200);

        } else {

            //If user is not an admin
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);

        }

    }

    //Function used to add more data entry
    public function addCategory(Request $req)
    {

        //Gets current user
        $user = Auth::user();

        //Check if user is an admin
        if ($user->user_level === 'ADMIN') {

            //Validation rules
            $validator = Validator::make($req->all(), [
                'kategori_pakaian_nama' => 'required|string|max:50',
            ]);

            //If validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            //Save data
            $save = kategoriModel::create([
                'kategori_pakaian_nama' => $req->get('kategori_pakaian_nama'),
            ]);

            //If data is saved
            if ($save) {
                return response()->json(['status' => true, 'message' => 'Data saved'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Data not saved'], 500);
            }

        } else {

            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);

        }

    }

    //Function used to update data entry
    public function editCategory(Request $req, $id)
    {

        //Gets current user
        $user = Auth::user();

        if ($user->user_level === 'ADMIN') {

            //Validation rules
            $validator = Validator::make($req->all(), [
                'kategori_pakaian_nama' => 'nullable|string|max:50',
            ]);

            //If validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            //Update data
            $update = [
                'kategori_pakaian_nama' => $req->get('kategori_pakaian_nama') ?? kategoriModel::select('kategori_pakaian_nama')->where('kategori_pakaian_id', $id)->first()->kategori_pakaian_nama,
            ];

            $save = kategoriModel::where('kategori_pakaian_id', $id)->update($update);

            //If data is updated
            if ($save) {
                return response()->json(['status' => true, 'message' => 'Data updated'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Data not updated'], 500);
            }

        } else {

            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);

        }

    }

    //Function used to delete data entry
    public function deleteCategory($id){

        //Gets current user
        $user = Auth::user();

        //Checks if user is an admin
        if($user->user_level === "ADMIN"){

            //Deletes data
            $delete = kategoriModel::where('kategori_pakaian_id', $id)->delete();

            //If data is deleted
            if($delete){

                return response()->json(['status' => true, 'message' => 'Data deleted'], 200);

            } else {
                
                return response()->json(['status' => false, 'message' => 'Data not deleted'], 500);

            }

        } else {

            //If user is not an admin
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);

        }

    }

}
