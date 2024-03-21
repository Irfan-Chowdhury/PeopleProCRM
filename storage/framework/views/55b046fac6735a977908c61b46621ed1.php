<?php $__env->startSection('content'); ?>


    <section>

        <div class="table-responsive">
            <table id="client_invoice-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Invoice')); ?></th>
                    <th><?php echo e(trans('file.Project')); ?></th>
                    <th><?php echo e(trans('file.Total')); ?></th>
                    <th><?php echo e(__('Invoice Date')); ?></th>
                    <th><?php echo e(__('Due Date')); ?></th>
                    <th><?php echo e(trans('file.Status')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
                </thead>

            </table>
        </div>
    </section>

    <script type="text/javascript">
        (function($) {

            "use strict";

            $(document).ready(function () {

                let table_table = $('#client_invoice-table').DataTable({
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
                        url: "<?php echo e(route('clientInvoice')); ?>",
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
                        },
                        // {
                        //     data: 'status',
                        //     name: 'status',
                        //     render: function (data, type, row) {
                        //         if (data == 1) {
                        //             return "<td><div class = 'badge badge-success'><?php echo e(trans('file.Paid')); ?></div></td>";
                        //         }
                        //         else {
                        //             return "<td><div class = 'badge badge-info'><?php echo e(trans('file.Unpaid')); ?></div></td>";
                        //         }
                        //     }
                        // },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
                        },

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
                            'targets': [0, 7],
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
            });

        })(jQuery);
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/resources/views/client/invoice.blade.php ENDPATH**/ ?>