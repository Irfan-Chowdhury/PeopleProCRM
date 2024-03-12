<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> {{ __('file.Edit Subscription') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="updateForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="modelId" name="model_id">

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
                                <label class="text-bold"><strong>{{trans('file.First Billing Date')}} <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control date" name="first_billing_date">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Client')}} <span class="text-danger">*</span></strong></label>
                                <select name="client_id"
                                        id="clientIdEdit"
                                        class="form-control selectpicker dynamic"
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
                                <label class="text-bold"><strong>{{trans('file.Tax')}} <span class="text-danger">*</span></strong></label>
                                <select name="tax_type_id"
                                        id="taxIdEdit"
                                        class="form-control selectpicker dynamic"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Tax')])}}...">
                                    @foreach($taxes as $taxe)
                                        <option value="{{$taxe->id}}">{{$taxe->name}} ({{ $taxe->rate }}%)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Repeat Type')}} <span class="text-danger">*</span></strong></label>
                                <select name="repeat_type" id="repeatTypeEdit" class="form-control" title="{{__('Selecting',['key'=>trans('file.Repeat Type')])}}...">
                                        <option value="day">Day</option>
                                        <option value="week">Week</option>
                                        <option value="month">Month</option>
                                        <option value="year">Year</option>
                                </select>
                            </div>
                        </div>

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Note',
                            'fieldType' => 'textarea',
                            'nameData' => 'note',
                            'placeholderData' => 'Note',
                            'isRequired' => false,
                            'idData' => 'noteEdit',
                        ])
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" id="submitButton">@lang('file.Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>
