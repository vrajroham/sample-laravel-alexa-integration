<?php

AlexaRoute::launch('/alexa', '\App\Http\Controllers\AlexaController@start');

 AlexaRoute::sessionEnded('/alexa', function () {
     return '{"version":"1.0","response":{"shouldEndSession":true}}';
 });

AlexaRoute::intent('/alexa', 'greetings', '\App\Http\Controllers\AlexaController@greetingsIntent');
// AlexaRoute::intent('/alexa', 'AMAZON.PauseIntent', '\App\Http\Controllers\AlexaController@pause');
AlexaRoute::intent('/alexa', 'AMAZON.StopIntent', '\App\Http\Controllers\AlexaController@stop');
AlexaRoute::intent('/alexa', 'AMAZON.HelpIntent', '\App\Http\Controllers\AlexaController@help');
AlexaRoute::intent('/alexa', 'backup', '\App\Http\Controllers\AlexaController@makeBackup');