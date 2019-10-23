<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
 *  (c) 2011 Bastian Waidelich <bastian@typo3.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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

/**
 * View helper for rendering gravatar images.
 * See http://www.gravatar.com
 *
 * = Examples =
 *
 * <code>
 * <blog:gravatar emailAddress="foo@bar.com" size="40" defaultImageUri="someDefaultImage" />
 * </code>
 *
 * <output>
 * <img src="http://www.gravatar.com/avatar/4a28b782cade3dbcd6e306fa4757849d?d=someDefaultImage&s=40" />
 * </output>
 */
class Tx_BlogExample_ViewHelpers_GravatarViewHelper extends Tx_Fluid_Core_ViewHelper_TagBasedViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'img';

	/**
	 * Initialize arguments
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerUniversalTagAttributes();
	}

	/**
	 * Render the gravatar image
	 *
	 * @param string $emailAddress Gravataer email address
	 * @param integer $size Size of the gravatar image
	 * @param string $defaultImageUri absolute URI of the image to be shown if no gravatar was found
	 * @return string The rendered image tag
	 */
	public function render($emailAddress, $size = NULL, $defaultImageUri = NULL) {
		$gravatarUri = 'http://www.gravatar.com/avatar/' . md5($emailAddress);
		$uriParts = array();
		if ($defaultImageUri !== NULL) {
			$uriParts[] = 'd=' . urlencode($defaultImageUri);
		}
		if ($size !== NULL) {
			$uriParts[] = 's=' . urlencode($size);
		}
		if (count($uriParts) > 0) {
			$gravatarUri .= '?' . implode('&', $uriParts);
		}

		$this->tag->addAttribute('src', $gravatarUri);
		return $this->tag->render();
	}
}


?>