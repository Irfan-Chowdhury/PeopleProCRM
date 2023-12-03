
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> {{ __('file.Edit Contact') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('lead.contact.update', ['lead' => $lead->id, 'leadContact'=>1]) }}" id="updateForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="model_id" id="modelId"> <!-- Need Duruing Update-->

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'First Name',
                            'fieldType' => 'text',
                            'nameData' => 'first_name',
                            'placeholderData' => 'Irfan',
                            'isRequired' => true,
                        ])

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Last Name',
                            'fieldType' => 'text',
                            'nameData' => 'last_name',
                            'placeholderData' => 'Chowdhhury',
                            'isRequired' => true,
                        ])
                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Email',
                            'fieldType' => 'text',
                            'nameData' => 'email',
                            'placeholderData' => 'irfan@gmail.com',
                            'isRequired' => true,
                        ])
                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Phone',
                            'fieldType' => 'text',
                            'nameData' => 'phone',
                            'placeholderData' => '+8801234567890',
                            'isRequired' => true,
                        ])

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Address',
                            'fieldType' => 'textarea',
                            'nameData' => 'address',
                            'placeholderData' => 'eg: Muradpur, Chittagong, Bangladesh',
                            'isRequired' => true,
                            'idData' => 'addressEdit'
                        ])
                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Job Title',
                            'fieldType' => 'text',
                            'nameData' => 'job_title',
                            'placeholderData' => 'eg: Software Engineer',
                            'isRequired' => true,
                        ])

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Image',
                            'fieldType' => 'file',
                            'nameData' => 'image',
                            'placeholderData' => '',
                            'isRequired' => false,
                        ])

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Gender')}} <span class="text-danger">*</span></strong></label>
                                <input type="radio" name="gender" value="male" class="ml-2"> Male
                                <input type="radio" name="gender" value="female" class="ml-2"> Female
                                <input type="radio" name="gender" value="other" class="ml-2"> Other
                            </div>
                        </div>

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Primary Contact',
                            'fieldType' => 'checkbox',
                            'nameData' => 'is_primary_contact',
                            'placeholderData' => '',
                            'isRequired' => false,
                        ])

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="submitButton">@lang('file.Update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
