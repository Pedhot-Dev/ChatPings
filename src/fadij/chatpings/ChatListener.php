<?php

namespace fadij\chatpings;

use fadij\chatpings\ChatPings;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\player\Player;
use pocketmine\world\sound\XpCollectSound;
use pocketmine\world\sound\ClickSound;

class ChatListener implements Listener
{

    /** @var ChatPings */
    private $plugin;

    public function __construct(ChatPings $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerChatEvent $event
     */
    public function onPlayerChat(PlayerChatEvent $event): void
    {
        if (!$this->plugin->isPingEnabled()) {
            return;
        }

        $message = $event->getMessage();

        foreach ($this->plugin->getServer()->getOnlinePlayers() as $onlinePlayer) {
            if (stripos($message, '@' . $onlinePlayer->getName()) !== false) {
                $this->sendPing($onlinePlayer);
            }
        }
    }

    /**
     * @param Player $player
     */
    private function sendPing(Player $player): void
    {
        $config = $this->plugin->getConfigData();
        $soundType = $config->get("sound-type", "xp");

        $sound = $soundType === "xp" ? new XpCollectSound() : new ClickSound();
        $player->broadcastSound($sound, [$player]);
    }
}
