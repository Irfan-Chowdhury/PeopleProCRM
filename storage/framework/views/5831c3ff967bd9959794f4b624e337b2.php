<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/translation/css/main.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('includes.session_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <form action="<?php echo e(route('languages.translations.index', ['language' => $language])); ?>" method="get">

        <div class="container-fluid mt-3 mb-3">
            <div class="d-flex">

                <a href="<?php echo e(route('languages.create')); ?>" class="btn btn-primary mr-1"><?php echo e(__('Add')); ?></a>
                <div class="w-20">
                    <?php echo $__env->make('vendor.translation.forms.select', ['name' => 'language', 'items' => $languages, 'submit' => true, 'selected' => $language], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>


                <div class="ml-3 w-20">
                    <select class="form-control" id='lang_del'>
                        <option selected="selected">Delete Language</option>
                        <option>--------------------------</option>
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lang); ?>"><?php echo e($lang); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>

            </div>
        </div>


        <?php if(count($translations)): ?>

            <div class="table-responsive">
                <table id="language-table" class="table ">

                    <thead>
                    <tr>
                        <th class="w-1/5 uppercase font-thin"><?php echo e(__('translation::translation.key')); ?></th>
                        <th class="uppercase font-thin"><?php echo e(config('app.locale')); ?></th>
                        <th class="uppercase font-thin"><?php echo e($language); ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $__currentLoopData = $translations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $translationsData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $translationsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!is_array($value[config('app.locale')])): ?>
                                    <tr>
                                        <td><?php echo e($key); ?></td>
                                        <td><?php echo e($value[config('app.locale')]); ?></td>
                                        <td>
                                            <textarea class="edit_textarea form-control"><?php echo e($value[$language]); ?></textarea>
                                            <button class="update_btn hidden" type="button" data-key="<?php echo e($key); ?>" data-language="<?php echo e($language); ?>" data-group="<?php echo e($group); ?>" title="Update"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                            <span class="check_icon hidden"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </form>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('vendor/translation/js/app.js')); ?>"></script>

<script type="text/javascript">
    (function($) {
        "use strict";
        $(document).ready(function () {

            var dataSrc = [];

            var table = $('#language-table').DataTable({
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
                'select': {style: 'multi', selector: 'td:first-child'},
                'lengthMenu': [[100, 200, 500,-1], [100, 200, 500,"All"]],
            });


            $(".edit_textarea").on('click',function(){
                $(".update_btn").hide(); //for all
                $(this).siblings('.update_btn').show();
            });

            $(".update_btn").on('click',function(){
                var language = $(this).data('language');
                var key   = $(this).data('key');
                var group = $(this).data('group');
                var value = $(this).siblings('textarea').val();

                $(this).siblings('.check_icon').show();

                $.ajax({
                    url: "<?php echo e(route('language.translations.update')); ?>",
                    type: "POST",
                    data: {
                        language:language,
                        key:key,
                        group:group,
                        value:value
                    },
                    success: function (data) {
                        $(".update_btn").hide();
                        console.log(data);
                        setTimeout(function() {
                            $('.check_icon').fadeOut("slow");
                        }, 3000);
                    }
                });
            });

        });


        $(document).ready(function() {
            $("#localeChange").change(function(){
                var localeName = $('#localeChange :selected').text()
                console.log(localeName);
                var baseUrl = window.location.protocol + '//' + window.location.host;
                var path    = `languages/${localeName}/translations`;
                var url     = baseUrl + '/' + path;
                window.location.href = url;
            });
        });


        $(document).ready(function() {
            $("#lang_del").change(function(){
                var proceed = confirm("Are You Sure To Delete ?");
                if (proceed) {
                    var langVal = $('#lang_del :selected').text()
                    $.ajax({
                        url: "<?php echo e(route('language.delete')); ?>",
                        method: "GET",
                        data: {langVal:langVal},
                        success: function (data) {
                            console.log(data);
                            if (data === 'success' || data ==='error') {
                                var baseUrl = window.location.protocol + '//' + window.location.host;
                                var path    = 'languages/English/translations';
                                var url     = baseUrl + '/' + path;
                                window.location.href = url;
                            }
                        }
                    })
                }
            });
        });
    })(jQuery);
</script>

<?php $__env->stopPush(); ?>




<?php echo $__env->make('layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/peoplepro/peopleprocrm/resources/views/vendor/translation/languages/translations/index.blade.php ENDPATH**/ ?>