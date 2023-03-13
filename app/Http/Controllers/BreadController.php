<?php

namespace App\Http\Controllers;

use App\Models\Bread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BreadController extends Controller
{

    public function index() {

        $breads = Bread::all();

        return response()->json($breads);

    }

    public function store(Request $request) {

        $data = $request->validate([
            'bread_name' => 'required|string'
        ]);

        try {

            //creating bread record

            $bread = Bread::create($data);

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
            'data' => $bread
        ], 201);
    }

    public function edit($id) {

        $bread = Bread::findOrFail($id);

        return response()->json($bread);
    }

    public function update(Request $request) {

        $data = $request->validate([
            'bread_name' => 'required|string'
        ]);

        try {

            //Update records from table breads

            Bread::where('id',$request->id)->update(['bread_name' => $data['bread_name']]);

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

            //Delete records from table breads

            Bread::findOrFail($id)->delete();

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
