@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-1">
                Zone
            </div>
            <div class="col-sm-1">
                Target user
            </div>
            <div class="col-sm-2">
                Authorization interval
            </div>
            <div class="col-sm-2">
                Claim date
            </div>
            <div class="col-sm-2">
                Job type
            </div>
            <div class="col-sm-2">
                Claimer user
            </div>
            <div class="col-sm-2">
                Status
            </div>
        </div>
        @foreach ($tblClaim as $claim)
            <div class="row">
                <div class="col-sm-1">
                    {{ $claim->name }}
                </div>
                <div class="col-sm-1">
                    {{ $claim->firstname . " " . $claim->lastname }}
                </div>
                <div class="col-sm-2">
                    {{ $claim->authorized_from . " - " . $claim->authorized_to }}
                </div>
                <div class="col-sm-2">
                    {{ $claim->claim_date }}
                </div>
                <div class="col-sm-2">
                    {{ $claim->job_type }}
                </div>
                <div class="col-sm-2">
                    {{ $claim->claimer_user_id }}
                </div>
                <div class="col-sm-2">
                    @if($claim->rejected_claims_created_at != NULL)
                        Rejected at {{ $claim->rejected_claims_created_at }}
                    @elseif($claim->approved_claims_created_at != NULL)
                        Approved at {{ $claim->approved_claims_created_at }}
                    @else
                        Pending
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection