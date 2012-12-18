FMSteamcondenserBundle
======================

Add some Steam[http://steampowered.com] to your Symfony 2 project!

This bundle allows you to query game servers, getting information about players/Steam users, getting server information,
such as current player list and etc.
Bundle depends on [Steam Condenser](/koraktor/steam-condenser-php ) library by [Sebastian Staudt](/koraktor)

This Bundle status is WIP (work in progress)
# Installation

To install this bundle, you'll need both the [Steam Condenser](/koraktor/steam-condenser-php )
and this bundle.

## Step 1: Installation

Using Composer, just add the following configuration to your `composer.json`:

```json
{
    "require": {
        "helios-ag/fm-steamcondenser-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update helios-ag/fm-steamcondenser-bundle
```

## Step 2: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FM\SteamcondenserBundle\FMSteamcondenserBundle(),
    );
}
```


# Configuration

Before using this you need to configure bundle:

```yaml
fm_steamcondenser:
  server_list:
    my_server:
      address: 127.0.0.1
      port: 27015
      password: passw0rd
      source: true
```
Under server_list node, you can define multiple servers.
Each server has address - an ip address of the server,
and port. Password field used to set Rcon (remote console) password. Source option, defines, is server uses source based
engine or not (games like Team Fortress 2, Half-Life 2, CS:S and many others Valve games, but not Half-Life 1, CS 1.6)

##Command line tools

Bundle provide some useful CLI commands, to survey servers, get information about steam users,

### Rcon command

```bash
php app/console steam:rcon [server] [command]
```

Send rcon command to server, syntax is
[server] - server alias, defined in configuration, for example "my_server"
[command] - command to send

### Server Info Command

```bash
php app/console steam:serverinfo [server] --ip [ip] --port [port] --showplayers
```

Show server information, like server name, game, list current players, ping.
Arguments:
[server] - server alias defined in configuration

Optional parameters:
--ip and --port options can be used to define server explicitly via CLI (in this case you omit server alias)
--showplayers - show current players on server

### User Info Command
```bash
php app/console steam:userinfo [username/steamID]
```

Accept Steam ID (64 bit unique number) or Steam user name

Show username and list of available games. Also shows user current nickname and his online status.

### Server List Command
```bash
php app/console steam:serverlist
```

Show list of defined servers via config.yml



##Services

**Work in progress**

##Twig Extensions

Currently available two twig extensions (actually widgets):

```jinja
 {{steam_server(ip,port,source)}}
```
Show server information. List curent players and etc.
Arguments:
 ip - ip address server
 port - server port
 source - true or false, true if source based server, false otherwise

```jinja
 {{steam_user(steamID || steam name,showgames)}}
```
Show STEAM user information. Avatar and games. Provied link to user profile.
Accept steamID or steam nickname.
Parameters:
showgames - boolean (true||false), specifies show list of games or no, belonged to user.

#Translations

Currently two language supported: English and Russian, feel free to contribute.

