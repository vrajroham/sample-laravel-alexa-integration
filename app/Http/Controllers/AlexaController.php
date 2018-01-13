<?php

namespace App\Http\Controllers;

use Develpr\AlexaApp\Facades\Alexa;
use Develpr\AlexaApp\Response\AlexaResponse;
use Develpr\AlexaApp\Response\Directives\Dialog\Delegate;
use Develpr\AlexaApp\Response\Directives\AudioPlayer\Play;
use Develpr\AlexaApp\Response\Reprompt;
use Develpr\AlexaApp\Response\Speech;
use Develpr\AlexaApp\Response\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Artisan;

class AlexaController extends Controller
{
    public function start(Request $request)
    {
    	$message = "Welcome!";
        return Alexa::say($message)
            ->withCard(new Card('Internal', 'Summary', $message))
            ->withReprompt(new Reprompt("I didn't understand what you said.  What you would like to do?"))
            ->endSession(false);
    }

    public function greetingsIntent()
    {
    	$message = "Welcome!";
        $alexaResponse = new AlexaResponse;

        $alexaResponse->withSpeech(new Speech("Episode 79 with Kent C Dodds! Building Reusable React Components with Render Props."));
        $alexaResponse->withAudio(new Play('https://audio.simplecast.com/f2e65eaf.mp3'));

        return $alexaResponse;
    }

    public function stop()
    {
        $message = "Bye";
        return Alexa::say($message)->endSession(true);
    }

    public function help()
    {
        $message = "Helping";
        return Alexa::say($message)
            ->withCard(new Card('Internal', 'Summary', $message))
            ->withReprompt(new Reprompt("Helping You"))
            ->endSession(false);
    }

    public function makeBackup()
    {
        if (Alexa::slot('what') != null) {
            $exitCode = 0 ; // Make backup
            if ($exitCode === 0) {
                return Alexa::say("Backup successful! Notification is on the way.");
            }else{
                return Alexa::say("Sorry! Error occurred win backup script.");
            }
        }else{
            if (array_get(Alexa::request(), 'request.dialogState') == 'STARTED' || array_get(Alexa::request(), 'request.dialogState') == 'IN_PROGRESS') {
                return (new AlexaResponse())->endSession(false)->withDirective(new Delegate());
            }
            return Alexa::say("I didn't understand what you said");
        }
    }
}
