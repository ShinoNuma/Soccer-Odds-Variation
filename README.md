# Soccer Odds Variation
A simple bot that allows you to extract automatically (or manually) soccer odds from the most popular betting wesite (betclick, bwin, winamax, etc...) of the most important soccer leagues in Europe (Premier League, Ligue 1, Ligue 2, Bundesliga, La Liga, Primeira Liga and the Serie A). You can also import the data into a CSV file. 

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
$ php seed.php
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

### __TODO

I'm currently working on scrapping the statistics of each games after each games automatically (using a cron) so don't be surprise if you see a column `get_stat` (booleen) in each tables because I use it for check if I've already extract the statistics for this game.
