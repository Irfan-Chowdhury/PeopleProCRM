<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header"><h3><?php echo e(__('file.Payments')); ?></h3></div>
            <div class="card-header">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> <?php echo e(__('file.Add New')); ?></button>
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="table-responsive">
        <table id="dataListTable" class="table ">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Invoice Id')); ?></th>
                    <th><?php echo e(trans('file.Payment Date')); ?></th>
                    <th><?php echo e(trans('file.Payment Method')); ?></th>
                    <th><?php echo e(trans('file.Amount')); ?></th>
                    <th><?php echo e(trans('file.Payment Status')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.Action')); ?></th>
                </tr>
            </thead>
            <tbody id="tablecontents"></tbody>
        </table>
    </div>
</div>

<?php echo $__env->make('crm::sale_section.invoice_payments.create-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    let dataTableURL = "<?php echo e(route('invoice-payments.datatable')); ?>";
    let storeURL = "<?php echo e(route('invoice-payments.store')); ?>";
    let destroyURL = "<?php echo e(url('sales/invoice-payments/destroy')); ?>/";
    let bulkDeleteURL = "<?php echo e(route('invoice-payments.bulk_delete')); ?>";
</script>

<script type="text/javascript">
    (function($) {
        "use strict";

        var invoices = <?php echo $invoices; ?>;


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
                        data: 'invoiceId',
                        name: 'invoiceId',
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date',
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method',
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status',
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

        $('#submitForm select[name="invoice_id"]').change(function () {
            let invoiceId = parseInt($(this).val());
            let invoice = invoices.find(function(item) {
                return parseInt(item.id) === invoiceId;
            });
            let amount = invoice ? invoice.sub_total : 0;

            $('#submitForm input[name="amount"]').val(amount);
        });



    })(jQuery);
</script>


<script type="text/javascript" src="<?php echo e(asset('js/common-js/store.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/common-js/delete.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/common-js/bulkDelete.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/common-js/alertMessages.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/sale_section/invoice_payments/index.blade.php ENDPATH**/ ?>