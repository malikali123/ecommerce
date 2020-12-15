<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandsRequest;
use App\Http\Requests\MainCotegryRequest;
use App\Models\Brand;
//use App\Models\Category;
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
        $category = Category::orderBy('id', 'DESC')->find($id);
        if (!$category)
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);
        return view('dashboard.categories.edit', compact('category'));
    }

    public function update($id, BrandsRequest $request)
    {
        try {
            //validation
            //update database

            $category = Category::find($id);
            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);
            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم التحديث بنجاح']);


        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);


        }

    }

    public function distroy($id)
    {

        try {
            //validation
            //update database
            $category = Category::orderBy('id', 'DESC')->find($id);
            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);
            $category->delete();

            return redirect()->route('admin.maincategories')->with(['success' => 'تم الحذف بنجاح']);


        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);


        }
    }


}

