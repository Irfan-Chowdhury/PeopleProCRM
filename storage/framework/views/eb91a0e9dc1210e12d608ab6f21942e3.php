<?php $__env->startSection('content'); ?>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="wrapper count-title text-center mb-30px ">
                        <div class="box mb-4">
                            <div class="box-header with-border">
                                <h3 class="box-title"> <?php echo e(__('Expense Report')); ?> </h3>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form method="post" id="filter_form" class="form-horizontal">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">

                                                <div class="col-md-6 form-group">
                                                    <label><?php echo e(trans('file.category')); ?> *</label>
                                                    <select name="category_id" id="category_id" class="form-control selectpicker "
                                                            data-live-search="true" data-live-search-style="contains">
                                                        <option value="0"><?php echo e(trans('file.All')); ?></option>
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->type); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="start_date"><?php echo e(__('Start Date')); ?></label>
                                                        <input class="form-control month_year date"
                                                               placeholder="<?php echo e(__('Select Date')); ?>"
                                                               id="start_date" name="start_date" type="text" required>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="end_date"><?php echo e(__('End Date')); ?></label>
                                                        <input class="form-control month_year date"
                                                               placeholder="<?php echo e(__('Select Date')); ?>"
                                                               id="end_date" name="end_date" type="text" required>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="form-actions">
                                                            <button type="submit" class="filtering btn btn-primary"><i
                                                                        class="fa fa-check-square-o"></i> <?php echo e(trans('file.Search')); ?>

                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="card-title text-center"><h3><?php echo e(__('Expense Info')); ?> <span
                                        id="expense_info"></span></h3></div>


                        <div class="table-responsive">
                            <table id="expense_report-table" class="table ">
                                <thead>
                                <tr>
                                    <th class="not-exported"></th>
                                    <th><?php echo e(trans('file.Date')); ?></th>
                                    <th><?php echo e(trans('file.Account')); ?></th>
                                    <th><?php echo e(trans('file.Category')); ?></th>
                                    <th><?php echo e(trans('file.Payee')); ?></th>
                                    <?php if(config('variable.currency_format')=='suffix'): ?>
                                        <th><?php echo e(trans('file.Amount')); ?> (<?php echo e(config('variable.currency')); ?>)</th>
                                    <?php else: ?>
                                        <th>(<?php echo e(config('variable.currency')); ?>) <?php echo e(trans('file.Amount')); ?></th>
                                    <?php endif; ?>
                                    <th><?php echo e(__('Reference No')); ?></th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?php echo e(trans('file.Total')); ?></th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>



<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    (function($) {
        "use strict";

        $(document).ready(function () {

            let date = $('.date');
            date.datepicker({
                format: '<?php echo e(env('Date_Format_JS')); ?>',
                autoclose: true,
                todayHighlight: true,
            });

        });


        fill_datatable();

        function fill_datatable(filter_start_date = '', filter_end_date = '',category_id='') {


            let table_table = $('#expense_report-table').DataTable({

                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // converting to interger to find total
                    var intVal = function (i) {
                        return typeof i == 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i == 'number' ?
                                i : 0;
                    };

                    // computing column Total of the complete result
                    var total = api
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);



                    $(api.column(5).footer()).html('<p>Total: </p>' + total);
                },

                responsive: true,

                fixedHeader: {
                    header: true,
                    footer: true
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?php echo e(route('report.expense')); ?>",
                    data: {
                        filter_start_date: filter_start_date,
                        filter_end_date: filter_end_date,
                        category_id: category_id,
                        "_token": "<?php echo e(csrf_token()); ?>"
                    },
                },

                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'expense_date',
                        name: 'expense_date',
                    },
                    {
                        data: 'account',
                        name: 'account',
                    },
                    {
                        data: 'category',
                        name: 'category',
                    },
                    {
                        data: 'payee',
                        name: 'payee',
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        render: function (data) {
                            if ('<?php echo e(config('variable.currency_format') =='suffix'); ?>') {
                                return data + ' <?php echo e(config('variable.currency')); ?>';
                            } else {
                                return '<?php echo e(config('variable.currency')); ?> ' + data;

                            }
                        }
                    },
                    {
                        data: 'expense_reference',
                        name: 'expense_reference',
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

                        "orderable": true,
                        'targets': [0],
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
        }

        $('#filter_form').on('submit',function (e) {
            e.preventDefault();
            var filter_start_date = $('#start_date').val();
            var filter_end_date = $('#end_date').val();
            let category_id = $('#category_id').val();

            if (filter_start_date !== '' && filter_end_date !== '' && category_id !== '' ) {
                $('#expense_report-table').DataTable().destroy();
                fill_datatable(filter_start_date, filter_end_date,category_id);
            } else {
                alert('<?php echo e(__('Select Both filter option')); ?>');
            }
        });
    })(jQuery);

</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/resources/views/report/expense_report.blade.php ENDPATH**/ ?>