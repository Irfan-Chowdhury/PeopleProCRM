<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3><?php echo e(__('file.Contracts')); ?></h3></div>
        <div class="card-header">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> <?php echo e(__('file.Add New')); ?></button>
            <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>                </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="table-responsive">
        <table id="dataListTable" class="table ">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Id')); ?></th>
                    <th><?php echo e(trans('file.Title')); ?></th>
                    <th><?php echo e(trans('file.Project')); ?></th>
                    <th><?php echo e(trans('file.Contract Date')); ?></th>
                    <th><?php echo e(trans('file.Valid Until')); ?></th>
                    <th><?php echo e(trans('file.Tax')); ?></th>
                    <th><?php echo e(trans('file.Total')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
                </tr>
            </thead>
            <tbody id="tablecontents"></tbody>
        </table>
    </div>
</div>

<?php echo $__env->make('crm::sale_section.contracts.create-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('crm::sale_section.contracts.edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    let dataTableURL = "<?php echo e(route('contracts.datatable')); ?>";
    let storeURL = "<?php echo e(route('contracts.store')); ?>";
    var editURL = "<?php echo e(url('sales/contracts/edit')); ?>/";
    let updateURL = "<?php echo e(url('sales/contracts/update')); ?>/";
    let destroyURL = "<?php echo e(url('sales/contracts/destroy')); ?>/";
    let bulkDeleteURL = "<?php echo e(route('contracts.bulk_delete')); ?>";


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
                format: '<?php echo e(env('Date_Format_JS')); ?>',
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
                    'lengthMenu': '_MENU_ <?php echo e(__("records per page")); ?>',
                    "info": '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
                    "search": '<?php echo e(trans("file.Search")); ?>',
                    'paginate': {
                        'previous': '<?php echo e(trans("file.Previous")); ?>',
                        'next': '<?php echo e(trans("file.Next")); ?>'
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


<script type="text/javascript" src="<?php echo e(asset('js/common-js/store.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/common-js/update.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/common-js/delete.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/common-js/bulkDelete.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/common-js/alertMessages.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/sale_section/contracts/index.blade.php ENDPATH**/ ?>