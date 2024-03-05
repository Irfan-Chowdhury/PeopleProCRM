@extends('layout.main')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3>{{__('file.Contracts')}}</h3></div>
        <div class="card-header">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> {{__('file.Add New')}}</button>
            <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i class="fa fa-minus-circle"></i> {{__('Bulk delete')}}</button>                </div>
        </div>
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
                    <th class="not-exported">{{trans('file.Action')}}</th>
                </tr>
            </thead>
            <tbody id="tablecontents"></tbody>
        </table>
    </div>
</div>

@include('crm::sale_section.contracts.create-modal')

@include('crm::sale_section.contracts.edit-modal')


{{-- //
    let destroyURL = '/prospects/proposals/destroy/';
    let bulkDeleteURL = '{{route('prospects.proposals.bulk_delete')}}';

    --}}


@endsection


@push('scripts')
<script type="text/javascript">
    let dataTableURL = "{{ route('contracts.datatable') }}";
    let storeURL = "{{ route('contracts.store')}}";
    var editURL = "{{ url('sales/contracts/edit')}}/";
    let updateURL = "{{ url('sales/contracts/update')}}/";
    let destroyURL = "{{ url('sales/contracts/destroy')}}/";
    let bulkDeleteURL = "{{route('contracts.bulk_delete')}}";


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

            $('#submitForm select[name="candidate"]').change(function() {
                var selectedOption = $(this).find(':selected');
                var type = selectedOption.data('type');
                var id = selectedOption.data('id');

                $('#submitForm input[name="candidate_type"]').val(type);
                $('#submitForm input[name="candidate_id"]').val(id);
            });
            $('#updateForm select[name="candidate"]').change(function() {
                var selectedOption = $(this).find(':selected');
                var type = selectedOption.data('type');
                var id = selectedOption.data('id');

                $('#updateForm input[name="candidate_type"]').val(type);
                $('#updateForm input[name="candidate_id"]').val(id);
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

        let currentModal;
        // //--------- Edit -------
        $(document).on('click', '.edit', function() {
            let id = $(this).data("id");
            currentModal = 'edit';

            $.get({
                url: editURL + id,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $("#modelId").val(response.contract.id);
                    $("#editModal input[name='title']").val(response.contract.title);
                    $("#editModal input[name='start_date']").val(response.contract.start_date);
                    $("#editModal input[name='end_date']").val(response.contract.end_date);

                    if (response.contract.client_id) {
                        $("#editModal input[name='candidate_type']").val('client');
                        $("#editModal input[name='candidate_id']").val(response.contract.client_id);
                        $("#editModal select[name='candidate']").selectpicker('val',response.contract.client_id);
                    }else{
                        $("#editModal input[name='candidate_type']").val('lead');
                        $("#editModal input[name='candidate_id']").val(response.contract.lead_id);
                        $("#editModal select[name='candidate']").selectpicker('val',response.contract.lead_id);
                    }

                    $("#editModal select[name='project_id']").selectpicker('val', response.contract.project_id);
                    $("#editModal select[name='tax_type_id']").selectpicker('val', response.contract.tax_type_id);
                    $("#editModal textarea[name='note']").val(response.contract.note);
                    $('.selectpicker').selectpicker('refresh');
                    currentModal = '';
                    $('#editModal').modal('show');
                }
            });
        });

    })(jQuery);
</script>


<script type="text/javascript" src="{{ asset('js/common-js/store.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/update.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/delete.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/bulkDelete.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/alertMessages.js') }}"></script>
@endpush
