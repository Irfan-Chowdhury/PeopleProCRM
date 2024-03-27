 
<?php $__env->startSection('content'); ?>

    <section>

        <div class="container-fluid"><span id="general_result"></span></div>

        <div class="container-fluid mb-3">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('store-client')): ?>
                <button type="button" class="btn btn-info" name="create_record" id="create_record"><i class="fa fa-plus"></i> <?php echo e(__('Add Client')); ?></button>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-client')): ?>
                <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_delete"><i
                            class="fa fa-minus-circle"></i> <?php echo e(__('Bulk delete')); ?></button>
            <?php endif; ?>
        </div>


        <div class="table-responsive">
            <table id="client-table" class="table ">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(__('Name')); ?></th>
                    <th><?php echo e(trans('file.Company')); ?></th>
                    <th><?php echo e(trans('file.Website')); ?></th>
                    <th><?php echo e(trans('file.Phone')); ?></th>
                    <th><?php echo e(trans('file.Email')); ?></th>
                    <th><?php echo e(trans('file.Group')); ?></th>
                    <th><?php echo e(trans('file.Label')); ?></th>
                    <th><?php echo e(trans('file.Total Invoiced')); ?></th>
                    <th><?php echo e(trans('file.Payment Recieved')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
                </thead>

            </table>
        </div>
    </section>



    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(__('Add Client')); ?></h5>
                    <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><i class="dripicons-cross"></i></button>
                </div>

                <div class="modal-body">
                    <span id="form_result"></span>
                    <span id="store_profile_photo"></span>

                    <form method="post" id="sample_form" class="form-horizontal">

                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('First Name')); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" placeholder=<?php echo e(__('First Name')); ?>

                                        required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Last Name')); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" placeholder=<?php echo e(__('Last Name')); ?>

                                        required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Company')); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" id="company_name"
                                       placeholder=<?php echo e(trans('file.Company')); ?>

                                               required class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Username')); ?> <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="username"
                                       placeholder="<?php echo e(trans('file.Username')); ?>"
                                       required class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Email')); ?></label>
                                <input type="email" name="email" id="email" placeholder='example@example.com'
                                       class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Phone')); ?><span class="text-danger">*</span></label>
                                <input type="number" name="contact_no" id="contact_no"
                                       placeholder="<?php echo e(trans('file.Phone')); ?>"
                                       class="form-control" value="<?php echo e(old('contact_no')); ?>">
                            </div>

                            <div class="col-md-6 form-group ">
                                <label><?php echo e(trans('file.Website')); ?> </label>
                                <input type="text" name="website" id="website" placeholder="Website"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 form-group hide-edit">
                                <label><?php echo e(trans('file.Password')); ?> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                           placeholder="<?php echo e(trans('file.Password')); ?>"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Address Line 1')); ?> </label>
                                <input type="text" name="address1" id="address1" placeholder="<?php echo e(__('Address Line 1')); ?>"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(__('Address Line 2')); ?> </label>
                                <input type="text" name="address2" id="address2" placeholder="<?php echo e(__('Address Line 2')); ?>"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.City')); ?> </label>
                                <input type="text" name="city" id="city" placeholder="<?php echo e(trans('file.City')); ?>"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.State/Province')); ?> </label>
                                <input type="text" name="state" id="state"
                                       placeholder="<?php echo e(trans('file.State/Province')); ?>"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.ZIP')); ?> </label>
                                <input type="text" name="zip" id="zip" placeholder="<?php echo e(trans('file.ZIP')); ?>"
                                       class="form-control">
                            </div>


                            <div class="col-md-6 form-group">
                                    <label><?php echo e(trans('file.Country')); ?></label>
                                    <select name="country" id="country" class="form-control selectpicker"
                                            data-live-search="true" data-live-search-style="contains"
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Country')])); ?>...'>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Client Groups')); ?></label>
                                <select name="client_group" id="clientGroup" class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        title='<?php echo e(__('Selecting',['key'=>trans('file.Group')])); ?>...'>
                                        <option value="Gold"><?php echo app('translator')->get('file.Gold'); ?></option>
                                        <option value="VIP"><?php echo app('translator')->get('file.VIP'); ?></option>
                                        <option value="Silver"><?php echo app('translator')->get('file.Silver'); ?></option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php echo e(trans('file.Labels')); ?></label>
                                <select name="label" id="label" class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        title='<?php echo e(__('Selecting',['key'=>trans('file.Label')])); ?>...'>
                                        <option value="Inactive"><?php echo app('translator')->get('file.Inactive'); ?></option>
                                        <option value="Referral"><?php echo app('translator')->get('file.Referral'); ?></option>
                                        <option value="Satisfied"><?php echo app('translator')->get('file.Satisfied'); ?></option>
                                        <option value="Unsatisfied"><?php echo app('translator')->get('file.Unsatisfied'); ?></option>
                                        <option value="Corporate"><?php echo app('translator')->get('file.Corporate'); ?></option>
                                        <option value="Potential"><?php echo app('translator')->get('file.Potential'); ?></option>
                                        <option value="90% Probability"><?php echo app('translator')->get('file.90% Probability'); ?></option>
                                        <option value="Call this week"><?php echo app('translator')->get('file.50% Probability'); ?></option>
                                        <option value="Call this week"><?php echo app('translator')->get('file.Call this week'); ?></option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="profile_photo"><?php echo e(__('Image')); ?></label>
                                <input type="file" id="profile_photo"
                                       class="form-control <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       name="profile_photo"
                                       placeholder=<?php echo e(trans('file.Upload')); ?> <?php echo e(trans('file.Photo')); ?>>
                            </div>

                            <div class="col-md-6 form-group custom-control custom-checkbox hide-add">
                                <input type="checkbox" class="custom-control-input" name="is_active" id="is_active"
                                       value="1" checked>
                                <label class="custom-control-label" for="is_active"><?php echo e(trans('file.Active')); ?></label>
                            </div>


                            <div class="container">
                                <div class="form-group" align="center">
                                    <input type="hidden" name="action" id="action"/>
                                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                           value=<?php echo e(trans('file.Add')); ?>>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


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

            if (window.location.href.indexOf('#formModal') != -1) {
                $('.modal-title').text('<?php echo e(__('Add Client')); ?>');
                $('#store_profile_photo').html('');
                $('#action_button').val('<?php echo e(trans("file.Add")); ?>');
                $('#action').val('<?php echo e(trans("file.Add")); ?>');
                $('.hide-add').hide();
                $('.hide-edit').show();

                $('#formModal').modal('show');
            }

            let table_table = $('#client-table').DataTable({
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
                    url: "<?php echo e(route('clients.index')); ?>",
                },

                columns: [

                    {
                        data: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',

                    },
                    {
                        data: 'company_name',
                        name: 'company_name',
                    },
                    {
                        data: 'website',
                        name: 'website',
                    },
                    {
                        data: 'contact_no',
                        name: 'contact_no',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'client_group',
                        name: 'client_group',
                    },
                    {
                        data: 'label',
                        name: 'label',
                    },
                    {
                        data: 'total_invoice',
                        name: 'total_invoice',
                    },
                    {
                        data: 'payment_recieved',
                        name: 'payment_recieved',
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
        });


        $('#create_record').on('click', function () {
            $('.modal-title').text('<?php echo e(__('Add Client')); ?>');
            $('#store_profile_photo').html('');
            $('#action_button').val('<?php echo e(trans("file.Add")); ?>');
            $('#action').val('<?php echo e(trans("file.Add")); ?>');
            $('.hide-add').hide();
            $('.hide-edit').show();
            $('#formModal').modal('show');
        });


        $('#sample_form').on('submit', function (event) {
            event.preventDefault();
            if ($('#action').val() == '<?php echo e(trans('file.Add')); ?>') {
                $.ajax({
                    url: "<?php echo e(route('clients.store')); ?>",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);

                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#sample_form')[0].reset();
                            $('select').selectpicker('refresh');
                            $('#client-table').DataTable().ajax.reload();
                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                });
            }

            else if ($('#action').val() == '<?php echo e(trans('file.Edit')); ?>') {
                $.ajax({
                    url: "<?php echo e(route('clients.update')); ?>",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.error) {
                            html = '<div class="alert alert-success">' + data.error + '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                            setTimeout(function () {
                                $('#formModal').modal('hide');
                                $('select').selectpicker('refresh');
                                $('#client-table').DataTable().ajax.reload();
                                $('#sample_form')[0].reset();
                            }, 2000);

                        }
                        $('#form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                });
            }
        });


        $(document).on('click', '.edit', function () {

            var id = $(this).attr('id');
            $('#form_result').html('');
            $('.hide-edit').hide();
            $('.hide-add').show();
            $('#store_profile_photo').html('');

            // var target = "<?php echo e(route('clients.index')); ?>/" + id + '/edit';
            var target = "clients/" + id + '/edit';

            $.ajax({
                url: target,
                dataType: "json",
                success: function (html) {
                    console.log(html);

                    $('#company_name').val(html.data.company_name);
                    $('#username').val(html.data.username);
                    $('#first_name').val(html.data.first_name);
                    $('#last_name').val(html.data.last_name);
                    $('#contact_no').val(html.data.contact_no);
                    $('#email').val(html.data.email);
                    $('#website').val(html.data.website);
                    $('#address1').val(html.data.address1);
                    $('#address2').val(html.data.address2);
                    $('#city').val(html.data.city);
                    $('#state').val(html.data.state);
                    $('#country').selectpicker('val', html.data.country);
                    $('#zip').val(html.data.zip);
                    if (html.data.is_active == 1) {
                        $('#is_active').prop('checked', true);
                    } else {
                        $('#is_active').prop('checked', false);
                    }
                    if (html.data.profile) {
                        $('#store_profile_photo').html("<img src=<?php echo e(URL::to('/public')); ?>/uploads/profile_photos/" + html.data.profile + " width='70'  class='img-thumbnail' />");
                        $('#store_profile_photo').append("<input type='hidden' name='hidden_image' value='" + html.data.profile + "'  />");
                    }
                    $('#clientGroup').selectpicker('val', html.data.client_group);
                    $('#label').selectpicker('val', html.data.label);

                    $('#hidden_id').val(html.data.id);
                    $('.modal-title').text('<?php echo e(trans('file.Edit')); ?>');
                    $('#action_button').val('<?php echo e(trans('file.Edit')); ?>');
                    $('#action').val('<?php echo e(trans('file.Edit')); ?>');
                    $('#formModal').modal('show');
                }
            })
        });


        let delete_id;

        $(document).on('click', '.delete', function () {
            delete_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('<?php echo e(__('DELETE Record')); ?>');
            $('#ok_button').text('<?php echo e(trans('file.OK')); ?>');

        });


        $(document).on('click', '#bulk_delete', function () {

            var id = [];
            let table = $('#client-table').DataTable();
            id = table.rows({selected: true}).ids().toArray();
            if (id.length > 0) {
                if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Client')])); ?>')) {
                    $.ajax({
                        url: '<?php echo e(route('mass_delete_clients')); ?>',
                        method: 'POST',
                        data: {
                            clientIdArray: id
                        },
                        success: function (data) {
                            let html = '';
                            if (data.success) {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                            }
                            if (data.error) {
                                html = '<div class="alert alert-danger">' + data.error + '</div>';
                            }
                            table.ajax.reload();
                            table.rows('.selected').deselect();
                            if (data.errors) {
                                html = '<div class="alert alert-danger">' + data.error + '</div>';
                            }
                            $('#general_result').html(html).slideDown(300).delay(5000).slideUp(300);

                        }

                    });
                }
            } else {
                alert('<?php echo e(__('Please select atleast one checkbox')); ?>');
            }
        });


        $('.close').on('click', function () {
            $('#sample_form')[0].reset();
            $('select').selectpicker('refresh');
            $('#client-table').DataTable().ajax.reload();
        });

        $('#ok_button').on('click', function () {
            let target = "<?php echo e(route('clients.index')); ?>/" + delete_id + '/delete';
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
                        $('#client-table').DataTable().ajax.reload();
                    }, 2000);
                }
            })
        });
    })(jQuery);

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/client/index.blade.php ENDPATH**/ ?>