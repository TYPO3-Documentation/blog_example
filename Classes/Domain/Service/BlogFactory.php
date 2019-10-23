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
 * A simple blog factory to create sample data
 */
class Tx_BlogExample_Domain_Service_BlogFactory implements t3lib_Singleton {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * Injects the object manager
	 *
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 * @return void
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * Returns a sample blog populated with generic data
	 * It is also an example how to handle objects and repositories in general
	 *
	 * @param integer $blogNumber
	 * @return Tx_BlogExample_Domain_Model_Blog
	 */
	public function createBlog($blogNumber = 1) {
			// initialize blog
		$blog = $this->objectManager->create('Tx_BlogExample_Domain_Model_Blog');
		$blog->setTitle('Blog #' . $blogNumber);
		$blog->setDescription('A blog about TYPO3 extension development.');

			// create author
		$author = $this->objectManager->create('Tx_BlogExample_Domain_Model_Person', 'Stephen', 'Smith', 'foo.bar@example.com');

			// create administrator
		$administrator = $this->objectManager->create('Tx_BlogExample_Domain_Model_Administrator');
		$administrator->setName('John Doe');
		$administrator->setEmail('john.doe@example.com');
		$blog->setAdministrator($administrator);

			// create sample posts
		for ($postNumber = 1; $postNumber < 6; $postNumber++) {

				// create post
			$post = $this->objectManager->create('Tx_BlogExample_Domain_Model_Post');
			$post->setTitle('The ' . $postNumber . '. post of blog #' . $blogNumber);
			$post->setAuthor($author);
			$post->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');

				// create comments
			$comment = $this->objectManager->create('Tx_BlogExample_Domain_Model_Comment');
			$comment->setDate(new DateTime());
			$comment->setAuthor('Peter Pan');
			$comment->setEmail('peter.pan@example.com');
			$comment->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
			$post->addComment($comment);

			$comment = $this->objectManager->create('Tx_BlogExample_Domain_Model_Comment');
			$comment->setDate(new DateTime('2009-03-19 23:44'));
			$comment->setAuthor('John Smith');
			$comment->setEmail('john@matrix.org');
			$comment->setContent('Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.');
			$post->addComment($comment);

				// create some random tags
			if (rand(0, 1) > 0) {
				$tag = $this->objectManager->create('Tx_BlogExample_Domain_Model_Tag', 'MVC');
				$post->addTag($tag);
			}
			if (rand(0, 1) > 0) {
				$tag = $this->objectManager->create('Tx_BlogExample_Domain_Model_Tag', 'Domain Driven Design');
				$post->addTag($tag);
			}
			if (rand(0, 1) > 0) {
				$tag = $this->objectManager->create('Tx_BlogExample_Domain_Model_Tag', 'TYPO3');
				$post->addTag($tag);
			}

				// add the post to the current blog
			$blog->addPost($post);
			$post->setBlog($blog);
		}

		return $blog;
	}

}
?>