<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\invoice_attachments;
use App\invoices;
use App\invoices_detalis;
use App\Notifications\AddInvoice;
use App\Notifications\SendEmail;
use App\product;
use App\sections;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public $validatedData;

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'invoice_number' => 'required|unique:invoices,invoice_number|max:255',
            'product' => 'required',
            'invoice_Date' => 'required',
            'Due_date' => 'required',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
        ], [
            'invoice_number.required' => 'يرجي ادخال رقم الفاتورة',
            'invoice_number.unique' => 'رقم الفاتورة مسجل مسبقا',
            'invoice_Date.required' => 'يرجي ادخال تاريخ الفاتورة',
            'Due_date.required' => 'يرجي ادخال تاريخ الاستحقاق',
            'product.required' => 'يرجي ادخال اسم المنتج',
            'Amount_collection.required' => 'يرجي ادخال مبلغ التحصيل',
            'Amount_Commission.required' => 'يرجي ادخال مبلغ العمولة',
        ]);

        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'Unpaid',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_detalis::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'Unpaid',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::User()->name),

        ]);


        if ($request->hasFile('pic')) {

            $invoice_id = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        // //send email
        // $user = User::first();
        // Notification::send($user, new AddInvoice($invoice_id));

        //notification
        //$user = User::find(Auth::user()->id); // اشعار للشخص الذي عمل الفاتورة فقط
      
        $invoices = invoices::latest()->first();
       // إرسال إشعار للمستخدمين
       $users = User::all(); // جميع المستخدمين
       foreach ($users as $user) {
           // إرسال الإشعار لكل مستخدم
           Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));
       }

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $sections = sections::all();
        $products = product::all();
        return view('invoices.add_invoice', compact('sections', 'products'));
    }

    /**
     * Display the specified resource.
     *
     * @param invoices $invoices
     * @return Response
     */
    public function show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param invoices $invoices
     * @return Response
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice', compact('invoices', 'sections'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param invoices $invoices
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $Details = invoice_attachments::where('invoice_id', $id)->first();

        $id_page = $request->id_page;


        if (!$id_page == 2) {

            if (!empty($Details->invoice_number)) {

                Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
            }

            $invoices->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');

        } else {

            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect()->route('archive.index');
        }


        ////////////////////////////////////////////////
        /// هذا كود حذف المواقت الارشفه softDelete
        /// if (!empty($Details->invoice_number)) {
        //
        //                $invoices->delete();
        //                session()->flash('delete_invoice');
        //                return redirect('/invoices');
        //
        //            }
        //        Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);

    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

    public function Status_Update($id, Request $request)
    {

        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'Paid') {

            //تحديث في جدول الفواتير الاب
            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            //ادخال بيانات جديده في جدول الديتلز
            invoices_detalis::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            //تحديث في جدول الفواتير الاب
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            //ادخال بيانات جديده في جدول الديتلز
            invoices_detalis::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect()->route('invoices.index');


    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param invoices $invoices
     * @return Response
     */
    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id,);

        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'Unpaid',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        $invoices_detalis = invoices_detalis::findOrFail($request->invoice_id,);
        $invoices_detalis->update([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'Unpaid',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::User()->name),

        ]);

        session()->flash('Add', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    public function Invoice_Paid()
    {
        $invoices = Invoices::where('Value_Status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }

    public function Invoice_unPaid()
    {
        $invoices = Invoices::where('Value_Status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = Invoices::where('Value_Status', 3)->get();
        return view('invoices.invoices_Partial', compact('invoices'));
    }

    public function Print_invoice($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.print_invoice', compact('invoices'));

    }

    public function sendEmail(Request $request)
    {
        $invoice_id = $request->id;
        //send email
        $user = User::first();
        Notification::send($user, new SendEmail($invoice_id));

        session()->flash('SendEmail');
        return redirect()->route('/invoices');
    }


    public function export()
    {
        return Excel::download(new InvoicesExport, 'users.xlsx');
    }

    public function pdfjj($id)
    {
        $invoices = invoices::first();
        $data = ['title' => 'Welcome to ItSolutionStuff.com'];
        $pdf = PDF::loadView('invoices.pdf', $data, compact('invoices'));

        return $pdf->download('itsolutionstuff.pdf');
    }

    public function pdf($id)
    {
        $invoices = invoices::findOrFail($id);
        return view('invoices.pdf', compact('invoices'));
    }

    public function MarkAsRead_all(Request $request)
    {

        $userUnreadNotification = auth()->user()->unreadNotifications;

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }


    }


}
