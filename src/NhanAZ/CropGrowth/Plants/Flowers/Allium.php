<?php

declare(strict_types=1);

namespace NhanAZ\CropGrowth\Plants\Flowers;

use NhanAZ\CropGrowth\Main;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

class Allium implements Listener {

	public function onPlayerInteract(PlayerInteractEvent $event): void {
		$block = $event->getBlock();
		if (Main::isUseBoneMeal($event->getItem(), $event->getAction())) {
			if ($block->isSameType(VanillaBlocks::ALLIUM())) {
				Main::playParticleAndSound($block);
			}
		}
	}
}