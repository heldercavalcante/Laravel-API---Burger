<?php

namespace App\Http\Controllers;

use App\Models\Optional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OptionalController extends Controller
{
    public function index() {

        $optionals = Optional::all();

        return response()->json($optionals);
    }

    public function store(Request $request) {

        $data = $request->validate([
            'opt_name' => 'required|string'
        ]);

        try {

            //creating a optional record

            $optional = Optional::create($data);

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
            'data' => $optional
        ], 201);
    }

    public function edit($id) {

        $optional = Optional::findOrFail($id);

        return response()->json($optional);
    }

    public function update(Request $request) {

        $data = $request->validate([
            'opt_name' => 'required|string'
        ]);

        try {

            //Update records from table optionals

            Optional::where('id',$request->id)->update(['opt_name' => $data['opt_name']]);

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

            //Delete records from table optionals

            Optional::findOrFail($id)->delete();

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
