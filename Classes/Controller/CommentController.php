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
 * The comment controller for the BlogExample extension
 */
class Tx_BlogExample_Controller_CommentController extends Tx_BlogExample_Controller_AbstractController {

	/**
	 * Adds a comment to a blog post and redirects to single view
	 *
	 * @param Tx_BlogExample_Domain_Model_Post $post The post the comment is related to
	 * @param Tx_BlogExample_Domain_Model_Comment $newComment The comment to create
	 * @return void
	 */
	public function createAction(Tx_BlogExample_Domain_Model_Post $post, Tx_BlogExample_Domain_Model_Comment $newComment) {
		$post->addComment($newComment);
		$this->addFlashMessage('created');
		$this->redirect('show', 'Post', NULL, array('post' => $post));
	}

	/**
	 * Deletes an existing comment
	 *
	 * @param Tx_BlogExample_Domain_Model_Post $post The post the comment is related to
	 * @param Tx_BlogExample_Domain_Model_Comment $comment The comment to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_BlogExample_Domain_Model_Post $post, Tx_BlogExample_Domain_Model_Comment $comment) {
		// TODO access protection
		$post->removeComment($comment);
		$this->addFlashMessage('deleted', t3lib_FlashMessage::INFO);
		$this->redirect('show', 'Post', NULL, array('post' => $post));
	}

	/**
	 * Deletes all comments of the given post
	 *
	 * @param Tx_BlogExample_Domain_Model_Post $post The post the comment is related to
	 * @return void
	 */
	public function deleteAllAction(Tx_BlogExample_Domain_Model_Post $post) {
		// TODO access protection
		$post->removeAllComments();
		$this->addFlashMessage('deletedAll', t3lib_FlashMessage::INFO);
		$this->redirect('edit', 'Post', NULL, array('post' => $post, 'blog' => $post->getBlog()));
	}
}

?>