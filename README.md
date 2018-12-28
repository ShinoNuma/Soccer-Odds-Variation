# Soccer Odds Variation
A simple bot that allows you to extract automatically (or manually) soccer odds from the most popular betting wesite (betclick, bwin, winamax, etc...) of the most important soccer leagues in Europe (Premier League, Ligue 1, Ligue 2, Bundesliga, La Liga, Primeira Liga and the Serie A). You can also import the data into a CSV file. 

**NEW:** Now it's possible to get the statistics of the match (score, score half time, scorers, possession, shot, shot framed, player, player age, and many others stats) when the match is over.


**NOTE:** Tested with PHP 7.2

### Requirements

* PHP 7.x
* MySQL or MariaDB

### Installation

_[GIT Clone]_

In your `www` directory type:

```shell
git clone -b master git://github.com/ShinoNoNuma/Soccer-Odds-Variation.git soccer-bot
```

### Usage

Set your database information into `config.php`.

```php
  //base URL can be custom
  public $base_url = 'http://localhost/soccer-bot/';
  
  public $default = array(
        'host'        => '127.0.0.1',
        'login'       => 'root',
        'password'    => '',
        'database'    => 'soccer_bot'
  );
```
Then, use `seed.php` for create the database and tables needed.

```shell
$ php seed-odds.php
```

### Odds Scrapping (Shell)

To get all the odds from the current games we will use the file `bot-odds.php` which will be followed by a parameter to tell him for which league we are targeting.
The parameter can be: `premierleague`, `ligue1`, `ligue2`, `bundesliga`, `laliga`, `primeiraliga` or `seriea`
For example:

```shell
$ php bot-odds.php bundesliga
```
**NOTE:** You can also create a cron task to automate the scrapping because the odds vary during the day and much more on the day of the game

### Odds Scrapping (Manual)
A web page is also available to extract the odds using a button and you can also download your data in a CSV file.
If you wanna check go to http://localhost/scoccer-bot

### Statistics Scrapping (Shell)

Recently, it's possible to get the statistics of the match when the match is over, for this we need to install the associated tables.

```shell
$ php seed-stats.php
```
Then, we can get the statistics of the matches that were previously retrieved with the script `bot-odds.php`.
The script `bot-stats.php` will automatically see the match that are finished and retrieve the statics of the match.
The parameters are same than the first script: `premierleague`, `ligue1`, `ligue2`, `bundesliga`, `laliga`, `primeiraliga` or `seriea`.

```shell
$ php bot-stats.php ligue1
```
**NOTE:** As I said, it work only if you already have some odds in you databse and the matches need to over.


