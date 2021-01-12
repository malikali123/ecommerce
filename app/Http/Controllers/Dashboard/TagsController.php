<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.tags.index', compact('tags'));

    }

    public function create()
    {
        return view('dashboard.tags.create');


    }

    public function store(TagsRequest $request)
    {
        // return  $request;
        try {

            DB::beginTransaction();
            //validation

            //store

            $tags = Tag::create(['slug' => $request -> slug]);
           // return $tags;
            //save translations

            $tags -> name = $request -> name;
            $tags->save();
            DB::commit();

            //return success message
           return redirect()->route('admin.tags')->with(['success' => 'تم انشاء العلامة(tags) بنجاح']);



        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);

        }





    }

    public function edit($id)
    {
        //get specific category and itis translations
    return    $tags = Tag::find($id);
        if (!$tags)
            return redirect()->route('admin.tags')->with(['error' => 'هذا العلامة غير موجود']);
        return view('dashboard.tags.edit', compact('tags'));
    }

    public function update($id, TagsRequest $request)
    {
        try {
            //validation
            //update database

            $tags = Tag::find($id);
            if (!$tags)
                return redirect()->route('admin.tags')->with(['error' => 'هذا العلامة غير موجود']);

            DB::beginTransaction();

            $tags->update($request->except('_token', 'id'));

            //save translations
            $tags->name = $request->name;
            $tags->save();
            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم التحديث بنجاح']);


        } catch (\Exception $ex) {
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);


        }

    }

    public function distroy($id)
    {

        try {
            //validation
            //update database
            $tags = Tag::orderBy('id', 'DESC')->find($id);
            if (!$tags)
                return redirect()->route('admin.tags')->with(['error' => 'هذا القسم غير موجود']);
            $tags->delete();

            return redirect()->route('admin.tags')->with(['success' => 'تم الحذف بنجاح']);


       } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error' => 'حدث خطا ما الرجاء المحاولة لاحقا']);


      }
    }


}

