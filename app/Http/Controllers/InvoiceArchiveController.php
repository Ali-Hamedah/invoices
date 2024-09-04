<?php

namespace App\Http\Controllers;

use App\invoices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();
        return view('invoices.archive_invoices', compact('invoices'));
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $id = $request->invoice_id;
        $flight = Invoices::withTrashed()->where('id', $id)->restore();
        session()->flash('success');
        return redirect()->route('invoices.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $invoices = invoices::withTrashed()->where('id', $request->invoice_id)->first();
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/archive');


    }
}
