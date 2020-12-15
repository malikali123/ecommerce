<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
//use App\Http\Requests\MainCotegryRequest;
use App\Http\Requests\SubCotegryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::child()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.sub_categories.index', compact('categories'));

    }

    public function create()
    {
        $categories = Category::parent()->orderBy('id', 'DESC')->get();
        return view('dashboard.sub_categories.create', compact('categories'));


    }

    public function store(SubCotegryRequest $request)
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
            $category = Category::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->save();
            DB::commit();

            //return success message
           return redirect()->route('admin.subcategories')->with(['success' => 'تم انشاء القسم بنجاح']);




        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);

        }





    }

    public function edit($id)
    {
        //get specific category and itis translations
        $category = Category::orderBy('id', 'DESC')->find($id);
        if (!$category)
            return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود']);
        $categories = Category::parent()->orderBy('id', 'DESC')->get();

        return view('dashboard.sub_categories.edit', compact('category', 'categories'));
    }

    public function update($id, SubCotegryRequest $request)
    {
        try {
            //validation
            //update database

            $category = Category::find($id);
            if (!$category)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود']);
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);
            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();
            return redirect()->route('admin.subcategories')->with(['success' => 'تم التحديث بنجاح']);


        } catch (\Exception $ex) {
            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);


        }

    }

    public function distroy($id)
    {

        try {
            //validation
            //update database
            $category = Category::orderBy('id', 'DESC')->find($id);
            if (!$category)
                return redirect()->route('admin.subcategories')->with(['error' => 'هذا القسم غير موجود']);
            $category->delete();

            return redirect()->route('admin.subcategories')->with(['success' => 'تم الحذف بنجاح']);


        } catch (\Exception $ex) {
            return redirect()->route('admin.subcategories')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);


        }
    }


}

