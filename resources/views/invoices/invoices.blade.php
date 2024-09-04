@extends('layouts.master')
@section('title')
{{__('dashboard.Invoice_System_Dashboard')}} -  {{__('dashboard.Invoice_List')}}
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{__('dashboard.Invoices')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('dashboard.Invoice_List')}}</span>
            </div>
        </div>
    </div>


    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function () {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('Status_Update'))
        <script>
            window.onload = function () {
                notif({
                    msg: "تم تحديث  بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('success'))
        <script>
            window.onload = function () {
                notif({
                    msg: "تم استعادة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif
    @if (session()->has('SendEmail'))
        <script>
            window.onload = function () {
                notif({
                    msg: "تم ارسال الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    <!-- row -->
    <div class="row">
        <!-- row opened -->
        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    @can('اضافة فاتورة')
                        <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                class="fas fa-plus"></i>&nbsp;   {{__('dashboard.Add_Invoice')}}</a>
                    @endcan
                    @can('تصدير EXCEL')
                        <a class="modal-effect btn btn-sm btn-primary" href="{{ url('export_invoices') }}"
                           style="color:white"><i class="fas fa-file-download"></i>&nbsp;  {{__('dashboard.Export_to_EXCEL')}}</a>
                    @endcan

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0"> {{__('invoices.Invoice_Number')}}</th>
                                <th class="border-bottom-0"> {{__('invoices.Invoice_Date')}}</th>
                                <th class="border-bottom-0"> {{__('invoices.Due_Date')}}</th>
                                <th class="border-bottom-0">{{__('invoices.Product')}}</th>
                                <th class="border-bottom-0">{{__('invoices.Section')}}</th>
                                <th class="border-bottom-0">{{__('invoices.Discount')}}</th>
                                <th class="border-bottom-0"> {{__('invoices.Tax_Rate')}}</th>
                                <th class="border-bottom-0"> {{__('invoices.Tax_Value')}}</th>
                                <th class="border-bottom-0"{{__('invoices.Total')}}</th>
                                <th class="border-bottom-0"><{{__('invoices.Status')}}th>
                                <th class="border-bottom-0">{{__('invoices.Notes')}}</th>
                                <th class="border-bottom-0">{{__('invoices.Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                            @foreach ($invoices as $invoice)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice-> invoice_Date }}</td>
                                    <td>{{ $invoice-> Due_date }}</td>
                                    <td>{{ $invoice->product }}</td>


                                    <td>

                                        <a href="{{route('InvoicesDetails', $invoice -> id )}}"
                                           class="btn btn-link btn-sm"
                                           role="button">{{$invoice-> sections-> section_name}}</a>
                                    </td>


                                    <td>{{ $invoice-> Discount }}</td>
                                    <td>{{ $invoice->Value_VAT }}</td>
                                    <td>{{ $invoice-> Rate_VAT }}</td>
                                    <td>{{ $invoice->Total }}</td>
                                    <td>
                                        @if ($invoice->Value_Status == 1)
                                            <span class="text-success">{{ $invoice->Status }}</span>
                                        @elseif($invoice->Value_Status == 2)
                                            <span class="text-danger">{{ $invoice->Status }}</span>
                                        @else
                                            <span class="text-warning">{{ $invoice->Status }}</span>
                                        @endif

                                    </td>
                                    <td>{{ $invoice-> note }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-primary btn-sm"
                                                    data-toggle="dropdown" type="button">{{__('invoices.Actions')}}<i
                                                    class="fas fa-caret-down ml-1"></i></button>
                                            <div class="dropdown-menu tx-13">
                                                @can('تعديل الفاتورة')
                                                    <a class="dropdown-item"
                                                       href=" {{ route('edit_invoice', ['id' => $invoice->id])}}"><i
                                                            class="text-primary fas fa-edit"></i> {{__('dashboard.Edit_Invoice')}}</a>
                                                @endcan
                                                @can('تغير حالة الدفع')
                                                    <a class="dropdown-item"
                                                       href="{{ URL::route('Status_show', [$invoice->id]) }}"><i
                                                            class=" text-success fas
                                                                         fa-money-bill"></i>&nbsp;&nbsp;
                                                                         {{__('dashboard.Change_Payment_Status')}}
                                                        </a>
                                                @endcan
                                                @can('ارشفة الفاتورة')
                                                    <a class="dropdown-item" href="#"
                                                       data-invoice_id="{{ $invoice->id }}"
                                                       data-invoice_number="{{ $invoice->invoice_number }}"
                                                       data-toggle="modal" data-target="#Transfer_invoice"><i
                                                            class="text-warning fas fa-archive"></i>&nbsp;&nbsp;
                                                            {{__('dashboard.Archive_Invoice')}} 
                                                    </a>
                                                @endcan
                                                @can('طباعةالفاتورة')
                                                    <a class="dropdown-item" href="Print_invoice/{{ $invoice->id }}"><i
                                                            class="text-success fas fa-print"></i>&nbsp;&nbsp;
                                                            {{__('dashboard.Print_Invoice')}}
                                                    </a>
                                                @endcan
                                                @can('حذف الفاتورة')
                                                    <a class="dropdown-item" href="#"
                                                       data-invoice_id="{{ $invoice->id }}"
                                                       data-invoice_number="{{ $invoice->invoice_number }}"
                                                       data-toggle="modal" data-target="#delete_invoice"><i
                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;
                                                            {{__('dashboard.Delete_Invoice')}}</a>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->

    <!-- delete -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('dashboard.Delete_Invoice')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="invoices/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>{{__('messages.Delete_Confirmation')}} </p><br>
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.Cancel')}}</button>
                        <button type="submit" class="btn btn-danger">{{__('messages.Confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ارشيف الفاتورة -->
    <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{__('dashboard.Archive_Invoice')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                </div>
                <div class="modal-body">
                    {{__('messages.Archive_Confirmation')}}
                    <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    <input type="hidden" name="id_page" id="id_page" value="2">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.Cancel')}}</button>
                    <button type="submit" class="btn btn-success">{{__('messages.Confirm')}}</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <!-- row closed -->

    <!-- Container closed -->

    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>

        //Delete
        $('#delete_invoice').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)

            modal.find('.modal-body #invoice_id').val(invoice_id);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>


    <script>
        $('#Transfer_invoice').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>

@endsection
