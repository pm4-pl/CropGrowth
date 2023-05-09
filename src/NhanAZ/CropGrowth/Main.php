<?php

declare(strict_types=1);

namespace NhanAZ\CropGrowth;

use NhanAZ\CropGrowth\Behavior\Block\DirtBlock;
use NhanAZ\CropGrowth\Behavior\Block\GrassBlock;
use NhanAZ\CropGrowth\Behavior\Block\InWater;
use NhanAZ\CropGrowth\Behavior\Plant\Bamboo;
use NhanAZ\CropGrowth\Behavior\Plant\CaveVines;
use NhanAZ\CropGrowth\Behavior\Plant\Flower;
use NhanAZ\CropGrowth\Behavior\Plant\General;
use NhanAZ\CropGrowth\Behavior\Plant\Sapling;
use NhanAZ\CropGrowth\Behavior\Plant\SeaPickle;
use NhanAZ\CropGrowth\Math\Math;
use NhanAZ\CropGrowth\Particle\CropGrowthParticle;
use NhanAZ\CropGrowth\Sound\BoneMealUseSound;
use pocketmine\block\Block;
use pocketmine\block\BlockTypeIds;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\math\Facing;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

	protected function onEnable(): void {
		$this->registerEvents();
	}

	public static function onGrow(Block $block): void {
		$blockPos = $block->getPosition();
		$world = $blockPos->getWorld();
		$world->addParticle($blockPos, new CropGrowthParticle());
		$world->addSound(Math::center($blockPos), new BoneMealUseSound());
	}

	public static function isUseBoneMeal(Item $item, int $action): bool {
		if ($item->equals(VanillaItems::BONE_MEAL(), true) && $action === PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
			return true;
		}
		return false;
	}

	public static function isInWater(Block $block): bool {
		$blockPos = $block->getPosition();
		$world = $blockPos->getWorld();
		$hasWater = false;
		foreach ($blockPos->sides() as $vector3) {
			if ($world->getBlock($vector3)->getTypeId() === BlockTypeIds::WATER) {
				$hasWater = true;
				break;
			}
		}
		if ($hasWater) {
			return true;
		}
		return false;
	}

	/**
	 * @return array<BlockTypeIds>
	 */
	public static function aquaticPlantsTypeIds() {
		return [
			BlockTypeIds::CORAL,
			BlockTypeIds::CORAL_FAN,
			BlockTypeIds::SEA_PICKLE,
			BlockTypeIds::WATER # [Exception]
			# TODO: Kelp
		];
	}

	public static function isCanGrow(Block $block): bool {
		while ($block->getTypeId() === BlockTypeIds::BAMBOO) {
			$block = $block->getSide(Facing::UP);
			if ($block->getTypeId() === BlockTypeIds::AIR) {
				return true;
			}
		}
		return false;
	}

	private function registerEvent(Listener $event): void {
		$this->getServer()->getPluginManager()->registerEvents($event, $this);
	}

	private function registerEvents(): void {
		$this->registerEvent(new Bamboo());
		$this->registerEvent(new CaveVines());
		$this->registerEvent(new DirtBlock());
		$this->registerEvent(new Flower());
		$this->registerEvent(new General());
		$this->registerEvent(new GrassBlock());
		$this->registerEvent(new InWater());
		$this->registerEvent(new Sapling());
		$this->registerEvent(new SeaPickle());
		# TODO: Azalea
		# TODO: Big Dripleaf
		# TODO: Flowering Azalea
		# TODO: Fungus
		# TODO: Glow Lichen
		# TODO: Kelp
		# TODO: Mangrove Leaves
		# TODO: Mangrove Propagule
		# TODO: Mangrove Propagule
		# TODO: Moss Block
		# TODO: Seagrass
		# TODO: Small Dripleaf
	}
}
