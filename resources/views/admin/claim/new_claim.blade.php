@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3">
                Name of the person claiming the rights
            </div>
            <div class="col-sm-3">
                <input class="form-control" type="text" value="{{ $user->firstname . " " . $user->lastname }}" disabled>
            </div>
            <div class="col-sm-3">
                Name of the person entering the zone
            </div>
            <div class="col-sm-3">
                <input class="form-control" type="text" id="target_person">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                Claimer’s registration number
            </div>
            <div class="col-sm-3">
                <input class="form-control" type="text" value="{{ $user->id }}" disabled>
            </div>
            <div class="col-sm-3">
                Target person’s registration number
            </div>
            <div class="col-sm-3">
                <input class="form-control" type="text" id="target_person_id" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                Name of the organization
            </div>
            <div class="col-sm-3">
                <input class="form-control" type="text" value="Sanofi" disabled>
            </div>
            <div class="col-sm-3">
                Name of the organization
            </div>
            <div class="col-sm-3">
                <input class="form-control" type="text" id="target_person_organization">
            </div>
        </div>
        <!--
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                Time limit for staying within the zone
            </div>
            <div class="col-sm-3">
                <input class="form-control" type="text" id="timeLimit">
            </div>
        </div>
        -->
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                Job / type of activity for which the authorization is required
            </div>
            <div class="col-sm-3">
                <input class="form-control" type="text" name="job_type">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                Date
            </div>
            <div class="col-sm-6">
                <input class="form-control" type="text" {{--value="{{ $time }}"--}} id="claimDate">
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-3">
                <label for="demo">Which zone is required</label>
            </div>
            <div class="col-sm-3" style="display: flex;">
                <input class="form-control" id="demo" name="demo" type="text">
                <button class="btn btn-default addZone"><i class="glyphicon glyphicon-plus"></i></button>
            </div>
            <div class="col-sm-6"></div>
        </div>
        <div class="row container-fluid zoneList"></div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3" style="text-align: center;">
                <button class="btn btn-default" onclick="submitFormHandler()">Submit</button>
            </div>
        </div>
        <div class="row"></div>
        <div class="row"></div>
        <div class="row"></div>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('js/auto-complete.js') }}"></script>
    <script src="{{ asset('js/snackbar.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        var tblAllUser = {!! json_encode($tblAllUser) !!};

        var allUserAutoComplete = new autoComplete({
            selector: '#target_person',
            minChars: 1,
            source: function(term, suggest){
                term = term.toLowerCase();
                var suggestions = [];
                for (i=0;i<tblAllUser.length;i++){
                    var fullName = tblAllUser[i].firstname + ' ' + tblAllUser[i].lastname;
                    if (~fullName.toLowerCase().indexOf(term)) suggestions.push(fullName);
                }
                suggest(suggestions);
            }
        });

        var foo = {!! json_encode($tblAllZone) !!};
        var choices = [];
        var zoness = [];
        console.log(foo);
        $.each(foo, (i,e) => {
            choices.push(e.name);

            //console.log("szedem");

            var arrId = e.user_many_relation.map((user) => user.id);
            var arrName = e.user_many_relation.map((user) => user.firstname + " " + user.lastname);

            var obj = {
                'name': arrName,
                'zone_name': e.name,
                'zone_id': e.id,
                'user_id': arrId,
                'site_id': e.site_name,
                'site_name': e.site.name
            };
            zoness.push(obj);
        });
