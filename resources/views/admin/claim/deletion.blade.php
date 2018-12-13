@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row" style="margin-bottom: 1vw;">
            <div class="col-sm-12">My claims</div>
        </div>
        <div class="row" style="margin-bottom: 2vw;">
            <div class="col-sm-2">Site</div>
            <div class="col-sm-2">Zone</div>
            <div class="col-sm-3">Target user</div>
            <div class="col-sm-3">Claim date</div>
            <div class="col-sm-2">Delete</div>
        </div>
        @foreach($myClaims as $claim)
            <div class="row" data-claim_id="{{ $claim->id }}">
                <div class="col-sm-2">{{ $claim->site_name }}</div>
                <div class="col-sm-2">{{ $claim->zone_name }}</div>
                <div class="col-sm-3">{{ $claim->firstname . " " . $claim->lastname }}</div>
                <div class="col-sm-3">{{ $claim->claim_date }}</div>
                <div class="col-sm-2"><button class="btn btn-danger" onclick="deleteClaimHandler(this)">Delete</button></div>
            </div>
        @endforeach
        <div class="row" style="margin-bottom: 1vw;">
            <div class="col-sm-12">Claimed for me</div>
        </div>
        <div class="row" style="margin-bottom: 2vw;">
            <div class="col-sm-2">Site</div>
            <div class="col-sm-2">Zone</div>
            <div class="col-sm-3">Target user</div>
            <div class="col-sm-3">Claim date</div>
            <div class="col-sm-2">Delete</div>
        </div>
        @foreach($targetClaims as $claim)
            <div class="row" data-claim_id="{{ $claim->id }}">
                <div class="col-sm-2">{{ $claim->site_name }}</div>
                <div class="col-sm-2">{{ $claim->zone_name }}</div>
                <div class="col-sm-3">{{ $claim->firstname . " " . $claim->lastname }}</div>
                <div class="col-sm-3">{{ $claim->claim_date }}</div>
                <div class="col-sm-2"><button class="btn btn-danger" onclick="deleteClaimHandler(this)">Delete</button></div>
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
        var deleteClaimHandler = (obj, canApprove) => {
            if(typeof canApprove == 'undefined'){
                $('.modalDeleteButton').text("Delete").removeClass('btn-success').addClass('btn-danger').unbind( "click" ).on('click', () => deleteClaimHandler(obj, true));
                //$('#myModal').modal('show');
            } else {
                $.ajax({
                    url: "/claim/delete-claim",
                    method: "POST",
                    data: {
                        claim_id: $(obj).closest('div.row').data('claim_id')
                    },
                    success: data => {
                        console.log(data);
                        //$(obj).siblings('button').prop('disabled', false);
                        //$(obj).prop('disabled', true);
                        //$(obj).parent().siblings('.stateDiv').text(data.text);
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
    </script>
@endsection