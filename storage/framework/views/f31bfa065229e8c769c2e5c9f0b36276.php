<?php $__env->startSection('content'); ?>



    <section>
        <div id="formModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Status')); ?></h5>
                        <button type="button" data-dismiss="modal" id="close" aria-label="Close" class="close"><span
                                    aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                        <span id="bug__status_form_result"></span>
                        <form method="post" id="bug_status_form" class="form-horizontal">

                            <?php echo csrf_field(); ?>
                            <div class="row">

                                <div class="col-md-6 form-group">
                                    <label><?php echo e(trans('file.Status')); ?></label>
                                    <select name="bug_status" id="bug_status" class="form-control selectpicker "
                                            data-live-search="true" data-live-search-style="contains"
                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...'>
                                        <option value="pending"><?php echo e(trans('file.Pending')); ?></option>
                                        <option value="solved"><?php echo e(trans('file.Solved')); ?></option>
                                    </select>
                                </div>

                                <div class="container">
                                    <div class="form-group" align="center">
                                        <input type="hidden" name="action" id="action"/>
                                        <input type="hidden" name="bug_status_id" id="bug_status_id"/>
                                        <input type="submit" name="action_button" id="action_button"
                                               class="btn btn-warning"
                                               value='<?php echo e(trans('file.Update')); ?>'/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between collapse-head" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">
                                <h3><?php echo e(__('Project Details')); ?></h3>
                                <small class="show btn btn-light btn-sm" disabled><i class="dripicons-chevron-up"></i></small>
                            </div>
                            <div class="collapse show" id="collapseExample">
                                <div class="table-responsive">
                                    <table id="project_details" class="table mb-0">
                                        <thead>
                                            <th scope="row"><?php echo e(trans('file.Title')); ?></th>
                                            <th scope="row"><?php echo e(trans('file.Client')); ?></th>
                                            <th scope="row"><?php echo e(__('Start Date')); ?></th>
                                            <th scope="row"><?php echo e(__('End Date')); ?></th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><h6 class="mb-0"><?php echo e($project->title); ?></h6><?php echo e($project->project_priority); ?> priority<br><?php echo e($project->project_progress ?? '0'); ?>% Complete</td>
                                                <td><?php echo e($project->client->first_name); ?> <?php echo e($project->client->last_name); ?></td>
                                                <td><?php echo e($project->start_date); ?></td>
                                                <td><?php echo e($project->end_date); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <span id="assigned_result"></span>
                                    <table class="table mb-0">
                                        <thead>
                                            <th scope="row"><?php echo e(trans('file.Employees')); ?>*</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <form method="post" id="assigned_form" class="form-horizontal">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="input-group">
                                                            <select name="employee_id[]" id="employee_id" class="form-control js-example-responsive"
                                                                    multiple="multiple">
                                                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($emp->id); ?>"><?php echo e($emp->full_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assign-project')): ?>
                                                                <div class="col-md-6 form-group">
                                                                    <input type="submit" name="assigned_submit" id="assigned_submit" class="btn btn-success btn-sm" value=<?php echo e(trans("file.Save")); ?>>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    (function($) {
                        "use strict";
                        $('.collapse-head').on('click', function(){
                            if ($('.collapse-head').attr('aria-expanded') == "true") {
                                $('.collapse-head .show').html('<i class="dripicons-chevron-down"></i>');
                            } else {
                                 $('.collapse-head .show').html('<i class="dripicons-chevron-up"></i>');
                            }
                        })
                    })(jQuery);
                </script>


                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs d-flex justify-content-between" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#Details"
                                       role="tab" aria-controls="Details"
                                       aria-selected="true"><?php echo e(trans('file.Overview')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="discussions-tab" data-toggle="tab" href="#Discussions"
                                       role="tab"
                                       aria-controls="Discussions" data-table="discussion"
                                       aria-selected="false"><?php echo e(trans('file.Discussions')); ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="progress-tab" data-toggle="tab" href="#Progress" role="tab"
                                       aria-controls="Progress" data-table="progress"
                                       aria-selected="false"><?php echo e(trans('Progress')); ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="bugs-tab" data-toggle="tab" href="#Bugs" role="tab"
                                       aria-controls="Bugs" data-table="bugs"
                                       aria-selected="false"><?php echo e(trans('file.Bugs')); ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="tasks-tab" data-toggle="tab" href="#Tasks" role="tab"
                                       aria-controls="Tasks" data-table="tasks"
                                       aria-selected="false"><?php echo e(trans('file.Tasks')); ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="files-tab" data-toggle="tab" href="#Files" role="tab"
                                       aria-controls="Files" data-table="files"
                                       aria-selected="false"><?php echo e(trans('file.Files')); ?></a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="notes-tab" data-toggle="tab" href="#Notes" role="tab"
                                       aria-controls="Notes" aria-selected="false"><?php echo e(trans('file.Notes')); ?></a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="Details" role="tabpanel"
                                     aria-labelledby="progress-tab">
                                    <!--Contents for Details starts here-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="project_description"></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="Discussions" role="tabpanel"
                                     aria-labelledby="discussions-tab">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <span id="discussions_result"></span>
                                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseDiscussion" role="button" aria-expanded="false" aria-controls="collapseDiscussion">
                                                <?php echo e(__('Post A Message')); ?>

                                            </a>
                                            <div class="collapse" id="collapseDiscussion">
                                                <hr>
                                                <form method="post" id="discussions_form" class="form-horizontal" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        <label><?php echo e(trans('file.Discussions')); ?></label>
                                                        <textarea required class="form-control" id="project_discussions" name="project_discussions" rows="3"></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo e(trans('file.Attachments')); ?> </label>
                                                        <input type="file" name="discussion_attachments" id="discussion_attachments" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" name="discussions_submit" id="discussions_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="discussions-table" class="table ">
                                                <thead>
                                                <tr>
                                                    <th><?php echo e(trans('file.User')); ?></th>
                                                    <th><?php echo e(trans('file.Message')); ?></th>
                                                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="Progress" role="tabpanel" aria-labelledby="progress-tab">
                                    <span id="progress_result"></span>
                                    <form method="post" id="progress_form" class="form-horizontal">
                                        <?php echo csrf_field(); ?>
                                        <div class="col-md-8 form-group">
                                            <label><?php echo e(__('Progress Bar')); ?> </label>
                                            <input type="text" name="project_progress" id="project_progress"
                                                   class="form-control range-slider "
                                                   placeholder="<?php echo e(__('Progress Bar')); ?>">
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-6 form-group show-edit">
                                                    <label><?php echo e(trans('file.Status')); ?></label>
                                                    <select name="project_status" id="project_status"
                                                            class="form-control selectpicker "
                                                            data-live-search="true" data-live-search-style="contains"
                                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Status')])); ?>...'>
                                                        <option value="not_started"><?php echo e(__('Not Started')); ?></option>
                                                        <option value="in_progress"><?php echo e(__('In Progress')); ?></option>
                                                        <option value="completed"><?php echo e(trans('file.Completed')); ?></option>
                                                        <option value="deferred"><?php echo e(trans('file.Deferred')); ?></option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label><?php echo e(trans('file.Priority')); ?></label>
                                                    <select name="project_priority" id="project_priority"
                                                            class="form-control selectpicker "
                                                            data-live-search="true" data-live-search-style="contains"
                                                            title='<?php echo e(__('Selecting',['key'=>trans('file.Priority')])); ?>...'>
                                                        <option value="low"><?php echo e(trans('file.Low')); ?></option>
                                                        <option value="medium"><?php echo e(trans('file.Medium')); ?></option>
                                                        <option value="high"><?php echo e(trans('file.High')); ?></option>
                                                        <option value="highest"><?php echo e(trans('file.Highest')); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <input type="submit" name="project_progress_submit"
                                                   id="project_progress_submit"
                                                   class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="Bugs" role="tabpanel" aria-labelledby="bugs-tab">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <span id="bugs_result"></span>
                                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseBug" role="button" aria-expanded="false" aria-controls="collapseBug">
                                                <?php echo e(__('Report A Bug')); ?>

                                            </a>
                                            <div class="collapse" id="collapseBug">
                                                <hr>
                                                <form method="post" id="bugs_form" class="form-horizontal"
                                                      enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        <label><?php echo e(trans('file.Bugs')); ?></label>
                                                        <textarea required class="form-control" id="bugs_title" name="bugs_title" rows="3"></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo e(trans('file.Attachments')); ?> </label>
                                                        <input type="file" name="bug_attachment" id="bug_attachment" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" name="bugs_submit" id="bugs_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="bugs-table" class="table ">
                                                <thead>
                                                <tr>
                                                    <th><?php echo e(trans('file.User')); ?></th>
                                                    <th><?php echo e(trans('file.Bugs')); ?></th>
                                                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="Tasks" role="tabpanel" aria-labelledby="tasks-tab">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <span id="tasks_result"></span>
                                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseTask" role="button" aria-expanded="false" aria-controls="collapseTask">
                                                <?php echo e(__('Post A Task')); ?>

                                            </a>
                                            <div class="collapse" id="collapseTask">
                                                <hr>
                                                <form method="post" id="tasks_form" class="form-horizontal">
                                                    <?php echo csrf_field(); ?>

                                                    <div class="form-group">
                                                        <label><?php echo e(trans('file.Title')); ?> *</label>
                                                        <input type="text" name="task_title" id="task_title" required
                                                               class="form-control"
                                                               placeholder="<?php echo e(trans('file.Title')); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo e(__('Estimated Hour')); ?> *</label>
                                                        <input type="text" name="estimated_hour" id="estimated_hour"
                                                               required class="form-control"
                                                               placeholder="<?php echo e(__('Estimated Hour')); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo e(__('Start Date')); ?> *</label>
                                                        <input type="text" name="start_date" id="start_date"
                                                               autocomplete="off" required class="form-control date"
                                                               value="">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo e(__('End Date')); ?> *</label>
                                                        <input type="text" name="end_date" id="end_date" autocomplete="off"
                                                               required class="form-control date"
                                                               value="">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo e(trans('file.Description')); ?></label>
                                                        <textarea class="form-control des-editor" id="task_description"
                                                                  name="task_description"
                                                                  rows="3"></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" name="task_submit" id="task_submit"
                                                               class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="tasks-table" class="table ">
                                                <thead>
                                                <tr>
                                                    <th><?php echo e(trans('file.Title')); ?></th>
                                                    <th><?php echo e(__('End Date')); ?></th>
                                                    <th><?php echo e(trans('file.Status')); ?></th>
                                                    <th><?php echo e(__('Created By')); ?></th>
                                                    <th><?php echo e(trans('file.Progress')); ?></th>
                                                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="Files" role="tabpanel" aria-labelledby="files-tab">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <span id="files_result"></span>
                                            <a class="btn btn-primary" data-toggle="collapse" href="#collapseFile" role="button" aria-expanded="false" aria-controls="collapseFile">
                                                <?php echo e(__('Insert A File')); ?>

                                            </a>
                                            <div class="collapse" id="collapseFile">
                                                <hr>
                                                <form method="post" id="files_form" class="form-horizontal"
                                                      enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>

                                                    <div class="form-group">
                                                        <label><?php echo e(trans('file.Title')); ?> *</label>
                                                        <input type="text" name="file_title" id="file_title" required
                                                               class="form-control"
                                                               placeholder="<?php echo e(trans('file.Title')); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo e(trans('file.Description')); ?></label>
                                                        <textarea required class="form-control" id="file_description"
                                                                  name="file_description" rows="3"></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label><?php echo e(trans('file.Attachments')); ?> </label>
                                                        <input type="file" name="file_attachment" id="file_attachment"
                                                               class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="submit" name="file_submit" id="file_submit"
                                                               class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="files-table" class="table ">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo e(trans('file.Title')); ?></th>
                                                        <th><?php echo e(trans('file.Description')); ?></th>
                                                        <th><?php echo e(__('Date and Time')); ?></th>
                                                        <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                    </div>
                                </div>


                                <div class="tab-pane fade" id="Notes" role="tabpanel" aria-labelledby="notes-tab">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <span id="note_result"></span>
                                            <form method="post" id="note_form" class="form-horizontal">
                                                <?php echo csrf_field(); ?>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label><?php echo e(__('Project Note')); ?></label>
                                                        <textarea required class="form-control" id="project_note" name="project_note" rows="3"><?php echo e($project->project_note); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="submit" name="project_note_submit" id="project_note_submit" class="btn btn-success" value=<?php echo e(trans("file.Save")); ?>>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

        let project_status = <?php echo json_encode($project->project_status) ?>;
        let project_priority = <?php echo json_encode($project->project_priority) ?>;
        let project_progress = <?php echo json_encode($project->project_progress) ?>;
        let assigned = <?php echo json_encode($name) ?>;
        let description = <?php echo json_encode($project->description) ?>;

        function htmlDecode(input){
            var e = document.createElement('div');
            e.innerHTML = input;
            return e.childNodes.length == 0 ? "" : e.childNodes[0].nodeValue;
        }

        $('#project_status').val(project_status);
        $('#project_priority').val(project_priority);
        $('#project_description').html(htmlDecode(description));


        $(document).ready(function () {

            let date = $('.date');
            date.datepicker({
                format: '<?php echo e(env('Date_Format_JS')); ?>',
                autoclose: true,
                todayHighlight: true
            });


            $('.js-example-responsive').select2({
                placeholder: '<?php echo e(__('')); ?>',
                width: 'resolve',
                theme: "classic",
            });
            $('#employee_id').val(assigned);
            $('#employee_id').trigger('change');



            $('#assigned_form').on('submit', function (event) {
                event.preventDefault();

                $.ajax({
                    url: "<?php echo e(route('projects.assigned',$project)); ?>",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        let html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (let count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success + '</div>';
                        }
                        $('#assigned_result').html(html).slideDown(300).delay(5000).slideUp(300);
                    }
                })

            });
        });

        $('#progress_form').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: "<?php echo e(route('project_progress.store',$project)); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    $('#progress_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            })
        });

        $('[data-table="discussion"]').one('click', function (e) {

            $('#discussions-table').DataTable().clear().destroy();

            let table_table = $('#discussions-table').DataTable({
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
                    url: "<?php echo e(route('project_discussions.index',$project)); ?>",
                    method: "post"
                },

                columns: [


                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'message',
                        name: 'message',
                        render: function (data, type, row) {
                            return data + ' (' + row.created_at + ')';
                        }

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
                        'targets': [0, 2],
                    },
                ],

                'select': {style: 'multi', selector: 'td:first-child'},
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
            });
            new $.fn.dataTable.FixedHeader(table_table);
        });

        $('#discussions_form').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: "<?php echo e(route('project_discussions.store',$project)); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#discussions_form')[0].reset();
                        $('#discussions-table').DataTable().ajax.reload();
                    }
                    $('#discussions_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            })
        });

        $(".range-slider").ionRangeSlider({
            type: "single",
            min: 0,
            max: 100,
            step: 1,
            grid: true,
            postfix: "%",
            skin: "round"
        });

        var instance = $('.range-slider').data("ionRangeSlider");
        instance.update({
            from: project_progress,
        });

        $('[data-table="bugs"]').one('click', function (e) {

            $('#bugs-table').DataTable().clear().destroy();

            let table_table = $('#bugs-table').DataTable({
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
                    url: "<?php echo e(route('project_bugs.index',$project)); ?>",
                    method: "post"
                },

                columns: [


                    {
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'title',
                        name: 'title',
                        render: function (data, type, row) {
                            return data + "<td><div class = 'badge badge-success'>" + row.status + "</div></td>" + ' (' + row.created_at + ')';
                        }

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
                        'targets': [0, 2],
                    },
                ],

                'select': {style: 'multi', selector: 'td:first-child'},
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
            });
            new $.fn.dataTable.FixedHeader(table_table);
        });

        $('#bugs_form').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: "<?php echo e(route('project_bugs.store',$project)); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#bugs_form')[0].reset();
                        $('#bugs-table').DataTable().ajax.reload();
                    }
                    $('#bugs_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            })
        });


        $(document).on('click', '.edit-bug', function () {


            $('#bug_status_form_result').html('');

            let id = $(this).attr('id');

            let target = "<?php echo e(route('bug_status.default')); ?>/" + id;

            $.ajax({
                url: target,
                dataType: "json",
                success: function (html) {

                    $('#bug_status').selectpicker('val', html.status);
                    $('.modal-title').text('<?php echo e(trans('file.Edit')); ?>');
                    $('#bug_status_id').val(html.id);
                    $('#formModal').modal('show');
                }
            })
        });



        $('#bug_status_form').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: "<?php echo e(route('bug_status.update')); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        setTimeout(function () {
                            $('#formModal').modal('hide');
                            $('select').selectpicker('refresh');
                            $('#bugs-table').DataTable().ajax.reload();
                            $('#bug_status_form')[0].reset();
                        }, 2000);

                    }
                    $('#bug__status_form_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            });

        });

        $('[data-table="files"]').one('click', function (e) {

            $('#files-table').DataTable().clear().destroy();

            let table_table = $('#files-table').DataTable({
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
                    url: "<?php echo e(route('project_files.index',$project)); ?>",
                    method: "post"
                },

                columns: [


                    {
                        data: 'file_title',
                        name: 'file_title'
                    },
                    {
                        data: 'file_description',
                        name: 'file_description',

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
                        'targets': [0, 2],
                    },
                ],

                'select': {style: 'multi', selector: 'td:first-child'},
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
            });
            new $.fn.dataTable.FixedHeader(table_table);
        });

        $('#files_form').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo e(route('project_files.store',$project)); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#files_form')[0].reset();
                        $('#files-table').DataTable().ajax.reload();
                    }
                    $('#files_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            })
        });

        $('[data-table="tasks"]').one('click', function (e) {

            $('#tasks-table').DataTable().clear().destroy();

            let table_table = $('#tasks-table').DataTable({
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
                    url: "<?php echo e(route('project_tasks.index',$project)); ?>",
                    method: "post"
                },

                columns: [


                    {
                        data: 'task_name',
                        name: 'task_name'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',

                    },
                    {
                        data: 'task_status',
                        name: 'task_status'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'task_progress',
                        name: 'task_progress',
                        render: function (data, type, row) {
                            if (data) {
                                return data + '% completed';
                            } else {
                                return 0 + '% completed'
                            }
                        }
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
                        'targets': [0, 5],
                    },
                ],

                'select': {style: 'multi', selector: 'td:first-child'},
                'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
            });
            new $.fn.dataTable.FixedHeader(table_table);
        });

        $('#tasks_form').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo e(route('project_tasks.store',$project)); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#tasks_form')[0].reset();
                        $('#tasks-table').DataTable().ajax.reload();
                    }
                    $('#tasks_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            })
        });

        $('#note_form').on('submit', function (event) {
            event.preventDefault();

            $.ajax({
                url: "<?php echo e(route('project_notes.store',$project)); ?>",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function (data) {
                    let html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (let count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                    }
                    $('#note_result').html(html).slideDown(300).delay(5000).slideUp(300);
                }
            })
        });

        $(document).on('click', '.delete-discussion', function () {

            if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Discussions')])); ?>')) {

                let delete_id = $(this).attr('id');
                let target = "<?php echo e(route('projects.index')); ?>/" + delete_id + '/delete_discussions';
                $.ajax({
                    url: target,
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
                            $('#discussions-table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            }

        });


        $(document).on('click', '.delete-bug', function () {

            if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Bugs')])); ?>')) {

                let delete_id = $(this).attr('id');
                let target = "<?php echo e(route('projects.index')); ?>/" + delete_id + '/delete_bugs';
                $.ajax({
                    url: target,
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
                            $('#bugs-table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            }

        });

        $(document).one('click', '.delete-file', function () {

            if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Files')])); ?>')) {

                let delete_id = $(this).attr('id');
                let target = "<?php echo e(route('projects.index')); ?>/" + delete_id + '/delete_files';
                $.ajax({
                    url: target,
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
                            $('#files-table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            }

        });

        $(document).one('click', '.delete-task', function () {

            if (confirm('<?php echo e(__('Delete Selection',['key'=>trans('file.Tasks')])); ?>')) {

                let delete_id = $(this).attr('id');
                let target = "<?php echo e(route('projects.index')); ?>/" + delete_id + '/delete_tasks';
                $.ajax({
                    url: target,
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
                            $('#tasks-table').DataTable().ajax.reload();
                        }, 2000);
                    }
                })
            }

        });

        $('.dynamic').change(function () {
            if ($(this).val() !== '') {
                let value = $(this).val();
                let first_name = $(this).data('first_name');
                let last_name = $(this).data('last_name');
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "<?php echo e(route('dynamic_employee')); ?>",
                    method: "POST",
                    data: {value: value, _token: _token, first_name: first_name, last_name: last_name},
                    success: function (result) {
                        $('select').selectpicker("destroy");
                        $('#employee_id').html(result);
                        $('select').selectpicker();

                    }
                });
            }
        });
    })(jQuery);

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/resources/views/projects/project/details.blade.php ENDPATH**/ ?>