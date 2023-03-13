<?php

namespace App\Http\Controllers;

use App\Models\Bread;
use App\Models\Meat;
use App\Models\Optional;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderOptional;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BurgerController extends Controller
{
    public function store(Request $request) {

        $data = $request->validate([
            'client' => 'required|string',
            'meat' => 'integer',
            'bread' => 'integer',
            'optionals' => 'array',
            'status' => 'integer'
        ]);

        try {

            $order = null;

            DB::transaction(function () use ($data, &$order) {
                //creating Order record
                $order = Order::create([
                    'client' => $data['client'],
                    'meat_id' => $data['meat'],
                    'bread_id' => $data['bread'],
                    'status' => $data['status']
                ]);

                //creating OrderOptional record for each optional

                foreach ($data['optionals'] as $optional) {
                    OrderOptional::create([
                        'order_id' => $order->id,
                        'optional_id' => $optional
                    ]);
                }
            });

            // if the transaction succeeds, the user will receive a success message

            return response()->json([
                'message' => 'Record created successfully',
                'data' => [
                    'order' => $order,
                    'optional' => $data['optionals']
                ]
            ], 201);

        } catch (\Exception $e) {

            // if the transaction fails , I'll log the error and send a error message to the user

            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to create record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function ingredients() {

        $meats = Meat::all();

        $breads = Bread::all();

        $optionals = Optional::all();

        $ingredients = [
            'meats' => $meats,
            'breads' => $breads,
            'optionals' => $optionals
        ];
        return response()->json($ingredients);
    }

    public function dashboard() {

        $orders = Order::select('orders.id','orders.client','orders.status','meats.meat_name','breads.bread_name')
            ->join('meats', 'meats.id', '=', 'orders.meat_id')
            ->join('breads', 'breads.id', '=', 'orders.bread_id')
            ->get();

        foreach ($orders as $index => $order) {
            $orders[$index]['optionals'] = OrderOptional::join('optionals', 'order_optional.optional_id', '=', 'optionals.id')
                ->select('optionals.id', 'optionals.opt_name')
                ->where('order_optional.order_id', '=', $order->id)
                ->get();
        }

        return response()->json($orders);
    }

    public function destroy($id) {

        try {

            DB::transaction(function () use ($id) {

                //Delete records from child table order_optional

                OrderOptional::where('order_id', $id)->delete();

                //Delete records from parent table orders

                Order::findOrFail($id)->delete();

            });

            // if the transaction succeeds, the user will receive a success message

            return response()->json([
                'message' => 'Records Deleted with success',
                'error' => false
            ], 201);

        } catch (\Exception $e) {

            // if the transaction fails , I'll log the error and send a error message to the user

            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to Delete the record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request) {

        $data = $request->validate([
            'status' => 'integer'
        ]);

        try {

            //Update records from table orders

            Order::where('id', $request->id)->update(['status' => $data['status']]);


            // if the transaction succeeds, the user will receive a success message

            return response()->json([
                'message' => 'Record Updated with success',
                'data' => [
                    'id' => $request->id,
                    'status' => $data['status']
                ],
                'error' => false
            ], 201);

        } catch (\Exception $e) {

            // if the update fails , I'll log the error and send a error message to the user

            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Failed to update record',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
