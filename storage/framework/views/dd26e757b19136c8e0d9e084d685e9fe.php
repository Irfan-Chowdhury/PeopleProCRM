<?php $__env->startSection('content'); ?>

    <section>
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header"><h3><?php echo e(__('file.Lead Section')); ?></h3></div>
                <div class="card-body">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> <?php echo e(__('file.Add New')); ?></button>
                    <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>                </div>
            </div>
        </div>


        <div class="container">
            <div class="table-responsive">
                <table id="dataListTable" class="table ">
                    <thead>
                        <tr>
                            <th class="not-exported"></th>
                            <th><?php echo e(trans('file.Company')); ?></th>
                            <th><?php echo e(trans('file.Owner')); ?></th>
                            <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                        </tr>
                    </thead>
                    <tbody id="tablecontents"></tbody>
                </table>
            </div>
        </div>

    </section>

    <?php echo $__env->make('crm.lead_section.lead.create-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('crm.lead_section.lead.edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    let dataTableURL = "<?php echo e(route('lead.datatable')); ?>";
    let storeURL = "<?php echo e(route('lead.store')); ?>";
    let editURL = "/leads/edit/";
    let updateURL = '/leads/update/';
    let destroyURL = '/leads/destroy/';
    let bulkDeleteURL = '<?php echo e(route('lead.bulk_delete')); ?>';
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
                        data: 'company_name',
                        name: 'company_name',

                    },
                    {
                        data: 'owner',
                        name: 'owner',

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
        //--------- Edit -------
        $(document).on('click', '.edit', function() {
            let id = $(this).data("id");
            currentModal = 'edit';

            $.get({
                url: editURL + id,
                success: function(response) {
                    console.log(response);
                    $("#modelId").val(response.lead.id);
                    $('#companyIdEdit').selectpicker('val', response.lead.company_id);

                    let all_employees = '';
                    $.each(response.employees, function (index, value) {
                        all_employees += '<option value=' + value['id'] + '>' + value['first_name'] +' '+ value['last_name'] + '</option>';
                    });
                    $('#employeeIdEdit').empty().append(all_employees);
                    $('#employeeIdEdit').selectpicker('refresh');
                    $('#employeeIdEdit').selectpicker('val', response.lead.employee_id);

                    $('#statusEdit').selectpicker('val', response.lead.status);
                    $('#countryId').selectpicker('val', response.lead.country_id);
                    $("#editModal input[name='city']").val(response.lead.city);
                    $("#editModal input[name='state']").val(response.lead.state);
                    $("#editModal input[name='zip']").val(response.lead.zip);
                    $("#addressEdit").val(response.lead.address);
                    $("#editModal input[name='phone']").val(response.lead.phone);
                    $("#editModal input[name='website']").val(response.lead.website);
                    $("#editModal input[name='vat_number']").val(response.lead.vat_number);
                    $("#editModal input[name='gst_number']").val(response.lead.gst_number);
                    currentModal = '';
                    $('#editModal').modal('show');
                }
            })
        });

        $('.dynamic').change(function() {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let first_name = $(this).data('first_name');
                let last_name = $(this).data('last_name');
                let _token = $('input[name="_token"]').val();

                $.ajax({
                    url:"<?php echo e(route('dynamic_employee')); ?>",
                    method:"POST",
                    data:{ value:value, _token:_token, first_name:first_name,last_name:last_name},
                    success:function(result)
                    {
                        $('select').selectpicker("destroy");
                        if (currentModal==='edit') {
                            $('#employeeIdEdit').html(result);
                        }else {
                            $('#employeeId').html(result);
                        }

                        $('select').selectpicker();
                    }
                });
            }
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

<script type="text/javascript" src="<?php echo e(asset('js/common-js/store.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/common-js/update.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/common-js/delete.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/common-js/alertMessages.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/resources/views/crm/lead_section/lead/index.blade.php ENDPATH**/ ?>