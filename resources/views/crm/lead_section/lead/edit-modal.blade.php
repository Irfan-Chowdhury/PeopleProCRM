
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> {{ __('file.Edit Lead') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" id="updateForm">
                    @csrf
                    <div class="row">

                        <input type="hidden" id="modelId">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Company')}} <span class="text-danger">*</span></strong></label>
                                <select name="company_id" id="companyIdEdit"
                                        class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="contains"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title="{{__('Selecting',['key'=>trans('file.Company')])}}...">
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Owner')}} <span class="text-danger">*</span></strong></label>
                                <select name="employee_id" id="employeeIdEdit" class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains" data-first_name="first_name"
                                        data-last_name="last_name" title='{{__('Selecting',['key'=>trans('file.Employee')])}}'>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Status')}} <span class="text-danger">*</span></strong></label>
                                <select name="status" id="statusEdit" class="form-control" title="{{__('Selecting',['key'=>trans('file.Status')])}}...">
                                        <option value="new">New</option>
                                        <option value="qualified">Qualified</option>
                                        <option value="discussion">Discussion</option>
                                        <option value="negotiation">Negotiation</option>
                                        <option value="won">Won</option>
                                        <option value="lost">Lost</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Country')}} <span class="text-danger">*</span></strong></label>
                                <select name="country_id" id="countryId"
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Country')])}}...">
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'City',
                            'fieldType' => 'text',
                            'nameData' => 'city',
                            'placeholderData' => 'Chittagong',
                            'isRequired' => true,
                        ])

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'State',
                            'fieldType' => 'text',
                            'nameData' => 'state',
                            'placeholderData' => 'XYZ',
                            'isRequired' => true,
                        ])
                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Zip',
                            'fieldType' => 'text',
                            'nameData' => 'zip',
                            'placeholderData' => '4330',
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
                            'labelName' => 'Phone',
                            'fieldType' => 'text',
                            'nameData' => 'phone',
                            'placeholderData' => '+8801234567890',
                            'isRequired' => true,
                        ])

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Website',
                            'fieldType' => 'text',
                            'nameData' => 'website',
                            'placeholderData' => 'https://www.linkedin.com/',
                            'isRequired' => false,
                        ])
                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'VAT Number',
                            'fieldType' => 'text',
                            'nameData' => 'vat_number',
                            'placeholderData' => '123456',
                            'isRequired' => true,
                        ])
                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'GST Number',
                            'fieldType' => 'text',
                            'nameData' => 'gst_number',
                            'placeholderData' => '987654',
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
