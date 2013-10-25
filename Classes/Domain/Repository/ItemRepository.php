<?php
namespace J18\Examplesyscategory\Domain\Repository;

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
use J18\Examplesyscategory\Domain\Model\Dto\Demand;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 *
 * @package examplesyscategory
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ItemRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function findByDemand(Demand $demand) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$constraints = array();

		// storage page
		if ($demand->getStartingpoint() != '') {
			$pidList = GeneralUtility::intExplode(',', $demand->getStartingpoint(), TRUE);
			$constraints[] = $query->in('pid', $pidList);
		}

		// categories
		if ($demand->getCategories() != '') {
			$categoryConstraints = array();
			$categoryList = GeneralUtility::intExplode(',', $demand->getCategories(), TRUE);
			foreach ($categoryList as $category) {
				$categoryConstraints[] = $query->contains('categories', $category);
			}

			if (!empty($categoryConstraints)) {
				$mode = strtolower($demand->getCategoryMode());
				switch ($mode) {
					case 'and':
						$constraints[] = $query->logicalAnd($categoryConstraints);
						break;
					case 'or':
						$constraints[] = $query->logicalOr($categoryConstraints);
						break;
					default:
						throw new \UnexpectedValueException('Set a category mode');
				}
			}
		}

		if (!empty($constraints)) {
			$query->matching(
				$query->logicalAnd($constraints)
			);
		}

		return $query->execute();
	}

}

?>