//console.log(zoness);
        /*console.log(foo, choices);

        var choices = [
            'Bld. DC5 - Office Area'
            , 'Bld. DC5 (E)  – Warehouse area'
            , 'DC5 A (E1) - Computer room'
            , 'DC5 B (E2) - Computer room'
            , 'DC5 A (E1) – Narcotic drug cupboard'
            , 'Minden szerver - nem kábszer'
            , 'P üzem csomagoló'
            , 'Q épület'
            , 'Minden nem szerver- nem kábszer'
            , 'Labor'
            , 'Kábszer raktár'
            , 'R-F épület MEO'
            , 'R- F épület Raktár'
            , 'R épület vészkijárat'
            , 'Raktár váratlan esemény'
            , 'Tűzoltó'
        ];
        console.log(foo, choices);*/
        var removedChoices = [];
        var removedChoicess = [];
        /*var zones = {
            'Bld. DC5 - Office Area': 'Minőségellenőrzés vezető'
            , 'Bld. DC5 (E)  – Warehouse area': 'Raktár vezető'
            , 'DC5 A (E1) - Computer room': 'HSE vezető'
            , 'DC5 B (E2) - Computer room': 'Raktár vezető'
            , 'DC5 A (E1) – Narcotic drug cupboard': 'HSE vezető'
            , 'Minden szerver - nem kábszer': 'Minőségellenőrzés vezető'
            , 'P üzem csomagoló': 'HSE vezető'
            , 'Q épület': 'HSE vezető'
            , 'Minden nem szerver- nem kábszer': 'Raktár vezető'
            , 'Labor': 'HSE vezető'
            , 'Kábszer raktár': 'HSE vezető'
            , 'R-F épület MEO': 'Raktár vezető'
            , 'R- F épület Raktár': 'Minőségellenőrzés vezető'
            , 'R épület vészkijárat': 'HSE vezető'
            , 'Raktár váratlan esemény': 'HSE vezető'
            , 'Tűzoltó': 'Minőségellenőrzés vezető'
        };*/
        var demo = new autoComplete({
            selector: '#demo',
            minChars: 1,
            source: function(term, suggest){
                term = term.toLowerCase();
                var suggestions = [];
                for (i=0;i<zoness.length;i++){
                    if (~zoness[i].zone_name.toLowerCase().indexOf(term)) suggestions.push(zoness[i].zone_name);
                }
                suggest(suggestions);
            }
        });

        $('.addZone').on('click', obj => {
            let inputValue = $('input#demo').val();

            if($.inArray(inputValue, choices) !== -1){
                var zonessKey = getKeyByValue(zoness, inputValue);

                var content = ''+
                '   <div class="row">'+
                '       <div class="col-sm-2 zoneDiv" style="display: flex; justify-content: space-between;">'+
                '           <label for="">Zone:</label>'+
                '           <span class="inputValue" inputValue="'+inputValue+'">' + inputValue + '</span>'+
                '       </div>'+
                '       <div class="col-sm-2 siteDiv" style="display: flex; justify-content: space-between;">'+
                '           <label for="">Site:</label>'+
                '           <span class="inputValue" inputValue="'+zoness[zonessKey].site_name+'">' + zoness[zonessKey].site_name + '</span>'+
                '       </div>'+
                '       <div class="col-sm-3 personDiv" style="display: flex; justify-content: space-between;">'+
                '           <label for="">Authorizing person:</label>'+
                            zoness[zonessKey].name.join(', ')+
                '       </div>'+
                '       <div class="col-sm-3 timeLimitDiv" data-zoneid="'+zoness[zonessKey].zone_id+'" style="display: flex; justify-content: space-between;">'+
                '           <label for="">Time limit for staying within the zone</label>'+
                '           <input class="form-control timeLimit" data-zoneid="'+zoness[zonessKey].zone_id+'" type="text">'+
                '       </div>'+
                '       <div class="col-sm-2">'+
                '           <button class="btn btn-default removeZone" onclick="removeZoneHandler(this)"><i class="glyphicon glyphicon-minus"></i></button>'+
                '       </div>'+
                '   </div>';
                $('.zoneList').append(content);
                $('input#demo').val('');

                var zoneid = getKeyByValue(zoness, inputValue);
                zoneid = zoness[zoneid].zone_id;

                removedChoices.push(inputValue);
                removedChoicess.push(zoneid);
                choices = choices.filter((string) => string !== inputValue);

                demoRefreshHandler();

                initDatepicker(zoness[zonessKey].zone_id);
            } else {
                Snackbar.show({text: 'no valid zone selected', backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'});
            }
        });

        var removeZoneHandler = obj => {
            var objButton = $(obj);

            var choice = objButton
                .parent()
                .siblings('div.zoneDiv')
                .find('span.inputValue')
                .attr('inputValue');

            if($.inArray(choice, choices) === -1 && typeof choice !== 'undefined') choices.push(choice);
            removedChoices = removedChoices.filter((string) => string !== choice);
            removedChoicess = removedChoicess.filter((string) => {
                var zoneid = getKeyByValue(zoness, choice);
                zoneid = zoness[zoneid].zone_id;
                //console.log(string, zoneid);
                return string !== zoneid;
            });
            demoRefreshHandler();
            objButton
                .closest('div.row')
                .remove();
        };

        var demoRefreshHandler = () => {
            demo.destroy();
            demo = new autoComplete({
                selector: '#demo',
                minChars: 1,
                source: function(term, suggest){
                    term = term.toLowerCase();
                    var suggestions = [];
                    for (i=0;i<choices.length;i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);
                }
            });
        };

        var submitFormHandler = () => {
            var arrTimeLimit = {};
            $.each($('.timeLimit'), (i, e) => arrTimeLimit[$(e).data('zoneid')] = {
                    time_limit_from: moment($(e).data('daterangepicker').startDate._d).format('Y-MM-DD HH:mm:ss')
                    , time_limit_to: moment($(e).data('daterangepicker').endDate._d).format('Y-MM-DD HH:mm:ss')
                });

            $.ajax({
                url: "/claim/submit-claim",
                method: "POST",
                data: {
                    claimer_id: {!! $user->id !!}
                    , targer_user_id: $('#target_person_id').val()
                    , job_type: $('input[name="job_type"]').val()
                    , claim_date: moment($('#claimDate').val()).format('Y-MM-DD HH:mm:ss')
                    , zones: removedChoicess
                    , time_limit: arrTimeLimit
                },
                success: data => {
                    console.log(data);
                    Snackbar.show({text: data.success, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px', onClose: () => {window.location = '/claim';} });
                },
                error: error => {
                    console.log(error);
                    Snackbar.show({text: error.status + ' - ' + error.responseText, backgroundColor: '#515aa5', actionTextColor: '#fff', fontFamily: 'Helvetica Neue', duration: 5000, pos: 'bottom-center', borderRadius: '5px'});
                }
            });
        };

        var initDatepicker = (zoneid) => {
            $('.timeLimit').daterangepicker({
                timePicker: true,
                "timePicker24Hour": true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                    format: 'MMMM DD, YYYY hh:mm A'
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                    'Next 7 Days': [moment(), moment().add(6, 'days')],
                    'Next 30 Days': [moment(), moment().add(30, 'days')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Next Month': [moment().endOf('month') + 1, moment().endOf('month').add(1, 'months') ],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Next Year': [moment().endOf('year').add(1, 'second'), moment().endOf('year').add(1, 'years')]
                },
                minDate: moment()
            });
        };

        $('#claimDate').daterangepicker({
            timePicker: true,
            "timePicker24Hour": true,
            singleDatePicker: true,
            startDate: moment(),
            locale: {
                format: 'MMMM DD, YYYY hh:mm A'
            }
        });

        $('#target_person').on('change', () => {
            //console.log($('.autocomplete-suggestion'));
            $.each($('.autocomplete-suggestion'), (i, e) => {
                if($(e).hasClass('selected')){
                    var foo = tblAllUser.filter((user) => {
                        var fullName = user.firstname + ' ' + user.lastname;

                        return fullName === $(e).data().val;
                    });
                    $('#target_person_id').val(foo[0].id);
                    $('#target_person_organization').val('Sanofi');
                }
            });
        });

        var getKeyByValue = (object, value) => {
            return Object.keys(object).find(key => {
                return object[key].zone_name === value;
            });
        };
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auto-complete.css') }}">
    <link rel="stylesheet" href="{{ asset('css/snackbar.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection