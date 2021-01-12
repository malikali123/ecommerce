<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandsRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.brands.index', compact('brands'));

    }

    public function create()
    {
        return view('dashboard.brands.create');


    }

    public function store(BrandsRequest $request)
    {
        // return  $request;
        try {

           // DB::beginTransaction();
            //validation

            //store
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);
            $fileName = "";
            if ($request -> has('photo')){
                $fileName = uploadImage('brands', $request -> photo);
            }

            $brands = Brand::create($request->except('_token','photo'));

            //save translations

            $brands -> name = $request->name;
            $brands -> photo = $fileName;
            $brands->save();
            DB::commit();

            //return success message
           return redirect()->route('admin.brands')->with(['success' => 'تم انشاء القسم بنجاح']);




        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);

        }





    }

    public function edit($id)
    {
        //get specific category and itis translations
        $brands = Brand::find($id);
        if (!$brands)
            return redirect()->route('admin.brands')->with(['error' => 'هذا القسم غير موجود']);
        return view('dashboard.brands.edit', compact('brands'));
    }

    public function update($id, BrandsRequest $request)
    {
        try {
            //validation
            //update database

            $brands = Brand::find($id);
            if (!$brands)
                return redirect()->route('admin.brands')->with(['error' => 'هذا الماركة غير موجود']);

            DB::beginTransaction();

            if ($request -> has('photo')){
                $fileName = uploadImage('brands', $request -> photo);
                Brand::where('id', $id)
                    ->update([
                        'photo' => $fileName
                    ]) ;
            }

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $brands->update($request->except('_token', 'id', 'photo'));

            //save translations
            $brands->name = $request->name;
            $brands->save();
            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم التحديث بنجاح']);


        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);


        }

    }

    public function distroy($id)
    {

        try {
            //validation
            //update database
            $brands = Brand::orderBy('id', 'DESC')->find($id);
            if (!$brands)
                return redirect()->route('admin.brands')->with(['error' => 'هذا القسم غير موجود']);
        $brands->delete();

            return redirect()->route('admin.brands')->with(['success' => 'تم الحذف بنجاح']);


       } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);


      }
    }


}

