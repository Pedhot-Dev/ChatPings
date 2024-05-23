<?php

namespace fadij\chatpings\commands;

use fadij\chatpings\ChatPings;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class PingCommand extends Command {

    /** @var ChatPings */
    private $plugin;

    public function __construct(ChatPings $plugin) {
        parent::__construct("pingtoggle", "Toggle chat pings on or off", "/pingtoggle", ["pt"]);
        $this->setPermission("chatpings.command.pingtoggle");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender->hasPermission("chatpings.command.pingtoggle")) {
            return false;
        }

        if ($sender instanceof Player) {
            $currentStatus = $this->plugin->isPingEnabled();
            $this->plugin->setPingStatus(!$currentStatus);

            $statusMessage = $currentStatus ? "disabled" : "enabled";
            $sender->sendMessage(TextFormat::GREEN . "Chat pings have been " . $statusMessage . ".");
            return true;
        } else {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
            return false;
        }
    }
}
