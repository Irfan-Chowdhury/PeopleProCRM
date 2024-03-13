<?php $__env->startSection('content'); ?>


    <section>

        <div class="container-fluid"><span id="general_result"></span></div>


        <div class="container-fluid">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-invoice')): ?>
                <a class="btn btn-info" id="create_record" href="<?php echo e(route('invoices.create')); ?>"><i class="fa fa-plus"></i> <?php echo e(__('Add Invoice')); ?></a>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table id="invoice-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Invoice')); ?>#</th>
                    <th><?php echo e(trans('file.Project')); ?></th>
                    <th><?php echo e(trans('file.Total')); ?></th>
                    <th><?php echo e(__('Invoice Date')); ?></th>
                    <th><?php echo e(__('Due Date')); ?></th>
                    <th><?php echo e(trans('file.Status')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                    <th><?php echo e(__('Change Status')); ?></th>
                </tr>
                </thead>

            </table>
        </div>
    </section>


    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title"><?php echo e(trans('file.Confirmation')); ?></h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center"><?php echo e(__('Are you sure you want to remove this data?')); ?></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger"><?php echo e(trans('file.OK')); ?>'
                    </button>
                    <button type="button" class="close btn-default"
                            data-dismiss="modal"><?php echo e(trans('file.Cancel')); ?></button>
                </div>
            </div>
        </div>
    </div>






<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    (function($) {
        "use strict";

        $(document).ready(function () {


            var table_table = $('#invoice-table').DataTable({
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
                    url: "<?php echo e(route('invoices.index')); ?>",
                },

                columns: [
                    {
                        data: 'id',
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
                            if("<?php echo e(config('variable.currency_format')=='suffix'); ?>") {
                                return data + "<?php echo e(config('variable.currency')); ?>"
                            }
                            else {
                                return  "<?php echo e(config('variable.currency')); ?>" + data
                            }
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
                        data: 'status',
                        name: 'status',
                        render: function (data, type, row) {
                            if (data == 0) {
                                return "<td><div class = 'badge badge-info'><?php echo e(trans('file.Unpaid')); ?></div></td>";
                            } if (data == 1) {
                                return "<td><div class = 'badge badge-success'><?php echo e(trans('file.Paid')); ?></div></td>";
                            }
                            else {
                                return "<td><div class = 'badge badge-success'><?php echo e(trans('file.Sent')); ?></div></td>";
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                    {
                        data: 'change_status',
                        name: 'change_status',
                        render: function (data,type,row) {
                            if (row.status == 1) {
                                return '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Change Status &nbsp;</button><div class="dropdown-menu">' +
                                    '<li data-status_id="'+0+'" data-invoice_id="'+row.id+'"  class="invoice_status"><?php echo e(trans('file.Unpaid')); ?></li>'+
                                    '</div></div>';
                            }
                            if (row.status == 2) {
                                return '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Change Status &nbsp;</button><div class="dropdown-menu">' +
                                    '<li data-status_id="'+1+'" data-invoice_id="'+row.id+'"  class="invoice_status"><?php echo e(trans('file.Paid')); ?></li>'+
                                    '</div></div>';
                            }
                            return '<div class="btn-group"><button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Change Status &nbsp;</button><div class="dropdown-menu">' +
                                '<li data-status_id="'+1+'" data-invoice_id="'+row.id+'"  class="invoice_status"><?php echo e(trans('file.Paid')); ?></li><hr>'+
                                '<li data-status_id="'+2+'" data-invoice_id="'+row.id+'" class="invoice_status"><?php echo e(trans('file.Send')); ?></li>'+
                                '</div></div>';
                        }
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


        let delete_id;

        $(document).on('click', '.delete', function () {
            delete_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('<?php echo e(__('DELETE Record')); ?>');
            $('#ok_button').text('<?php echo e(trans('file.OK')); ?>');

        });


        $('.close').on('click', function () {
            $('#sample_form')[0].reset();
            $('select').selectpicker('refresh');
            $('#invoice-table').DataTable().ajax.reload();
        });

        $('#ok_button').on('click', function () {
            let target = "<?php echo e(route('invoices.index')); ?>/" + delete_id + '/delete';
            $.ajax({
                url: target,
                beforeSend: function () {
                    $('#ok_button').text('<?php echo e(trans('file.Deleting...')); ?>');
                },
                success: function (data) {
                    let html = '';
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';
                    }
                    setTimeout(function () {
                        $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);
                        $('#confirmModal').modal('hide');
                        $('#invoice-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });


        $('body').on('click', '.invoice_status', function () {

            let status_id = $(this).attr('data-status_id');
            let invoice_id = $(this).attr('data-invoice_id');


            var target = "<?php echo e(url('project-management/invoices/status')); ?>/" + status_id +'/'+invoice_id;

            $.ajax({
                url: target,
                method: "get",

                success: function (data) {
                    console.log(data);
                    var html = '';
                    if (data.error) {
                        html = '<div class="alert alert-danger">' + data.error + '</div>';

                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        setTimeout(function () {
                            $('#general_result').html(html);
                            $('#invoice-table').DataTable().ajax.reload();
                        }, 2000);
                    }
                }
            });
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/Modules/CRM/resources/views/client/invoices/index.blade.php ENDPATH**/ ?>