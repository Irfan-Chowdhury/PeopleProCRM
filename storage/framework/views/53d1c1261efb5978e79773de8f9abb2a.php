<?php $__env->startSection('content'); ?>


<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="wrapper count-title text-center mb-30px ">
                <div class="box mb-4">
                    <div class="box-header with-border">
                        <h3 class="box-title"> <?php echo e(__('Team Member Project Report')); ?> <span id="details_month_year"></span> </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6>
                    <label for=""><b>Team Member</b></label>
                    <select name="employee_id" id="employee_id" class="form-control selectpicker"
                    data-live-search="true" data-live-search-style="contains" title="<?php echo e(__('Select Team Member')); ?>...">
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"> <?php echo e($item->first_name.' '.$item->last_name); ?> </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="ml-2 col-md-6>
                    <label for=""><b>Project</b></label>
                    <select name="project_id" id="project_id" class="form-control selectpicker"
                    data-live-search="true" data-live-search-style="contains" title="Select Project">
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"> <?php echo e($item->title); ?> </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
    </div>


    <div class="table-responsive">
        <table id="dataListTable" class="table ">
            <thead>
            <tr>
                <th class="not-exported"></th>
                <th><?php echo e(__('Team Memeber')); ?></th>
                <th><?php echo e(__('Project Name')); ?></th>
                <th><?php echo e(trans('file.Priority')); ?></th>
                <th><?php echo e(trans('file.Client')); ?></th>
                <th><?php echo e(__('Start Date')); ?></th>
                <th><?php echo e(__('End Date')); ?></th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    let dataTableURL = "<?php echo e(route('report.project')); ?>";
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


            var table = $('#dataListTable').DataTable({
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
                    url: dataTableURL,
                    data: function (d) {
                        d.employee_id = $('#employee_id').val()
                        d.project_id = $('#project_id').val()
                    }
                },

                columns: [
                    {
                        data: 'project_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'assigned_employee',
                        name: 'assigned_employee',
                    },
                    {
                        data: 'project_title',
                        name: 'project_title'

                    },
                    {
                        data: 'project_priority',
                        name: 'project_priority',
                    },

                    {
                        data: 'client',
                        name: 'client',
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
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
                        'targets': [0, 5],
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

            $('#employee_id').change(function(){
                table.draw();
            });
            $('#project_id').change(function(){
                table.draw();
            });
        });




    })(jQuery);
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/report/project.blade.php ENDPATH**/ ?>