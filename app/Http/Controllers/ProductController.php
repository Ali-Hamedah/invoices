<?php

namespace App\Http\Controllers;

use App\product;
use App\sections;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:المنتجات', ['only' => ['index']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sections = sections::all();
        $products = product::all();
        return view('product.product', compact('sections', 'products'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Product_name' => 'required|unique:products|max:255',
        ], [

            'Product_name.required' => 'يرجي ادخال اسم القسم',
            'Product_name.unique' => 'اسم القسم مسجل مسبقا',


        ]);

        product::create([
            'Product_name' => $request->Product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param product $product
     * @return Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param product $product
     * @return Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param product $product
     * @return Response
     */
    public function update(Request $request)
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;

        $products = product::findOrFail($request->pro_id);

        $products->update([
            'Product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('success', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param product $product
     * @return Response
     */
    public function destroy(Request $request)
    {
        $products = product::findOrFail($request->pro_id);
        $products->delete();
        session()->flash('success', 'تم حذف المنتج بنجاح');
        return back();
    }
}
