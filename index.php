<?php
error_reporting(E_ALL);
ini_set('display_errors',true);
require_once('vendor/autoload.php');
require_once('hutomo.php');

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\DoctrineCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\CiscoSpark\CiscoSparkDriver;
use Doctrine\Common\Cache\FilesystemCache;
use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

// Explicitly load Cisco Spark driver
DriverManager::loadDriver(CiscoSparkDriver::class);

$cache = __DIR__ . '/cache/';
if (!is_dir($cache)) {
	mkdir($cache, 0777);
}
$cacheDriver = new FilesystemCache('cache');

$botman = BotManFactory::create([
	'cisco-spark' => [
		'token' => getenv('CISCO_SPARK_TOKEN')
	]
], new DoctrineCache($cacheDriver));

// Conversations
$botman->hears('are you there|hi|yo|whatsup|my man', function($bot) {
	$bot->startConversation(new Hutomo());
});

// $hutomo = new Hutomo();
// $botman->hears('(.*)',function($bot,$question){
// 		$bot->reply($question);
// 	$bot->
//     if(strtolower($question)!='bye') {
// 				$bot->reply('this is the new script');
//         $bot->reply($hutomo->requestQuestion($question));
//     }else{
//         $bot->reply('Thanks for chatting with me.');
//     }
// });

$botman->listen();
