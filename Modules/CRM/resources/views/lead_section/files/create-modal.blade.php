
<!--Create Modal -->
<div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"> {{ __('file.Add File') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('lead.files.store', ['lead' => $lead->id]) }}" id="submitForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{trans('file.Title')}} *</label>
                                <input type="text" name="file_title" id="file_title" required
                                    class="form-control"
                                    placeholder="{{trans('file.Title')}}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{trans('file.Description')}}</label>
                                <textarea required class="form-control" id="file_description"
                                        name="file_description" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{trans('file.Attachments')}} </label>
                                <input type="file" name="file_attachment" id="file_attachment"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="submitButton">@lang('file.Save')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
