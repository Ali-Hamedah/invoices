@extends('layouts.master')
@section('title')
    {{ __('dashboard.Print_Invoice') }} - {{ __('dashboard.Invoice_System_Dashboard') }}
@endsection
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
            #send_Button {
                display: none;
            }
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('dashboard.Invoices') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('dashboard.Print_Invoice') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('success'))
        <script>
            window.onload = function () {
                notif({
                    msg: "{{ __('dashboard.Archive_Success') }}",
                    type: "success"
                })
            }
        </script>
    @endif
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class="main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">{{ __('invoices.Collection_Invoice') }}</h1>
                            <div class="billed-from">
                                <h6>Ali Hamedah, dv</h6>
                                <p>vienna., austria<br>
                                    Tel No: +43 660-9567393<br>
                                    Email: aliali735522@gmail.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">{{ __('invoices.Billed_To') }}</label>
                                <div class="billed-to">
                                    <h6>Juan Dela Cruz</h6>
                                    <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                        Tel No: 324 445-4544<br>
                                        Email: youremail@companyname.com</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">{{ __('invoices.Invoice_Info') }}</label>
                                <p class="invoice-info-row"><span>{{ __('invoices.Invoice_Number') }}</span>
                                    <span>{{ $invoices->invoice_number }}</span></p>
                                <p class="invoice-info-row"><span>{{ __('invoices.Issue_Date') }}</span>
                                    <span>{{ $invoices->invoice_Date }}</span></p>
                                <p class="invoice-info-row"><span>{{ __('invoices.Due_Date') }}</span>
                                    <span>{{ $invoices->Due_date }}</span></p>
                                <p class="invoice-info-row"><span>{{ __('invoices.Section') }}</span>
                                    <span>{{ $invoices->sections->section_name }}</span></p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th class="wd-20p">#</th>
                                    <th class="wd-40p">{{ __('invoices.Product') }}</th>
                                    <th class="tx-center">{{ __('invoices.Collection_Amount') }}</th>
                                    <th class="tx-right">{{ __('invoices.Commission_Amount') }}</th>
                                    <th class="tx-right">{{ __('invoices.Total') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="tx-12">{{ $invoices->product }}</td>
                                    <td class="tx-center">{{ number_format($invoices->Amount_collection, 2) }}</td>
                                    <td class="tx-right">{{ number_format($invoices->Amount_Commission, 2) }}</td>
                                    @php
                                        $total = $invoices->Amount_collection + $invoices->Amount_Commission;
                                    @endphp
                                    <td class="tx-right">{{ $total }}</td>
                                </tr>

                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13">#</label>
                                            <p></p>
                                        </div><!-- invoice-notes -->
                                    </td>
                                    <td class="tx-center">{{ __('invoices.Total') }}</td>
                                    <td class="tx-right">{{ $total }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">{{ __('invoices.Tax_Rate') }}</td>
                                    <td class="tx-right" colspan="2">{{ $invoices->Rate_VAT }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">{{ __('invoices.Discount_Value') }}</td>
                                    <td class="tx-right" colspan="2">{{ $invoices->Discount }}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">{{ __('invoices.Total_Inclusive_Tax') }}</td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold">{{ $invoices->Total }}</h4>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">
                        @can('print_invoice')
                            <button class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                <i class="mdi mdi-printer ml-1"></i> {{ __('dashboard.Print') }}
                            </button>
                        @endcan
                        @can('send_invoice')
                            <a href="{{ route('sendEmail', $invoices->id) }}" id="send_Button"
                               class="btn btn-success float-left mt-3">
                                <i class="mdi mdi-telegram ml-1"></i> {{ __('dashboard.Send_Invoice') }}
                            </a>
                        @endcan
                        @can('export_pdf')
                            <a class="modal-effect btn btn-sm btn-primary"
                               href="{{ url('generate-pdf', $invoices->id) }}"
                               style="color:white"><i class="fas fa-file-download"></i>&nbsp;{{ __('dashboard.Export_PDF') }}</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
