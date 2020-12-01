<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

use Validator;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_paginate = Product::orderBy('created_at', 'asc')->Paginate(5);
        $binding = [
            'title' => '商品管理',
            'products' => $product_paginate,
        ];
        return view('admin.index', $binding);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required',
            'photo.*' => 'required|mimes:jpg,jpeg,png,bmp|max:20000',
            'title' => ['required','string', 'min:1','max:64'],
            'sort' => ['required', 'min:1','max:5'],
            'description' => ['required','string','between:1, 2000'],
            'price' => ['required', 'numeric', 'between:1, 99999'],
            'inventory' =>['required', 'numeric', 'between:1, 999'],
            'type' => ['required', 'in:0,1'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()]);
        } else {
            $input=$request->all();
            $file_patch_json=array();
            $number=1;
            foreach ($input['photo'] as $file) {
                $file_extension = $file->getClientOriginalExtension(); //取得副檔名
                $file_name = uniqid() . '.' . $file_extension;
                $file_relative_path = 'image/' . $file_name;
                $file_path = public_path($file_relative_path);
                $file_patch_json+=array('url'.$number => $file_relative_path);
                $number++;
                $image = Image::make($file)->fit(450, 450)->save($file_path);
            }
            $input['photo']= json_encode($file_patch_json);
            $product = Product::create($input);
            return response()->json(['success' => '新增商品儲存成功'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Product::where('id', $id)->first();
        if ($products!==null) {
            $binding = [
                'title' => '商品編輯',
                'products' => $products,
            ];
            return view('admin.editProduct', $binding);
        } else {
            return response('404 Not Found', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $validator = Validator::make($request->all(), [
            'photo.*' => 'mimes:jpg,jpeg,png,bmp|max:20000',
            'title' => ['required','string', 'min:1','max:64'],
            'sort' => ['required', 'min:1','max:5'],
            'description' => ['required','string','between:1, 2000'],
            'price' => ['required', 'numeric', 'between:1, 99999'],
            'inventory' =>['required', 'numeric', 'between:1, 999'],
            'type' => ['required', 'in:0,1'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->first()]);
        } else {
            $input=$request->all();
            if (isset($input['photo'])) {
                $file_patch_json=array();
                $number=1;
                foreach ($input['photo'] as $file) {
                    $file_extension = $file->getClientOriginalExtension(); //取得副檔名
                    $file_name = uniqid() . '.' . $file_extension;
                    $file_relative_path = 'image/' . $file_name;
                    $file_path = public_path($file_relative_path);
                    $file_patch_json+=array('url'.$number => $file_relative_path);
                    $number++;
                    $image = Image::make($file)->fit(450, 450)->save($file_path);
                }
                $input['photo']=$file_patch_json;
            } else {
                unset($input['photo']);
            }
            unset($input['_method']);
            $product = Product::where('id', $id)
                    ->update($input);
            return response()->json(['success' => '商品資訊編輯成功'], 200);
        }
        // $input=$request->all();

        // return dd($input);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
