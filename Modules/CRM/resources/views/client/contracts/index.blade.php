@extends(isset($client_id) && Auth::user()->role_users_id !==3 ? 'layout.main' : 'layout.client')
@section('content')

@if (isset($client_id) && Auth::user()->role_users_id !==3)
    @include('crm::client.include.header',['clientId'=> $client_id])
@endif

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3>{{__('file.Contracts')}}</h3></div>
    </div>
</div>


<div class="container">
    <div class="table-responsive">
        <table id="dataListTable" class="table ">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Id')}}</th>
                    <th>{{trans('file.Title')}}</th>
                    <th>{{trans('file.Project')}}</th>
                    <th>{{trans('file.Contract Date')}}</th>
                    <th>{{trans('file.Valid Until')}}</th>
                    <th>{{trans('file.Tax')}}</th>
                    <th>{{trans('file.Amount (Including Tax)')}}</th>
                    <th class="not-exported">{{trans('file.Action')}}</th>
                </tr>
            </thead>
            <tbody id="tablecontents"></tbody>
        </table>
    </div>
</div>


@endsection


@push('scripts')
<script type="text/javascript">
    @if(isset($client_id))
        var dataTableURL = "{{ url('/client/contracts/show')}}/" + "{{ $client_id }}" ;
    @else
        let dataTableURL = "{{ route('client.contracts.datatable') }}";
    @endif
</script>

<script type="text/javascript">
    (function($) {
        "use strict";

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var date = $('.date');
            date.datepicker({
                format: '{{ env('Date_Format_JS')}}',
                autoclose: true,
                todayHighlight: true
            });


            let table = $('#dataListTable').DataTable({
                initComplete: function () {
                    this.api().columns([1]).every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });
                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>');
                            $('select').selectpicker('refresh');
                        });
                    });
                },
                responsive: true,
                fixedHeader: {
                    header: true,
                    footer: true
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: dataTableURL,
                },
                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'contract',
                        name: 'contract',
                    },
                    {
                        data: 'title',
                        name: 'title',
                    },
                    {
                        data: 'project',
                        name: 'project',
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
                    },
                    {
                        data: 'tax',
                        name: 'tax',
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ],


                "order": [],
                'language': {
                    'lengthMenu': '_MENU_ {{__("records per page")}}',
                    "info": '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
                    "search": '{{trans("file.Search")}}',
                    'paginate': {
                        'previous': '{{trans("file.Previous")}}',
                        'next': '{{trans("file.Next")}}'
                    }
                },
                'columnDefs': [
                    {
                        "orderable": false,
                        'targets': [0,6]
                    },
                    {
                        'render': function (data, type, row, meta) {
                            if (type == 'display') {
                                data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                            }

                            return data;
                        },
                        'checkboxes': {
                            'selectRow': true,
                            'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                        },
                        'targets': [0]
                    }
                ],
                'select': {style: 'multi', selector: 'td:first-child'},
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: '<"row"lfB>rtip',
                buttons: [
                    {
                        extend: 'pdf',
                        text: '<i title="export to pdf" class="fa fa-file-pdf-o"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'csv',
                        text: '<i title="export to csv" class="fa fa-file-text-o"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i>',
                        columns: ':gt(0)'
                    },
                ],
            });
            new $.fn.dataTable.FixedHeader(table);
        });

    })(jQuery);
</script>

@endpush
