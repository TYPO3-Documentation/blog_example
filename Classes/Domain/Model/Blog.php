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
 * A blog
 */
class Tx_BlogExample_Domain_Model_Blog extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * The blog's title.
	 *
	 * @var string
	 * @validate StringLength(minimum = 1, maximum = 80)
	 */
	protected $title = '';

	/**
	 * A short description of the blog
	 *
	 * @var string
	 * @validate StringLength(maximum = 150)
	 */
	protected $description = '';

	/**
	 * The posts of this blog
	 *
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_BlogExample_Domain_Model_Post>
	 * @lazy
	 * @cascade remove
	 */
	protected $posts;

	/**
	 * The blog's administrator
	 *
	 * @var Tx_BlogExample_Domain_Model_Administrator
	 * @lazy
	 */
	protected $administrator;

	/**
	 * Constructs a new Blog
	 *
	 */
	public function __construct() {
		$this->posts = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Sets this blog's title
	 *
	 * @param string $title The blog's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the blog's title
	 *
	 * @return string The blog's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the description for the blog
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the description
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Adds a post to this blog
	 *
	 * @param Tx_BlogExample_Domain_Model_Post $post
	 * @return void
	 */
	public function addPost(Tx_BlogExample_Domain_Model_Post $post) {
		$this->posts->attach($post);
	}

	/**
	 * Remove a post from this blog
	 *
	 * @param Tx_BlogExample_Domain_Model_Post $postToRemove The post to be removed
	 * @return void
	 */
	public function removePost(Tx_BlogExample_Domain_Model_Post $postToRemove) {
		$this->posts->detach($postToRemove);
	}

	/**
	 * Remove all posts from this blog
	 *
	 * @return void
	 */
	public function removeAllPosts() {
		$this->posts = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Returns all posts in this blog
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage
	 */
	public function getPosts() {
		return $this->posts;
	}

	/**
	 * Sets the administrator value
	 *
	 * @param Tx_BlogExample_Domain_Model_Administrator $administrator The Administrator of this Blog
	 * @return void
	 */
	public function setAdministrator(Tx_BlogExample_Domain_Model_Administrator $administrator) {
		$this->administrator = $administrator;
	}

	/**
	 * Returns the administrator value
	 *
	 * @return Tx_BlogExample_Domain_Model_Administrator
	 */
	public function getAdministrator() {
		return $this->administrator;
	}

}
?>