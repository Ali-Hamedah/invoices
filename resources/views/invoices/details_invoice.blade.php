@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">تفاصيل الفاتوره</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style3">


                <div class="text-wrap">

                    <div class="panel panel-primary tabs-style-3">
                        <div class="tab-menu-heading">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs">
                                    <li class=""><a href="#tab11" class="active" data-toggle="tab"><i
                                                class="fa fa-laptop"></i> {{__('invoices.Invoice_Info')}}</a></li>
                                    <li><a href="#tab12" data-toggle="tab"><i class="fa fa-cube"></i> {{__('invoices.Status')}}</a>
                                    </li>
                                    <li><a href="#tab13" data-toggle="tab"><i class="fa fa-cogs"></i> {{__('invoices.Attachments')}}</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab11">
                                    <div class="table-responsive mt-15">

                                        <table class="table table-striped" style="text-align:center">
                                            <tbody>

                                            <tr>
                                                <th scope="row"> {{__('invoices.Invoice_Number')}}</th>
                                                <td>{{ $invoices->invoice_number }}</td>
                                                <th scope="row"> {{__('invoices.Invoice_Date')}}</th>
                                                <td>{{$invoices-> invoice_Date}}</td>
                                                <th scope="row"> {{__('invoices.Due_Date')}}</th>
                                                <td>{{$invoices-> Due_date}}</td>
                                                <th scope="row">{{__('dashboard.Sections')}}</th>
                                                <td>{{$invoices-> sections-> section_name}}</td>
                                            </tr>

                                            <tr>
                                                <th scope="row">{{__('dashboard.Products')}}</th>
                                                <td>{{$invoices-> product}}</td>
                                                <th scope="row">  {{__('invoices.Collection_Amount')}}</th>
                                                <td>{{$invoices-> Amount_collection}}</td>
                                                <th scope="row"> {{__('invoices.Commission_Amount')}}</th>
                                                <td>{{$invoices-> Amount_Commission}}</td>
                                                <th scope="row">{{__('invoices.Discount')}}</th>
                                                <td>{{$invoices-> Discount}}</td>
                                            </tr>


                                            <tr>
                                                <th scope="row"> {{__('invoices.Tax_Rate')}}</th>
                                                <td>{{$invoices-> Rate_VAT}}</td>
                                                <th scope="row"> {{__('invoices.Tax_Value')}}</th>
                                                <td>{{$invoices-> Value_VAT}}</td>
                                                <th scope="row">{{__('invoices.Total_Including_Tax')}} </th>
                                                <td>{{$invoices-> Total}}</td>
                                                <th scope="row"> {{__('invoices.The_current_status')}}</th>

                                                @if($invoices-> Value_Status == 1)
                                                    <td><span
                                                            class="badge badge-pill badge-success">{{$invoices-> Status}}</span>
                                                    </td>
                                                @elseif($invoices-> Value_Status == 2)
                                                    <td><span
                                                            class="badge badge-pill badge-danger">{{$invoices-> Status}}</span>
                                                    </td>
                                                @else
                                                    <td><span
                                                            class="badge badge-pill badge-warning">{{$invoices-> Status}}</span>
                                                    </td>
                                                @endif

                                            </tr>

                                            <tr>
                                                <th scope="row">{{__('invoices.Notes')}}</th>
                                                <td>{{$invoices-> note}}</td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <div class="tab-pane" id="tab12">
                                    <div class="table-responsive mt-15">
                                        <table class="table center-aligned-table mb-0 table-hover"
                                               style="text-align:center">
                                            <thead>
                                            <tr class="text-dark">
                                                <th>#</th>
                                                <th> {{__('invoices.Invoice_Number')}}</th>
                                                <th> {{__('invoices.Product')}}</th>
                                                <th>{{__('invoices.Section')}}</th>
                                                <th> {{__('invoices.Status')}}</th>
                                                <th> {{__('invoices.Payment_date')}}</th>
                                                <th>{{__('invoices.Notes')}}</th>
                                                <th>{{__('invoices.Date_addition')}}</th>
                                                <th>{{__('dashboard.Username')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0; ?>

                                            @foreach($details as $detail)
                                                <?php $i++; ?>
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $detail ->invoice_number }}</td>
                                                    <td>{{ $detail ->product }}</td>
                                                    <td>{{ $invoices ->sections ->section_name }}</td>
                                                    @if($detail-> Value_Status == 1)
                                                        <td><span
                                                                class="badge badge-pill badge-success">{{$detail-> Status}}</span>
                                                        </td>
                                                    @elseif($detail-> Value_Status == 2)
                                                        <td><span
                                                                class="badge badge-pill badge-danger">{{$detail-> Status}}</span>
                                                        </td>
                                                    @else
                                                        <td><span
                                                                class="badge badge-pill badge-warning">{{$detail-> Status}}</span>
                                                        </td>
                                                    @endif

                                                    <td>{{ $detail ->Payment_Date }}</td>
                                                    <td>{{ $detail ->note }}</td>
                                                    <td>{{ $detail ->created_at }}</td>
                                                    <td>{{ $detail ->user }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                                <div class="tab-pane" id="tab13">

                                    <!--المرفقات-->
                                    <div class="card card-statistics">

                                        <div class="card-body">
                                            <p class="text-danger">*  {{__('invoices.Attachment_format')}} pdf, jpeg ,.jpg , png </p>
                                            <h5 class="card-title"> {{__('invoices.Add_attachments')}}</h5>
                                            <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile"
                                                           name="file_name" required>
                                                    <input type="hidden" id="customFile" name="invoice_number"
                                                           value="{{ $invoices->invoice_number }}">
                                                    <input type="hidden" id="invoice_id" name="invoice_id"
                                                           value="{{ $invoices->id }}">
                                                    <label class="custom-file-label" for="customFile">
                                                        {{__('invoices.Select_attachment')}}</label>
                                                </div>
                                                <br><br>
                                                <button type="submit" class="btn btn-primary btn-sm "
                                                        name="uploadedFile">{{__('messages.Confirm')}}
                                                </button>
                                            </form>
                                        </div>


                                        <div class="table-responsive mt-15">
                                            <table class="table center-aligned-table mb-0 table-hover"
                                                   style="text-align:center">
                                                <thead>
                                                <tr class="text-dark">
                                                    <th>#</th>
                                                    <th>  {{__('invoices.File_name')}}</th>
                                                    <th> {{__('dashboard.Username')}}</th>
                                                    <th> {{__('invoices.Date_addition')}}</th>
                                                    <th>{{__('invoices.Notes')}}</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $i = 0; ?>

                                                @foreach($attachments as $attachment)
                                                    <?php $i++; ?>
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $attachment ->file_name }}</td>
                                                        <td>{{ $attachment ->Created_by }}</td>
                                                        <td>{{ $attachment ->created_at }}</td>
                                                        <td colspan="2">

                                                            <a class="btn btn-outline-success btn-sm"
                                                               href="{{ url('View_file') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                               role="button"><i class="fas fa-eye"></i>&nbsp;
                                                               {{__('dashboard.View')}}</a>

                                                            <a class="btn btn-outline-info btn-sm"
                                                               href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                               role="button"><i
                                                                    class="fas fa-download"></i>&nbsp;
                                                                    {{__('dashboard.Download')}}</a>


                                                            <button class="btn btn-outline-danger btn-sm"
                                                                    data-toggle="modal"

                                                                    data-file_name="{{ $attachment->file_name }}"
                                                                    data-invoice_number="{{ $attachment->invoice_number }}"
                                                                    data-id_file="{{ $attachment->id }}"
                                                                    data-target="#delete_file">{{__('dashboard.Delete')}}
                                                            </button>


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
                    </div>

                </div>
            </div>
            <!-- delete -->
            <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> {{__('dashboard.Download')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('delete_file') }}" method="post">

                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p class="text-center">
                                <h6 style="color:red"> {{__('messages.Delete_Confirmation')}}</h6>
                                </p>

                                <input type="hidden" name="id_file" id="id_file" value="">
                                <input type="hidden" name="file_name" id="file_name" value="">
                                <input type="hidden" name="invoice_number" id="invoice_number" value="">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('messages.Cancel')}}</button>
                                <button type="submit" class="btn btn-danger">{{__('messages.Confirm')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /div -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);

        })
    </script>
@endsection
