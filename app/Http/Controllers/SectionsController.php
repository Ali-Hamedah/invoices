<?php

namespace App\Http\Controllers;

use App\sections;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:categories', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$sections = sections::all();
        $sections = sections::select(
            'id',
            'section_name',
            'description',
            'created_by'
        )->get();
        return view('sections.sections', compact('sections'));
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
            'section_name' => 'required|unique:sections|max:255',
        ], [

            'section_name.required' => __('validation.required'),
            'section_name.unique' => __('validation.unique'),


        ]);

        sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (Auth::user()->name),

        ]);

        //session()->flash('Add', 'تم اضافة القسم بنجاح ');
        //return redirect('/sections');
        return redirect()->back()->with(['Add' => 'تم اضافه القسم بنجاح ']);
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
     * @param sections $sections
     * @return Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param sections $sections
     * @return Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param sections $sections
     * @return Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
        ], [

            'section_name.required' => __('validation.required'),
            'section_name.unique' => __('validation.unique'),


        ]);

        $id = $request->id;
        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('edit', __('messages.Updated_successfully'));
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param sections $sections
     * @return Response
     */
    public function destroy($id)
    {
        // $id = $request -> id;
        sections::find($id)->delete();
        return redirect()->back()->with(['delete' => __('messages.Delete_successfully')]);
    }
}
