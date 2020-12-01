<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function editShippingsMethods($type){
//free innet outer type for shippings methods
        if ($type === 'free')
             $shippingMethods = Setting::where('key','free_shipping_labl')->first();
        elseif ($type === 'inner')
             $shippingMethods = Setting::where('key','local_shipping_labl')->first();
        elseif ($type === 'outer')
             $shippingMethods = Setting::where('key','outer_shipping_labl')->first();
        else
             $shippingMethods = Setting::where('key','free_shipping_labl')->first();

        return view('dashboard.settings.shippings.edit', compact('shippingMethods'));
    }

    public function updateShippingsMethods(Request $request, $id){
        // validation

        // update atabase

    }
}
