# BotMan + Cisco Spark + Hutomo.ai

This project helps you to integrate Hutomo.ai bot into your favourite chat program (Cisko Spark, Slack, etc).

It uses BotMan framework to wrap all the commands and outputs.

## Installation with Cisko Spark

- Clone this repository.
- `composer install`
- Copy the `.env.example` file to `.env`.
- Create a Cisco Spark Bot and paste the access token into your `.env` file.
- Use Laravel Valet or ngrok to create a local tunnel to the folder containing the `index.php` file.
- Create a Cisco Spark Webhook with the created URL:

Just replace `--YOUR-AUTHORIZATION-TOKEN--` with your token and `--YOUR-URL--` with your bot URL.

Add `--HUTOMO_CLIENT_KEY--` with your Hutomo.ai Client Key, found under settings of your Hutomo.ai bot.

Add `--HUTOMO_BOT_ID--` with your Hutomo.ai Bot ID, found under settings of your Hutomo.ai bot.

```bash
curl -X POST -H "Accept: application/json" -H "Authorization: Bearer --YOUR-AUTHORIZATION-TOKEN--" -H "Content-Type: application/json" -d '{
	"name": "BotMan Webhook",
	"targetUrl": "--YOUR-URL--",
	"resource": "all",
	"event": "all"
}' "https://api.ciscospark.com/v1/webhooks"
```

Now you can write your bot. 

To start a conversation, write `hey`.

See `index.php` and `hutomo.php` for available commands and how conversations work.

---

Find more information about BotMan framework:
[BotMan](https://github.com/botman/botman)

Find more information about Hutomo.ai bots: 
[Hutomo.ai](https://hutomo.ai/)

Find more information about integrations into Cisko Spark:
[Cisko Spark](https://www.ciscospark.com/)

Find more information about integrations into Slack:
[Slack](https://slack.com/)