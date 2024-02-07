@extends('crm.lead_section.layout')
@section('lead_details')

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3>{{__('file.Task')}}</h3></div>
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
                    <th>{{trans('file.Title')}}</th>
                    <th>{{trans('file.Start Date')}}</th>
                    <th>{{trans('file.End Date')}}</th>
                    <th>{{trans('file.Assigned To')}}</th>
                    <th>{{trans('file.Status')}}</th>
                    <th class="not-exported">{{trans('file.Action')}}</th>
                </tr>
            </thead>
            <tbody id="tablecontents"></tbody>
        </table>
    </div>
</div>

@include('crm::lead_section.task.create-modal')
@include('crm::lead_section.task.edit-modal')


@endsection

@push('scripts')
<script type="text/javascript">
    let dataTableURL = "{{ route('lead.task.datatable', ['lead' => $lead->id]) }}";
    let storeURL = "{{ route('lead.task.store', ['lead' => $lead->id]) }}";
    var editURL = "{{ url('/leads/details')}}/" + "{{ $lead->id }}/task/edit/" ;
    var updateURL = "{{ url('/leads/details')}}/" + "{{ $lead->id }}/task/update/" ;
    let destroyURL = "{{ url('/leads/details')}}/" + "{{ $lead->id }}/task/destroy/";
    let bulkDeleteURL = '{{ route('lead.task.bulk_delete', ['lead' => $lead->id]) }}';
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
                        data: 'title',
                        name: 'title',
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
                        data: 'assigned_to',
                        name: 'assigned_to',
                    },
                    {
                        data: 'status',
                        name: 'status',
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
                        'targets': [0,4]
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
                    $("#modelId").val(response.leadTask.id);
                    $("#editModal input[name='title']").val(response.leadTask.title);
                    $("#pointsEdit").selectpicker('val', response.leadTask.points);
                    $("#descriptionEdit").val(response.leadTask.description);
                    $('#employeeIdEdit').selectpicker('val', response.leadTask.employee_id);
                    $("#statusEdit").selectpicker('val', response.leadTask.status);
                    $("#priorityEdit").selectpicker('val', response.leadTask.priority);
                    $("#labelsEdit").selectpicker('val', response.leadTask.labels);
                    $("#editModal input[name='start_date']").val(response.leadTask.start_date);
                    $("#editModal input[name='end_date']").val(response.leadTask.end_date);

                    $('select[name="collaborator_employee_ids[]"]').val(null);
                    var selectedCollaboratorIds = response.leadTask.collaborator_employee_ids
                    $('#editModal select[name="collaborator_employee_ids[]"] option').each(function() {
                        var optionValue = $(this).val();
                        if (selectedCollaboratorIds.indexOf(optionValue.toString()) !== -1) {
                            $(this).prop('selected', true);
                        }
                    });
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
