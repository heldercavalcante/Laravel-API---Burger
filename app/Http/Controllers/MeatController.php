<?php

namespace App\Http\Controllers;

use App\Models\Meat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MeatController extends Controller
{
    public function index() {

        $meats = Meat::all();

        return response()->json($meats);
    }

    public function store(Request $request) {

        $data = $request->validate([
            'meat_name' => 'required|string'
        ]);

        try {
            //creating meat record

            $meat = Meat::create($data);

        } catch (\Exception $e) {

            // if the operation fails , I'll log the error and send a error message to the user

            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to create record',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Record created successfully',
            'data' => $meat
        ], 201);
    }

    public function edit($id) {

        $meat = Meat::findOrFail($id);

        return response()->json($meat);
    }

    public function update(Request $request) {

        $data = $request->validate([
            'meat_name' => 'required|string'
        ]);

        try {

            //Update records from table meats

            Meat::where('id',$request->id)->update(['meat_name' => $data['meat_name']]);

        } catch (\Exception $e) {

            // if the update fails , I'll log the error and send a error message to the user

            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to update the record',
                'error' => $e->getMessage(),
            ], 500);
        }

        // if the operation succeeds, the user will receive a success message

        return response()->json([
            'message' => 'Record updated with successfully',
            'data' => [
                'id' => $request->id,
            ],
            'error' => false
        ], 201);
    }


    public function destroy($id) {

        try {

            //Delete records from table meats

            Meat::findOrFail($id)->delete();

            // if the operation succeeds, the user will receive a success message

            return response()->json([
                'message' => 'Record Deleted with success',
                'error' => false
            ], 201);

        } catch (\Exception $e) {

            // if the operation fails , I'll log the error and send a error message to the user

            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to delete the record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
