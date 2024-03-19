<?php $__env->startSection('content'); ?>


    <section>

        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="wrapper count-title text-center mb-30px ">
                        <div class="box mb-4">
                            <div class="box-header with-border">
                                <h3 class="box-title"> <?php echo e(__('Invoice Report')); ?> <span id="details_month_year"></span> </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header py-3">
                    <div class="row">

                        <div class="col-md-4">
                            <label for=""><b>Project</b></label>
                            <select name="project_id" id="project_id" class="form-control">
                                <option value="">-- Select Project --</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"><?php echo e($item->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for=""><b>Status</b></label>
                            <select name="status" id="status" class="form-control">
                                <option value="">-- Select Status --</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
                            </select>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table id="datatable" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Invoice')); ?></th>
                    <th><?php echo e(trans('file.Project')); ?></th>
                    <th><?php echo e(trans('file.Total')); ?></th>
                    <th><?php echo e(__('Invoice Date')); ?></th>
                    <th><?php echo e(__('Due Date')); ?></th>
                    <th><?php echo e(trans('file.Status')); ?></th>
                </tr>
                </thead>

            </table>
        </div>
    </section>

    <script type="text/javascript">
        (function($) {

            "use strict";

            $(document).ready(function () {

                let table_table = $('#datatable').DataTable({
                    initComplete: function () {
                        this.api().columns([1]).every(function () {
                            let column = this;
                            let select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    let val = $.fn.dataTable.util.escapeRegex(
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
                        url: "<?php echo e(route('report.invoice')); ?>",
                        data: function (d) {
                            d.project_id = $('#project_id').val()
                            d.status = $('#status').val()
                        }
                    },

                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'invoice_number',
                            name: 'invoice_number',
                        },
                        {
                            data: 'project',
                            name: 'project',
                        },
                        {
                            data: 'grand_total',
                            name: 'grand_total',
                            render: function (data, type, row) {
                                return '$' + data
                            }

                        },
                        {
                            data: 'invoice_date',
                            name: 'invoice_date',
                        },
                        {
                            data: 'invoice_due_date',
                            name: 'invoice_due_date',
                        },
                        {
                            data: 'payment_status',
                            name: 'payment_status',
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
                new $.fn.dataTable.FixedHeader(table_table);

                $('#status').change(function(){
                    table_table.draw();
                });
                $('#project_id').change(function(){
                    table_table.draw();
                });
            });

        })(jQuery);
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/Modules/CRM/resources/views/report/invoice.blade.php ENDPATH**/ ?>