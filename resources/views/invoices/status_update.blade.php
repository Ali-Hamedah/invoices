@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('title')
{{__('dashboard.Change_Payment_Status')}} - {{__('dashboard.Invoice_System_Dashboard')}}
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('dashboard.Invoices')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    {{__('dashboard.Change_Payment_Status')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('Status_Update'))
        <script>
            window.onload = function () {
                notif({
                    msg: "تم تغير  حالة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    <!-- row -->
    <div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('Status_Update', ['id' => $invoices->id]) }}" method="post"
                      enctype="multipart/form-data"
                      autocomplete="off">

                    {{ csrf_field() }}
                    {{-- 1 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">Invoice Number</label>

                            <input type="hidden" name="invoice_id" value="{{ $invoices->id }}">

                            <input type="text" class="form-control" id="inputName" name="invoice_number"
                                   title="Please enter the invoice number" value="{{ $invoices->invoice_number }}" readonly>
                        </div>

                        <div class="col">
                            <label>Invoice Date</label>
                            <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                   type="text" value="{{ $invoices->invoice_Date }}" readonly>
                        </div>

                        <div class="col">
                            <label>Due Date</label>
                            <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                   type="text" value="{{ $invoices->Due_date }}" readonly>
                        </div>

                    </div>

                    {{-- 2 --}}
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">Section</label>
                            <select name="Section" class="form-control SlectBox" readonly>
                                <!--placeholder-->
                                <option value="{{ $invoices->sections->id }}">
                                    {{ $invoices->sections->section_name }}
                                </option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Product</label>
                            <select id="product" name="product" class="form-control" readonly>
                                <option value="{{ $invoices->product }}"> {{ $invoices->product }}</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Collection Amount</label>
                            <input type="text" class="form-control" id="inputName" name="Amount_collection"
                                   value="{{ $invoices->Amount_collection }}"
                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                   readonly>
                        </div>
                    </div>


                    {{-- 3 --}}

                    <div class="row">

                        <div class="col">
                            <label for="inputName" class="control-label">Commission Amount</label>
                            <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                   name="Amount_Commission" title="Please enter the commission amount"
                                   value="{{ $invoices->Amount_Commission }}"
                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                   readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Discount</label>
                            <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                   title="Please enter the discount amount" value="{{ $invoices->Discount }}"
                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                   readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">VAT Rate</label>
                            <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()" readonly>
                                <!--placeholder-->
                                <option value="{{ $invoices->Rate_VAT }}">{{ $invoices->Rate_VAT }}</option>
                                <option value="5%">5%</option>
                                <option value="10%">10%</option>
                            </select>
                        </div>

                    </div>

                    {{-- 4 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">VAT Amount</label>
                            <input type="text" value="{{ $invoices->Value_VAT }}" class="form-control"
                                   id="Value_VAT" name="Value_VAT" readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Total Including VAT</label>
                            <input type="text" value="{{ $invoices->Total }}" class="form-control" id="Total"
                                   name="Total" readonly>
                        </div>
                    </div>

                    {{-- 5 --}}
                    <div class="row">
                        <div class="col">
                            <label for="exampleTextarea">Notes</label>
                            <textarea class="form-control" id="exampleTextarea" name="note" rows="3" readonly>{{ $invoices->note }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="exampleTextarea">Payment Status</label>
                            <select class="form-control" id="Status" name="Status" required>
                                <option selected="true" disabled="disabled">-- Select Payment Status --</option>
                                <option value="Paid">Paid</option>
                                <option value="Partially Paid">Partially Paid</option>
                            </select>
                        </div>

                        <div class="col">
                            <label>Payment Date</label>
                            <input class="form-control fc-datepicker" name="Payment_Date" placeholder="YYYY-MM-DD"
                                   type="text" required>
                        </div>
                    </div>
                    <br>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Update Payment Status</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>


    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

@endsection
