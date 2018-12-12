@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 siteList">
                <div>List</div>
                {!! $data !!}
            </div>
            <div class="col-sm-6">
                <div>New</div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="new_site_name">Name:</label>
                            <input type="text" class="form-control newSiteName" name="new_site_name" />
                        </div>
                        <div class="col-sm-6">
                            <label for="new_site_parent">Belongs to:</label>
                            <select class="form-control parentSelector" name="new_site_parent">
                                <option value="0">Individual site</option>
                                @foreach($sites as $site)
                                    <option value="{{ $site->id }}">{{ $site->name }}</option>
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
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/snackbar.css') }}">
    <style>
        li {
            list-style: none;
        }

        button {
            margin: 10px;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/snackbar.js') }}"></script>
    <script>
        var toggleUnitHandler = obj => {
            var objButtonIcon = $(obj)
                .children('i');
            if(objButtonIcon.hasClass('glyphicon-arrow-down')){
                objButtonIcon
                    .addClass('glyphicon-arrow-up')
                    .removeClass('glyphicon-arrow-down');
                $(obj).siblings('ul').children('li').removeClass('hidden');
            } else {
                objButtonIcon
                    .addClass('glyphicon-arrow-down')
                    .removeClass('glyphicon-arrow-up');
                $(obj)
                    .siblings('ul')
                    .find('li')
                    .addClass('hidden');
                $(obj)
                    .siblings('ul')
                    .find('.glyphicon-arrow-up')
                    .removeClass('glyphicon-arrow-up')
                    .addClass('glyphicon-arrow-down');
            }
        };

        var deleteUnitHandler = obj => {
            $.ajax({
                url: "/unit/remove-site",
                method: "POST",
                data: {
                    site_id: $(obj).siblings('span').attr('site_id')
                },
                success: data => {
                    $(obj).parent('li').remove();
                    Snackbar.show({text: data.success, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'/*, onClose: () => {window.location = '/unit/site';}*/ });
                },
                error: error => {
                    Snackbar.show({text: error.status + ' - ' + error.responseText, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'});
                }
            });
        };

        var submitFormHandler = () => {
            $.ajax({
                url: "/unit/new-site",
                method: "POST",
                data: {
                    site_name: $('.newSiteName').val()
                    , parent_id: $('.parentSelector').val()
                },
                success: data => {
                    console.log(data);
                    Snackbar.show({text: data.success, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px', onClose: () => {window.location = '/unit/site';} });
                },
                error: error => {
                    Snackbar.show({text: error.status + ' - ' + error.responseText, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'});
                }
            });
        };

        var clearButtons = () => {
            $.each($('.siteList').find('li'), (i, e) => {
                if($(e).children('ul').length === 0){
                    $(e).children('button.toggleButton').css('visibility', 'hidden');
                }
            });
        };
        clearButtons();
    </script>
@endsection