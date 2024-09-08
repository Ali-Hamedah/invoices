<?php

namespace App\Http\Controllers;

use App\invoices;
use App\invoices_detalis;
use App\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoicesDetalisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @param invoices_detalis $invoices_detalis
     * @return Response
     */
    public function show(invoices_detalis $invoices_detalis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param invoices_detalis $invoices_detalis
     * @return Response
     */
    public function edit($id, $notification_id)
    {

     
        $invoices = invoices::where('id', $id)->first();
        $details = invoices_detalis::where('id_Invoice', $id)->get();
        $attachments = invoice_attachments::where('invoice_id', $id)->get();
           // جلب الإشعار حسب المعرف الخاص به
      $notification = Auth::user()->notifications()->where('id', $notification_id)->first();

      // إذا كان الإشعار موجودًا، نقوم بتحديث حالته إلى "مقروء"
      if ($notification) {
          $notification->markAsRead();
      }
        return view('invoices.details_invoice', compact('invoices', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param invoices_detalis $invoices_detalis
     * @return Response
     */
    public function update(Request $request, invoices_detalis $invoices_detalis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param invoices_detalis $invoices_detalis
     * @return Response
     */
    public function destroy(Request $request)
    {
        $invoices = invoice_attachments::findOrFail($request->id_file,);
        $invoices->delete();


        //$path = public_path('Attachments');
        //$path2 = realpath('invoice_number');
        //$files = File::allFiles($path);

        //return dd($files);

        //if(count($files)==1){
        // Storage::disk('public_uploads')->deleteDirectory($request->invoice_number);
        //session()->flash('delete', 'تم حذف المرفق بنجاح');
        //return back();

        //}

        // else
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();


    }

    public function open_file($invoice_number, $file_name)
    {

        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
        return response()->file($files);
    }

    public function get_file($invoice_number, $file_name)

    {
        $contents = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
        return response()->download($contents);
    }

}
