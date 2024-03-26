
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> <?php echo e(__('file.Add File')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="<?php echo e(route('lead.files.store', ['lead' => $lead->id])); ?>" id="submitForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <input type="hidden" name="lead_id" value="<?php echo e($lead->id); ?>">
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php echo e(trans('file.Title')); ?> *</label>
                                <input type="text" name="file_title" id="file_title" required
                                    class="form-control"
                                    placeholder="<?php echo e(trans('file.Title')); ?>">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php echo e(trans('file.Description')); ?></label>
                                <textarea required class="form-control" id="file_description"
                                        name="file_description" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php echo e(trans('file.Attachments')); ?> </label>
                                <input type="file" name="file_attachment" id="file_attachment"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="submitButton"><?php echo app('translator')->get('file.Save'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/peoplepro/peoplepro-hrm-crm/Modules/CRM/resources/views/lead_section/files/create-modal.blade.php ENDPATH**/ ?>