@extends('layout.main')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3>{{__('file.Contract Items')}}</h3></div>
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
                    <th>{{trans('file.Item')}}</th>
                    <th>{{trans('file.Rate')}}</th>
                    <th>{{trans('file.Quantity')}}</th>
                    <th>{{trans('file.Total')}}</th>
                    <th class="not-exported">{{trans('file.Action')}}</th>
                </tr>
            </thead>
            <tbody id="tablecontents"></tbody>
        </table>
    </div>
</div>

@include('crm::sale_section.contracts.contract_item.create-modal')
@include('crm::sale_section.contracts.contract_item.edit-modal')

@endsection


@push('scripts')
<script type="text/javascript">
    let dataTableURL = "{{ route('contracts.items', ['contract' => $contract->id]) }}";
    let storeURL = "{{ route('contracts.items.store', ['contract' => $contract->id]) }}";
    let itemShowURL = "/sales/items/show/";
    var editURL = "{{ url('/sales/contracts')}}/" + "{{ $contract->id }}/edit/" ;
    var updateURL = "{{ url('/sales/contracts')}}/" + "{{ $contract->id }}/update/" ;
    let destroyURL = "{{ url('/sales/contracts')}}/" + "{{ $contract->id }}/destroy/";
    let bulkDeleteURL = '{{ route('contracts.items.bulk_delete', ['contract' => $contract->id]) }}';
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
                        data: 'item',
                        name: 'item',
                    },
                    {
                        data: 'rate',
                        name: 'rate',
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                    },
                    {
                        data: 'total',
                        name: 'total',
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


        $(document).ready(function() {
            $('#submitForm select[name="item_id"]').change(function() {
                let id = $(this).val();
                $.get({
                    url: itemShowURL + id,
                    success: function(response) {
                        console.log(response);
                        $("#submitForm input[name='rate']").val(response.rate);
                        $("#submitForm input[name='unit_type']").val(response.unit_type);

                    }
                });
            });
            $('#updateForm select[name="item_id"]').change(function() {
                let id = $(this).val();
                $.get({
                    url: itemShowURL + id,
                    success: function(response) {
                        console.log(response);
                        $("#updateForm input[name='rate']").val(response.rate);
                        $("#updateForm input[name='unit_type']").val(response.unit_type);

                    }
                });
            });
        });


        let currentModal;
        //--------- Edit -------
        $(document).on('click', '.edit', function() {
            let id = $(this).data("id");
            currentModal = 'edit';
            $.get({
                url: editURL + id,
                success: function(response) {
                    console.log(response);
                    $("#modelId").val(response.id);
                    $("#editModal select[name='item_id']").selectpicker('val',response.item_id);
                    $("#editModal input[name='quantity']").val(response.quantity);
                    $("#editModal input[name='unit_type']").val(response.unit_type);
                    $("#editModal input[name='rate']").val(response.rate);
                    $("#editModal textarea[name='description']").val(response.description);
                    currentModal = '';
                    $('#editModal').modal('show');
                }
            })
        });

    })(jQuery);
</script>

<script type="text/javascript" src="{{ asset('js/common-js/store.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/update.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/delete.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/bulkDelete.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/common-js/alertMessages.js') }}"></script>

@endpush
