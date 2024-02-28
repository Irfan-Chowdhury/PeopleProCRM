<div class="col-md-<?php echo e($colSize); ?>">
    <div class="form-group">
        <?php if($fieldType !== 'checkbox'): ?>
            <label class="font-weight-bold"><?php echo e(trans("file.$labelName")); ?> <?php if($isRequired): ?><span class="text-danger">*</span> <?php endif; ?> </label>
        <?php endif; ?>

        <?php switch($fieldType):
            case ('text'): ?>
                <input <?php echo e($isRequired ? 'required':''); ?> type="text" name="<?php echo e($nameData); ?>" id="<?php echo e(isset($idData) ? $idData : null); ?>" <?php if(isset($valueData)): ?> value="<?php echo e($valueData); ?>" <?php else: ?> placeholder="<?php echo e($placeholderData); ?>" <?php endif; ?> class="form-control">
                <?php break; ?>
            <?php case ('radonly'): ?>
                <input type="radonly" name="<?php echo e($nameData); ?>" id="<?php echo e(isset($idData) ? $idData : null); ?>" <?php if(isset($valueData)): ?> value="<?php echo e($valueData); ?>" <?php else: ?> placeholder="<?php echo e($placeholderData); ?>" <?php endif; ?> class="form-control">
                <?php break; ?>
            <?php case ('date'): ?>
                <input <?php echo e($isRequired ? 'required':''); ?> name="<?php echo e($nameData); ?>" id="<?php echo e(isset($idData) ? $idData : null); ?>" <?php if(isset($valueData)): ?> value="<?php echo e($valueData); ?>" <?php else: ?> placeholder="<?php echo e($placeholderData); ?>" <?php endif; ?> class="date form-control">
                <?php break; ?>
            <?php case ('number'): ?>
                <input <?php echo e($isRequired ? 'required':''); ?> type="number" name="<?php echo e($nameData); ?>" id="<?php echo e(isset($idData) ? $idData : null); ?>" <?php if(isset($valueData)): ?> value="<?php echo e($valueData); ?>" <?php else: ?> placeholder="<?php echo e($placeholderData); ?>" <?php endif; ?> class="form-control">
                <?php break; ?>
            <?php case ('file'): ?>
                <input <?php echo e($isRequired ? 'required':''); ?> type="file" name="<?php echo e($nameData); ?>" id="<?php echo e(isset($idData) ? $idData : null); ?>" class="form-control">
                <?php break; ?>
            <?php case ('textarea'): ?>
                <textarea  <?php echo e($isRequired ? 'required':''); ?> name="<?php echo e($nameData); ?>" id="<?php echo e(isset($idData) ? $idData : null); ?>" <?php if(isset($placeholderData)): ?> placeholder="<?php echo e($placeholderData); ?>" <?php endif; ?> class="form-control ckeditor" rows="4"> <?php if(isset($valueData)): ?> <?php echo e($valueData); ?> <?php endif; ?> </textarea>
                <?php break; ?>
            <?php case ('checkbox'): ?>
                <input  <?php if(isset($isChecked)): ?> <?php echo e($isChecked ? 'checked' : ''); ?>  <?php endif; ?> <?php echo e($isRequired ? 'required':''); ?> type="checkbox"  name="<?php echo e($nameData); ?>" id="<?php echo e(isset($idData) ? $idData : null); ?>" <?php if(isset($valueData)): ?> value="<?php echo e($valueData); ?>" <?php endif; ?>> &nbsp;
                <label class="font-weight-bold"><?php echo e(trans("file.$labelName")); ?></label>
                <?php break; ?>
            <?php default: ?>
        <?php endswitch; ?>
    </div>
</div>
<?php /**PATH /var/www/html/peoplepro/peopleprocrm/resources/views/includes/vertical-input-field.blade.php ENDPATH**/ ?>