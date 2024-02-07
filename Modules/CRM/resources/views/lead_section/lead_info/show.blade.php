@extends('crm.lead_section.layout')
@section('lead_details')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>{{ __('file.Lead Info') }}</h3>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Company</th>
                            <td>{{ $lead->company->company_name }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ ucfirst($lead->status) }}</td>
                        </tr>
                        <tr>
                            <th>Owner</th>
                            <td>{{ $lead->owner->first_name.' '.$lead->owner->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{ $lead->country->name}}</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>{{ $lead->city}}</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>{{ $lead->state}}</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>{{ $lead->zip}}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $lead->address}}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $lead->phone}}</td>
                        </tr>
                        <tr>
                            <th>Website</th>
                            <td>{{ $lead->website}}</td>
                        </tr>
                        <tr>
                            <th>Vat Number</th>
                            <td>{{ $lead->vat_number}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
