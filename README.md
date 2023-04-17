# ScoreLens
This is a convenient and easy to use API for creating scoreboards. Works on PocketMine-MP 4

# Using
Example application:

```
$scoreboard = new ScoreBoard("Test", 8);

$scoreboard->setLine(2, "Hello!");
$scoreboard->setLine(5, "This ScoreBoard");
$scoreboard->setLine(6, "was created");
$scoreboard->setLine(7, "with an ScoreLens");

$scoreboard->sendTo($player);
```


Result:

![image](https://user-images.githubusercontent.com/109813776/213054045-cd7737cf-33a8-443e-bb37-ad091d3aef44.png)

How to update:
Create a task in which you will send the players scorboards, it is convenient because of the fact that you can choose your own time update.


![image](https://user-images.githubusercontent.com/109813776/232541099-58d3d84b-1d65-424d-90cf-7a2337038e3e.png)




As you can see from the photo below - the update is happening


![scorelensuupd](https://user-images.githubusercontent.com/109813776/213055006-e2b1bd63-1b57-47dc-a59f-0856ed68eac7.png)

# Commands

hsc - Hide or show the scoreboard, also has a sound

![image](https://user-images.githubusercontent.com/109813776/213057064-d60be274-cc1b-4327-a95f-7fe979507e51.png)
