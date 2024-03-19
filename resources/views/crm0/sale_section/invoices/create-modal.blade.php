
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> {{ __('file.Add Invoice') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('items.store') }}" id="submitForm">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Bill Date')}} <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control date" name="start_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Due Date')}} <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control date" name="end_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Client')}} <span class="text-danger">*</span></strong></label>
                                <select name="client_id"
                                        class="form-control selectpicker dependentClient"
                                        required
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Client')])}}...">
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->first_name.' '.$client->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Project')}} <span class="text-danger">*</span></strong></label>
                                <select name="project_id" id="projectId" class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        title='{{__('Selecting',['key'=>trans('file.Project')])}}'>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Tax')}} <span class="text-danger">*</span></strong></label>
                                <select name="tax_id"
                                        class="form-control selectpicker"
                                        required
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Tax')])}}...">
                                    @foreach($taxes as $tax)
                                        <option value="{{$tax->id}}">{{$tax->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Note',
                            'fieldType' => 'textarea',
                            'nameData' => 'note',
                            'placeholderData' => 'Textarea',
                            'isRequired' => false,
                        ])

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div><button type="submit" class="btn btn-primary" id="submitButton">@lang('file.Save')</button></div>
                </div>
            </form>
        </div>
    </div>
</div>