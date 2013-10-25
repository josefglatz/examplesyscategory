<?php
namespace J18\Examplesyscategory\Controller;

	/***************************************************************
	 *  Copyright notice
	 *
	 *  (c) 2013
	 *  All rights reserved
	 *
	 *  This script is part of the TYPO3 project. The TYPO3 project is
	 *  free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 3 of the License, or
	 *  (at your option) any later version.
	 *
	 *  The GNU General Public License can be found at
	 *  http://www.gnu.org/copyleft/gpl.html.
	 *
	 *  This script is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU General Public License for more details.
	 *
	 *  This copyright notice MUST APPEAR in all copies of the script!
	 ***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 *
 * @package examplesyscategory
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ItemController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * itemRepository
	 *
	 * @var \J18\Examplesyscategory\Domain\Repository\ItemRepository
	 * @inject
	 */
	protected $itemRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction(\J18\Examplesyscategory\Domain\Model\Category $category = NULL) {
		$demand = NULL;
		if (is_null($category)) {
			$demand = $this->getDemand($this->settings['categories']);
		} else {
			$demand = $this->getDemand($category->getUid());
		}
		$items = $this->itemRepository->findByDemand($demand);
		$this->view->assign('items', $items);
	}

	/**
	 * action show
	 *
	 * @param \J18\Examplesyscategory\Domain\Model\Item $item
	 * @return void
	 */
	public function showAction(\J18\Examplesyscategory\Domain\Model\Item $item = NULL) {
		$this->view->assign('item', $item);
	}

	protected function getDemand($categories = '') {
		/** @var \J18\Examplesyscategory\Domain\Model\Dto\Demand $demand */
		$demand = GeneralUtility::makeInstance('J18\Examplesyscategory\Domain\Model\Dto\Demand');
		$demand->setCategories($categories);
		$demand->setCategoryMode('and');
		$demand->setStartingpoint($this->settings['startingpoint']);

		return $demand;
	}

}

?>