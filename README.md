# ScoreLens
This is a convenient and easy to use API for creating scoreboards. Works on PocketMine-MP 5

# Using
Example application:

```
if(is_null($board = ScoreBoard::create($player, [
    2 => "§aName:§f " . $player->getName(),
    3 => "§acreated via",
    4 => "§aScoreLens",
    6 => "§aOnline:§f "  . count(Server::getInstance()->getOnlinePlayers()),
    7 => "§gYour website"
    ])))
{
  return;
}

$board->setName("§l§cTest§fName");
$board->show();
```


Result:

![image](https://github.com/OneBeuHu/ScoreLens/assets/109813776/bc3d7904-4cc3-4a3c-8317-a3588d698058)


How to update:
Create a task in which you will send the players scorboards, it is convenient because of the fact that you can choose your own time update.


![image](https://github.com/OneBeuHu/ScoreLens/assets/109813776/d3646aa6-70a9-493c-8f12-6ae828fff4ed)





# Commands

board - Hide or show the scoreboard, also has a sound

![image](https://github.com/OneBeuHu/ScoreLens/assets/109813776/6b121cc0-28e5-4e84-91b8-fb6994d5eb6f)

