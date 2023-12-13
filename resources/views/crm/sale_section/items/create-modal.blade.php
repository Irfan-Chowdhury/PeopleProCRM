
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> {{ __('file.Add Item') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{ route('items.store') }}" id="submitForm">
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

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Description',
                            'fieldType' => 'textarea',
                            'nameData' => 'description',
                            'placeholderData' => 'Description',
                            'isRequired' => false,
                        ])


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Category')}} </strong><span class="text-danger">*</span></label>
                                <select name="item_category_id"
                                        class="form-control selectpicker"
                                        data-live-search="true" data-live-search-style="contains"
                                        title="{{__('Selecting',['key'=>trans('file.Category')])}}...">
                                    @foreach($itemCategogries as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Unit Type',
                            'fieldType' => 'text',
                            'nameData' => 'unit_type',
                            'placeholderData' => 'Unit Type (Ex: hours, pc, etc.)',
                            'isRequired' => true,
                        ])

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Rate',
                            'fieldType' => 'number',
                            'nameData' => 'rate',
                            'placeholderData' => 'Rate',
                            'isRequired' => true,
                        ])

                        <div class="col-md-6">
                            <div class="form-group mt-4">
                                <input type="checkbox" name="is_client_visible" value="male" >
                                <label class="ml-2 text-bold"><strong>{{trans('file.Show in Client portal')}}</strong></label>

                            </div>
                        </div>

                        @include('includes.vertical-input-field', [
                            'colSize' => 6,
                            'labelName' => 'Image',
                            'fieldType' => 'file',
                            'nameData' => 'image',
                            'placeholderData' => null,
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
