<!--Edit Modal -->
<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> {{ __('file.Edit Proposal') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="updateForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="modelId">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Item')}} <span class="text-danger">*</span></strong></label>
                                <select name="item_id"
                                        required
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        data-first_name="first_name" data-last_name="last_name"
                                        title="{{__('Selecting',['key'=>trans('file.Item')])}}...">
                                    @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Quantity',
                            'fieldType' => 'text',
                            'nameData' => 'quantity',
                            'placeholderData' => 'Ex: 10',
                            'isRequired' => true,
                        ])
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Unit Type')}} <span class="text-danger">*</span></strong></label>
                                <input type="text" readonly name="unit_type" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Rate')}} <span class="text-danger">*</span></strong></label>
                                <input type="text" readonly name="rate" class="form-control">
                            </div>
                        </div>

                        @include('includes.vertical-input-field', [
                            'colSize' => 12,
                            'labelName' => 'Description',
                            'fieldType' => 'textarea',
                            'nameData' => 'description',
                            'placeholderData' => 'Description',
                            'isRequired' => true,
                        ])
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" id="updateButton">@lang('file.Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>
