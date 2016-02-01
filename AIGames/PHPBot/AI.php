<?php
namespace AIGames\PHPBot;

/**
 * Class AI
 * @package AIGames\PHPBot
 */
class AI {

    private $settings;

    /**
     * AI constructor.
     * @param Map $map
     */
    public function __construct(Map $map) {
        $this->map = $map;
    }

    public function updateSettings($settings) {
        $this->settings = $settings;
    }

    /**
     * Work through a complicated algorithm that reduces the number of available moves to
     * a path for winning scenario that takes into consideration every possible situation
     * and outputs one single move action
     *
     * No... not really. It chooses a random square... for now.
     *
     * @todo Timing
     *
     */
    public function move() {

        $availableMoves = $this->map->getAvailableMoves();

        /** Make a random move
         * @var Move $move
         */
        return $availableMoves[rand(0,count($availableMoves)-1)];
    }

}