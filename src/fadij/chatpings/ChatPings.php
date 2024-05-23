<?php

namespace fadij\chatpings;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use fadij\chatpings\commands\PingCommand;
use fadij\chatpings\ChatListener;

class ChatPings extends PluginBase {

    /** @var Config */
    private $config;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
        
        $this->getServer()->getPluginManager()->registerEvents(new ChatListener($this), $this);

        $this->getServer()->getCommandMap()->register("pingtoggle", new PingCommand($this));
    
        $this->getServer()->getLogger()->info("Chat Pings Plugin Enabled.");
    }

    /**
     * @return Config
     */
    public function getConfigData(): Config {
        return $this->config;
    }

    /**
     * Enable or disable pings
     * @param bool $status
     */
    public function setPingStatus(bool $status): void {
        $this->config->set("pings-enabled", $status);
        $this->config->save();
    }

    /**
     * Check if pings are enabled
     * @return bool
     */
    public function isPingEnabled(): bool {
        return $this->config->get("pings-enabled", true);
    }
}
