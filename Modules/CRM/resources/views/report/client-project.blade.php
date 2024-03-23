@extends('layout.main')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <div class="wrapper count-title text-center mb-30px ">
                    <div class="box mb-4">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{__('Client Project Report')}} <span id="details_month_year"></span> </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6>
                        <label for=""><b>Client</b></label>
                        <select name="client_id" id="client_id" class="form-control selectpicker"
                        data-live-search="true" data-live-search-style="contains" title="{{__('Select Client')}}...">
                            @foreach ($clients as $item)
                                <option value="{{ $item->id }}"> {{ $item->first_name.' '.$item->last_name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ml-2 col-md-6>
                        <label for=""><b>Project</b></label>
                        <select name="project_id" id="project_id" class="form-control selectpicker"
                        data-live-search="true" data-live-search-style="contains" title="Select Project">
                            @foreach ($projects as $item)
                                <option value="{{ $item->id }}"> {{ $item->title }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-responsive">
            <table id="dataListTable" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Client')}}</th>
                    <th>{{__('Project Name')}}</th>
                    <th>{{trans('file.Priority')}}</th>
                    <th>{{__('Assigned Employees')}}</th>
                    <th>{{__('Start Date')}}</th>
                    <th>{{__('End Date')}}</th>
                    <th>{{__('Progress')}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script type="text/javascript">
    let dataTableURL = "{{ route('report.client-project') }}";
</script>

<script type="text/javascript">
    (function($) {

        $(document).ready(function () {

            $('.js-example-responsive').select2({
                placeholder: '{{__('')}}',
                width: 'resolve',
                theme: "classic",
            });

            let date = $('.date');
            date.datepicker({
                format: '{{ env('Date_Format_JS')}}',
                autoclose: true,
                todayHighlight: true
            });


            var table = $('#dataListTable').DataTable({
                initComplete: function () {
                    this.api().columns([1]).every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
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
                    data: function (d) {
                        d.client_id = $('#client_id').val()
                        d.project_id = $('#project_id').val()
                    }
                },

                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'client',
                        name: 'client',
                    },
                    {
                        data: 'summary',
                        name: 'summary'

                    },
                    {
                        data: 'project_priority',
                        name: 'project_priority',
                    },
                    {
                        data: 'assigned_employee',
                        name: 'assigned_employee',
                        render: function (data) {
                            return data.join("<br>");
                        }
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
                        data: 'project_progress',
                        name: 'project_progress',
                        render: function (data) {
                            if (data !== null) {
                                if (data > 70) {
                                    return data + '% complete<div class="progress"><div class="progress-bar green" role="progressbar" style="width: ' + data + '%" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                } else if (data > 50) {
                                    return data + '% complete<div class="progress"><div class="progress-bar yellow" role="progressbar" style="width: ' + data + '%" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                } else {
                                    return data + '% complete<div class="progress"><div class="progress-bar red" role="progressbar" style="width: ' + data + '%" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100"></div></div>'
                                }
                            } else {
                                return 0 + '% complete'
                            }
                        }
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
                        'targets': [0, 6],
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

            $('#client_id').change(function(){
                table.draw();
            });
            $('#project_id').change(function(){
                table.draw();
            });
        });

    })(jQuery);
</script>
@endpush
