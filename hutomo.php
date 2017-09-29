<?php

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Http\Curl;
use BotMan\BotMan\Interfaces\HttpInterface;

class Hutomo extends Conversation
{
    private $http = false;
    private $chatId = false;
    private $hutomaURL = 'https://api.hutoma.ai/v1/ai/{botId}/chat';

    public function requestQuestion($question){
        $this->hutomaURL = str_replace('{botId}',getenv('HUTOMO_BOT_ID'),$this->hutomaURL);
        $get["q"] = $question;
        $headers[] = "Authorization: Bearer " . getenv('HUTOMO_CLIENT_KEY');
        if($this->chatId){
            $get['chatId'] = $this->chatId;
        }
        if(!$this->http) {
            $this->http = new Curl();
        }
        $hutoma = $this->http->get($this->hutomaURL,$get,$headers,true);
        $hutoma = json_decode($hutoma->getContent());
        if(!$this->chatId && isset($hutoma->chatId)){
            $this->chatId = $hutoma->chatId;
        }
        return $hutoma->result->answer;
    }

    public function run()
    {
        $this->waitResponse('Yo, can I do anything for you?');
    }

    public function waitResponse($nextQuestion){

        $this->ask($nextQuestion, function($question) {
            if(strtolower($question)!='no'
                && strtolower($question)!='bye'
                && strtolower($question)!='cheerz'
                && strtolower($question)!='cheers'
                && strtolower($question)!='bye bye'
                && strtolower($question)!='no thanks'
                && strtolower($question)!='no thank you') {
                $doRespond = true;
                $this->bot->typesAndWaits(3);
                $response = $this->requestQuestion($question->getText());
                if(strstr(strtolower($response),'enter')
                    || strstr($response,'?')){
                    $doRespond = false;
                }
                $this->say($response);
                $this->bot->typesAndWaits(3);
                $this->waitResponse((!$doRespond?'':'Anything else?'));
            }else{
                $this->bot->typesAndWaits(3);
                $this->say('Thanks for chatting with me.');
                $this->bot->typesAndWaits(3);
                $this->say('Make sure to contact me again if you need anything!');
            }
        });
    }

}