@extends('crm::lead_section.layout')
@section('lead_details')

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3>{{__('file.Files')}}</h3></div>
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
                    <th>{{trans('file.Description')}}</th>
                    <th>{{__('Date and Time')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody id="tablecontents"></tbody>
        </table>
    </div>
</div>

@include('crm::lead_section.files.create-modal')
{{-- @include('crm::lead_section.files.edit-modal') --}}


@endsection

@push('scripts')
<script type="text/javascript">
    let dataTableURL = "{{ route('lead.files.datatable', ['lead' => $lead->id]) }}";
    let storeURL = "{{ route('lead.files.store', ['lead' => $lead->id]) }}";
    let destroyURL = "{{ url('/leads/details')}}/" + "{{ $lead->id }}/files/destroy/";
    let bulkDeleteURL = '{{ route('lead.files.bulk_delete', ['lead' => $lead->id]) }}';
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
                        data: 'file_title',
                        name: 'file_title'
                    },
                    {
                        data: 'file_description',
                        name: 'file_description',

                    },
                    {
                        data: 'created_at',
                        name: 'created_at',

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
                    $("#modelId").val(response.leadContact.id);
                    $("#editModal input[name='first_name']").val(response.leadContact.first_name);
                    $("#editModal input[name='last_name']").val(response.leadContact.last_name);
                    $("#editModal input[name='email']").val(response.leadContact.email);
                    $("#editModal input[name='phone']").val(response.leadContact.phone);
                    $("#addressEdit").val(response.leadContact.address);
                    $("#editModal input[name='job_title']").val(response.leadContact.job_title);
                    $("#editModal input[name='gender'][value='" + response.leadContact.gender + "']").prop("checked", true);
                    if (response.leadContact.is_primary_contact) {
                        $("#editModal input[name='is_primary_contact']").prop('checked', true);
                    } else {
                        $("#editModal input[name='is_primary_contact']").prop('checked', false);
                    }
                    currentModal = '';
                    $('#editModal').modal('show');
                }
            });
        });

        $(document).on('click', '#bulk_delete', function () {
            var id = [];
            let table = $('#dataListTable').DataTable();
            id = table.rows({selected: true}).ids().toArray();
            console.log(id);

            if (id.length > 0) {
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post({
                            url: bulkDeleteURL,
                            data: {
                                leadIdsArray: id
                            },
                            error: function(response) {
                                console.log(response);
                                let htmlContent = prepareMessage(response);
                                displayErrorMessage(htmlContent);
                            },
                            success: function (response) {
                                console.log(response);
                                displaySuccessMessage(response.success);
                                $('#dataListTable').DataTable().ajax.reload();
                            }
                         });
                    }
                })
            } else {
                Swal.fire({
                    title: "",
                    text: "Please select at least one checkbox.",
                    icon: "warning"
                });
            }
        });

    })(jQuery);
</script>


<script type="text/javascript" src="{{ asset('js/common-js/store.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/update.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/delete.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/bulkDelete.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/alertMessages.js') }}"></script>
@endpush
