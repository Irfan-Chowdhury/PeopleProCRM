
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> {{ __('file.Add Contract') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('lead.contracts.store', ['lead' => $lead->id]) }}" id="submitForm">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Title',
                            'fieldType' => 'text',
                            'nameData' => 'title',
                            'placeholderData' => 'Title',
                            'isRequired' => true,
                        ])

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Contract Date')}} <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control date" name="start_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Valid Until')}} <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control date" name="end_date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Project')}} </strong><span class="text-danger">*</span></label>
                                <select name="project_id"
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Tax')])}}...">
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}">{{$project->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Tax')}} <span class="text-danger">*</span></strong></label>
                                <select name="tax_type_id"
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Tax')])}}...">
                                    @foreach($taxes as $tax)
                                        <option value="{{$tax->id}}">{{$tax->name}} ({{$tax->rate}}%)</option>
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
