@extends('layouts.app')

@section('content')
    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.11';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <div class="container" id="app" ng-app="quiz" ng-controller="quizCtrl as ctrl">
        <div class="row" ng-show="stage == 0">
            <div class="col-md-12 col-lg-12 col-md-offset-1 col-lg-offset-1">
                <form ng-submit="stage = 1">
                    <div class="form-group">
                        <label for="language">
                            <h3>@{{ data.lang.ques }}</h3>
                        </label>
                        <select class="form-control"
                                id="language"
                                name="language"
                                required
                                ng-model="answers.lang"
                                ng-init="answers.lang = data.lang.options[0].value"
                                ng-options="option.key for option in data.lang.options track by option.value"
                                required
                                ng-change="updateLanguage()"
                        >
                            <option value="">-- Select Language --</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">@{{ data.lang.button }}</button>
                </form>
            </div>
        </div>

        <div class="row" ng-show="stage == 1">
            <div class="col-md-12 col-lg-12 col-md-offset-1 col-lg-offset-1">
                <form ng-submit="stage = 2">
                    @foreach($data['user']['ques'] as $question)
                        <div class="form-group">
                            <label for="{{ $question['id'] }}">{{ $question['text'] }}</label>
                            <input type="{{ $question['type'] }}"
                                   class="form-control"
                                   id="{{ $question['id'] }}"
                                   ng-model="answers.{{ $question['id'] }}"
                                   placeholder="{{ $question["placeholder"] }}"
                                   required
                            >
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary btn-block">@{{ data.lang.button }}</button>
                </form>
            </div>
        </div>

        @foreach($data['questions'] as $key => $question)
            <div class="row" ng-show="stage == {{ 2 + $key }}">
                <div class="col-md-12 col-lg-12 col-md-offset-1 col-lg-offset-1">
                    <h3>{{ $data['static']['questions-title'] }}</h3>
                    <br>

                    <h6>{{ $question['counter'] }}</h6>
                    <h5>{{ $question['text'] }}</h5>
                    @foreach($question['options'] as $option)
                        <button class="btn btn-block btn-primary"
                                id="option-{{ $option['value'] }}"
                                ng-click="answers.{{ "question".(1 + $key) }} = '{{ $option['value'] }}'; updateStage({{ 3 + $key }})">
                            {{ $option['text'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="row" ng-show="stage == {{ 2 + count($data['questions']) }}">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-md-offset-1 col-lg-offset-1" ng-show="loading">
                    <div id="loading">
                        <ul class="bokeh">
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-md-offset-1 col-lg-offset-1" ng-show="somethingWentWrong">
                    <h2>Something Went Wrong, please try again after 5 minutes.</h2>
                    <a class="btn btn-block btn-primary" href="{{ url('/') }}">
                        Try Again
                    </a>
                </div>
                @if(isset($record))
                    <div class="col-md-12 col-lg-12 col-md-offset-1 col-lg-offset-1" ng-show="linkGenerated">
                        <h2>{{ $data['static']['start-my-own'] }}</h2>
                        <a href="{{ url('/') }}">
                            <button class="btn btn-block btn-primary">
                                {{ $data['static']['click-here'] }}
                            </button>
                        </a>
                    </div>
                @else
                    {{-- if user is trying for him/her self. --}}
                    <div class="col-md-12 col-lg-12 col-md-offset-1 col-lg-offset-1" ng-show="linkGenerated">
                        <h2>...</h2>
                        <div class="form-group">
                            <input type="text"
                                   class="form-control"
                                   id="sharelink"
                                   readonly>
                        </div>

                        <div class="fb-share-button" data-href="http://personality.dev/0" data-layout="button"
                             style="margin: 5px;"
                             data-size="large" data-mobile-iframe="true">
                            <a class="fb-xfbml-parse-ignore" target="_blank" id="facebooksharelink"
                               href="#">Share</a>
                        </div>

                        <a href="#" id="whatsappsharelink">
                            <img src="{{ asset('images/whatsapp.png') }}" alt="" width="80px">
                        </a>

                        <h2>{{ $data['static']['result'] }}</h2>
                    </div>
                @endif


                <div class="col-md-12 col-lg-12 col-md-offset-1 col-lg-offset-1">

                    @if(isset($record))
                        <p>
                            <b>What do {{ $record['name'] }} think his personalty is</b>
                        </p>
                        <p><span>{{ $data['answers'][$record['result']]['text'] }}</span></p>

                        <hr>
                        <p>
                            <b>What do you think of {{ $record['name'] }}</b>
                        </p>
                        <p><span id="personalty"></span></p>

                    @else
                        <p>
                            <b>What is your personality.</b>
                        </p>
                        <p><span id="personalty"></span></p>

                    @endif

                    @if(isset($others))
                        @if(isset($record))
                            <h3>{{ $data['static']['friends-result-for-friend'] }}</h3>
                            @foreach($others as $other)
                                <p>{{ $data['answers'][$other['result']]['text'] }}</p>
                            @endforeach
                        @else
                            <h3>{{ $data['static']['friends-result-for-me'] }}</h3>
                            @foreach($others as $other)
                                <p>{{ $data['answers'][$other['result']]['text'] }}</p>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script>
        var data = {!! json_encode($data) !!};
        var record = {!! (isset($record) ? json_encode($record) : "false") !!};
        var stage = {{ ((isset($lang) && $lang) || (isset($record) && $record)) ? 1 : 0 }};
    </script>

    <script>
        var app = angular.module('quiz', []);

        app.controller('quizCtrl', ['$scope', '$http', function ($scope, $http) {
            $scope.stage = stage;
            $scope.answers = {};
            $scope.data = data;
            $scope.record = record;
            $scope.loading = true;
            $scope.somethingWentWrong = false;
            $scope.linkGenerated = false;
            $scope.result = "";

            @if(isset($lang) && $lang)
                $scope.answers.lang = "{{ $lang }}";
            @endif

            if (Cookies.get('myid') === window.location.href.split("/")[3]) {
                $scope.stage = 2 + data.questions.length
                $scope.loading = false;
                // $scope.$apply()
            }

            if (record) {
                $scope.answers.for = record.id
            }

            $scope.question = {
                success: false,
                failure: false
            };

            $scope.updateLanguage = function() {
                console.log('language', $scope.answers.lang);

                window.location = "{{ url('/') }}/" + $scope.answers.lang.value;
            };

            $scope.updateStage = function (stage) {

                var answerId = "question" + (stage - 2);
                var answer = "";
                var questionId = stage - 3;
                Object.keys($scope.answers).forEach(function (key) {
                    if (key === answerId) {
                        answer = $scope.answers[answerId]
                    }
                });

                if ($scope.record) {

                    if (data.questions[questionId].answ === answer) {
                        $("#option-" + answer).removeClass("btn-primary").addClass("btn-success").addClass("disabled");
                    } else {
                        $("#option-" + data.questions[questionId].answ).removeClass("btn-primary").addClass("btn-success").addClass("disabled");
                        $("#option-" + answer).removeClass("btn-primary").addClass("btn-danger").addClass("disabled");
                    }
                } else {
                    $("#option-" + answer).removeClass("btn-primary").addClass("btn-success").addClass("disabled");
                }

                if (stage === (2 + data.questions.length)) {
                    $http.post('{{ url() }}', $scope.answers).then(function (response) {

                        if (! $scope.answers.for) {
                            Cookies.set("myid", response.data.id, { expires: 300 });
                        }

                        $scope.loading = false;
                        $scope.linkGenerated = true;

                        var facebookUrl = "https://www.facebook.com/sharer/sharer.php?u=" + response.data.url + "&src=sdkpreparse";
                        $("#facebooksharelink").attr('href', facebookUrl);

                        var whatsappshareUrl = "whatsapp://send?text=" + "Test Your Bond with " + $scope.answers.name + " " + response.data.url;
                        $("#whatsappsharelink").attr('href', whatsappshareUrl);

                        $("#sharelink").val(response.data.url);
                        $("#personalty").text(response.data.result.text);

                        console.log(response, response.data);
                    }, function (error) {
                        $scope.loading = false;
                        $scope.somethingWentWrong = true;

                        console.log(error);
                    });
                }

                setTimeout(function () {
                    $scope.stage = stage;
                    $scope.$apply();
                }, 1000);
            };

            console.log(data);
        }]);
    </script>

@endsection