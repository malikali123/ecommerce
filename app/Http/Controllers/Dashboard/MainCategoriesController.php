<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCotegryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::with('_parent')->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));

    }

    public function create()
    {
        $categories =   Category::select('id','parent_id')->get();
        return view('dashboard.categories.create',compact('categories'));
   


    }

    public function store(MainCotegryRequest $request)
    {
        // return  $request;
        try {

            DB::beginTransaction();
            //validation

            //store
            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

                 //if user choose main category then we must remove paret id from the request

            if($request -> type == 1) //main category
            {
                $request->request->add(['parent_id' => null]);
            }

            //if he choose child category we mus t add parent id


            $category = Category::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
            $category->save();
            DB::commit();

            //return success message
           return redirect()->route('admin.maincategories')->with(['success' => 'تم انشاء القسم بنجاح']);




        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);

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

    public function update($id, MainCotegryRequest $request)
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

