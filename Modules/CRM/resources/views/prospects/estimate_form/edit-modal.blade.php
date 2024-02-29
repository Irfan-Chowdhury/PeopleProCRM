<!--Edit Modal -->
<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"> {{ __('file.Edit Estimate') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="updateForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="modelId">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Title')}} <span class="text-danger">*</span></strong></label>
                                <input type="text" required class="form-control" name="title">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Status')}} <span class="text-danger">*</span></strong></label>
                                <select name="status"
                                        required
                                        class="form-control selectpicker"
                                        title="{{__('Selecting',['key'=>trans('file.Status')])}}...">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <div class="form-group form-check">
                                <label class="form-check-label">
                                  <input class="form-check-input" name="is_public" type="checkbox"> <b>Public</b>
                                </label>
                              </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-bold"><strong>{{trans('file.Description')}}</strong></label>
                                <textarea name="description" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" id="updateButton">@lang('file.Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>
