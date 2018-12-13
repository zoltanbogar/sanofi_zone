@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 siteList">
                <div>List</div>
                <div class="container-fluid">
                    @foreach($zones as $zone)
                        <div class="row">
                            <div class="col-sm-3">
                                <span class="zone_name" zone_id="{{ $zone->id }}">{{ $zone->name }}</span>
                            </div>
                            <div class="col-sm-3">
                                @foreach($zone->userManyRelation as $user)
                                    {{ $user->fullname }}
                                @endforeach
                            </div>
                            <div class="col-sm-3">
                                <span>{{ $zone->site->name }}</span>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-default" onclick="deleteZoneHandler(this)">
                                    <i class="glyphicon glyphicon-minus"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-6">
                <div>New</div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="new_zone_name">Name:</label>
                            <input type="text" class="form-control newZoneName" name="new_zone_name" />
                        </div>
                        <div class="col-sm-4">
                            <label for="new_zone_parent">Belongs to:</label>
                            <select class="form-control parentSelector btn-group" name="new_zone_parent">
                                @foreach($sites as $site)
                                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="new_zone_person">Person:</label>
                            <select class="form-control personSelector btn-group" name="new_zone_person" multiple>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->firstname . " " . $user->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" style="text-align: center;">
                            <button class="btn btn-default" onclick="submitFormHandler()">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

    <link rel="stylesheet" href="{{ asset('css/snackbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.css') }}" />
    <style>

    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/snackbar.js') }}"></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
    <script>
        $(document).ready(() => {
            $('.personSelector').multiselect({
                numberDisplayed: 1,
                enableFiltering: true,
                maxHeight: 200,
                enableCaseInsensitiveFiltering: true,
                /*onChange: function(option, checked) {
                    alert(option.length + ' options ' + (checked ? 'selected' : 'deselected'));
                }*/
            });

            $('.parentSelector').multiselect({
                numberDisplayed: 1,
                enableFiltering: true,
                maxHeight: 200,
                enableCaseInsensitiveFiltering: true,
                /*onChange: function(option, checked) {
                    alert(option.length + ' options ' + (checked ? 'selected' : 'deselected'));
                }*/
            });
        });

        var submitFormHandler = () => {
            $.ajax({
                url: "/unit/new-zone",
                method: "POST",
                data: {
                    zone_name: $('.newZoneName').val()
                    , parent_id: $('.parentSelector').val()
                    , person_id: $('.personSelector').val()
                },
                success: data => {
                    console.log(data);
                    Snackbar.show({text: data.success, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'/*, onClose: () => {window.location = '/unit/zone';}*/ });
                },
                error: error => {
                    Snackbar.show({text: error.status + ' - ' + error.responseText, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'});
                }
            });
        };

        var deleteZoneHandler = (obj, canDelete) => {
            if(typeof canDelete == 'undefined'){
                $('.modalDeleteButton').on('click', () => deleteZoneHandler(obj, true));
                //$('#myModal').modal('show');
            } else {
                $.ajax({
                    url: "/unit/remove-zone",
                    method: "POST",
                    data: {
                        zone_id: $(obj).closest('div.row').find('.zone_name').attr('zone_id')
                    },
                    success: data => {
                        console.log(data);
                        $(obj).closest('div.row').remove();
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