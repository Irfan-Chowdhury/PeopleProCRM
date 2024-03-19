<?php $__env->startSection('lead_details'); ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3><?php echo e(__('file.Notes')); ?></h3></div>
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
                    <th><?php echo e(trans('file.Title')); ?></th>
                    <th><?php echo e(trans('file.Note')); ?></th>
                    <th><?php echo e(trans('file.Created At')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
                </tr>
            </thead>
            <tbody id="tablecontents"></tbody>
        </table>
    </div>
</div>

<?php echo $__env->make('crm::lead_section.notes.create-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('crm::lead_section.notes.edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    let dataTableURL = "<?php echo e(route('lead.notes.datatable', ['lead' => $lead->id])); ?>";
    let storeURL = "<?php echo e(route('lead.notes.store', ['lead' => $lead->id])); ?>";
    var editURL = "<?php echo e(url('/leads/details')); ?>/" + "<?php echo e($lead->id); ?>/notes/edit/" ;
    var updateURL = "<?php echo e(url('/leads/details')); ?>/" + "<?php echo e($lead->id); ?>/notes/update/" ;
    let destroyURL = "<?php echo e(url('/leads/details')); ?>/" + "<?php echo e($lead->id); ?>/notes/destroy/";
    let bulkDeleteURL = '<?php echo e(route('lead.notes.bulk_delete', ['lead' => $lead->id])); ?>';
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
                        data: 'note',
                        name: 'note',
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
                        'targets': [0,2]
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
                    $("#modelId").val(response.leadNote.id);
                    $("#editModal input[name='title']").val(response.leadNote.title);
                    $("#noteEdit").val(response.leadNote.note);
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

<?php echo $__env->make('crm::lead_section.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/Modules/CRM/resources/views/lead_section/notes/index.blade.php ENDPATH**/ ?>