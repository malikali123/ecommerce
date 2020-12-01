<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingsRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function editShippingsMethods($type)
    {
//free innet outer type for shippings methods
        if ($type === 'free')
            $shippingMethods = Setting::where('key', 'free_shipping_labl')->first();
        elseif ($type === 'inner')
            $shippingMethods = Setting::where('key', 'local_shipping_labl')->first();
        elseif ($type === 'outer')
            $shippingMethods = Setting::where('key', 'outer_shipping_labl')->first();
        else
            $shippingMethods = Setting::where('key', 'free_shipping_labl')->first();

        return view('dashboard.settings.shippings.edit', compact('shippingMethods'));
    }

    public function updateShippingsMethods(ShippingsRequest $request, $id)
    {
        // validation

        // update atabase
        try {
            $shipping_method = Setting::find($id);
            DB::beginTransaction();
            $shipping_method->update(['plain_value' => $request->plain_value]);
            $shipping_method->value = $request->value;
            $shipping_method->save();
            DB::commit();
            return redirect()->back()->with(['success' => 'تم التحديت بنجاح']);
        } catch (\Exception $ex){
            return redirect()->back()->with(['error' => ' هناك حطايرجي المحاولة لاحقا']);

            DB::rollBack();
        }

    }
}
