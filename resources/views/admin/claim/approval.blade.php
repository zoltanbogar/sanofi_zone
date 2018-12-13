@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-1">Zone</div>
            <div class="col-sm-1">Target person</div>
            <div class="col-sm-3">Interval</div>
            <div class="col-sm-3">Claimed at</div>
            <div class="col-sm-1">Job Type</div>
            <div class="col-sm-1">My decision</div>
            <div class="col-sm-1"></div>
        </div>
        @foreach($zones as $zone)
            <div class="row" claim_id="{{ $zone->claim_id }}">
                <div class="col-sm-1">{{ $zone->name }}</div>
                <div class="col-sm-1">{{ $zone->firstname . " " . $zone->lastname }}</div>
                <div class="col-sm-3">{{ $zone->authorized_from . " - " . $zone->authorized_to }}</div>
                <div class="col-sm-3">{{ $zone->claim_date }}</div>
                <div class="col-sm-1">{{ $zone->job_type }}</div>
                <div class="col-sm-1 stateDiv">
                    @if($zone->approved_claims_created_at != NULL)
                        Approved
                    @elseif($zone->rejected_claims_created_at != NULL)
                        Rejected
                    @Else
                        Not decided
                    @endif
                </div>
                <div class="col-sm-1">
                    @if($zone->approved_claims_created_at != NULL)
                        @php
                            $buttonState = "disabled"
                        @endphp
                    @else
                        @php
                            $buttonState = ""
                        @endphp
                    @endif
                    <button class="btn btn-success" onclick="approveClaimHandler(this)" {{ $buttonState }}>Approve</button>

                    @if($zone->rejected_claims_created_at != NULL)
                        @php
                            $buttonState = "disabled"
                        @endphp
                    @else
                        @php
                            $buttonState = ""
                        @endphp
                    @endif
                    <button class="btn btn-danger" onclick="rejectClaimHandler(this)" {{ $buttonState }}>Decline</button>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-content">
            <div class="modal-header alert-info">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Warning</h4>
            </div>
            <div class="modal-body">
                <div>Are you sure?</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger modalDeleteButton">Delete</button>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/snackbar.css') }}">

@endsection

@section('scripts')
    <script src="{{ asset('js/snackbar.js') }}"></script>
    <script>
        var approveClaimHandler = (obj, canApprove) => {
            if(typeof canApprove == 'undefined'){
                $('.modalDeleteButton').text("Approve").removeClass('btn-danger').addClass('btn-success').unbind( "click" ).on('click', () => approveClaimHandler(obj, true));
                //$('#myModal').modal('show');
            } else {
                $.ajax({
                    url: "/claim/approve-claim",
                    method: "POST",
                    data: {
                        claim_id: $(obj).closest('div.row').attr('claim_id')
                    },
                    success: data => {
                        console.log(data);
                        $(obj).siblings('button').prop('disabled', false);
                        $(obj).prop('disabled', true);
                        $(obj).parent().siblings('.stateDiv').text(data.text);
                        //$(obj).closest('div.row').remove();
                        Snackbar.show({text: data.success, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'/*, onClose: () => {window.location = '/unit/zone';}*/ });
                    },
                    error: error => {
                        Snackbar.show({text: error.status + ' - ' + error.responseText, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'});
                    }
                });
            }
            $('#myModal').modal('toggle');
        };

        var rejectClaimHandler = (obj, canReject) => {
            if(typeof canReject == 'undefined'){
                $('.modalDeleteButton').text("Reject").removeClass('btn-success').addClass('btn-danger').unbind( "click" ).on('click', () => rejectClaimHandler(obj, true));
                //$('#myModal').modal('show');
            } else {
                $.ajax({
                    url: "/claim/reject-claim",
                    method: "POST",
                    data: {
                        claim_id: $(obj).closest('div.row').attr('claim_id')
                    },
                    success: data => {
                        //$(obj).siblings('button').prop('disabled', 'false');
                        $(obj).siblings('button').prop('disabled', false);
                        $(obj).prop('disabled', true);
                        $(obj).parent().siblings('.stateDiv').text(data.text);
                        //$(obj).prop('disabled', 'true');
                        Snackbar.show({text: data.success, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'/*, onClose: () => {window.location = '/unit/zone';}*/ });
                    },
                    error: error => {
                        Snackbar.show({text: error.status + ' - ' + error.responseText, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'});
                    }
                });
            }
            $('#myModal').modal('toggle');
        };
    </script>
@endsection