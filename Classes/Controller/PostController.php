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
 * The post controller for the BlogExample extension
 */
class Tx_BlogExample_Controller_PostController extends Tx_BlogExample_Controller_AbstractController {

	/**
	 * @var Tx_BlogExample_Domain_Model_PostRepository
	 */
	protected $postRepository;

	/**
	 * @var Tx_BlogExample_Domain_Repository_PersonRepository
	 */
	protected $personRepository;

	/**
	 * Dependency injection of the Post Repository
	 *
	 * @param Tx_BlogExample_Domain_Repository_PostRepository $postRepository
	 * @return void
	 */
	public function injectPostRepository(Tx_BlogExample_Domain_Repository_PostRepository $postRepository) {
		$this->postRepository = $postRepository;
	}

	/**
	 * Dependency injection of the Post Repository
	 *
	 * @param Tx_BlogExample_Domain_Repository_PersonRepository $personRepository
	 * @return void
	 */
	public function injectPersonRepository(Tx_BlogExample_Domain_Repository_PersonRepository $personRepository) {
		$this->personRepository = $personRepository;
	}

	/**
	 * Displays a list of posts. If $tag is set only posts matching this tag are shown
	 *
	 * @param Tx_BlogExample_Domain_Model_Blog $blog The blog to show the posts of
	 * @param string $tag The name of the tag to show the posts for
	 * @return void
	 */
	public function indexAction(Tx_BlogExample_Domain_Model_Blog $blog, $tag = NULL) {
		if (empty($tag)) {
			$posts = $this->postRepository->findByBlog($blog);
		} else {
			$tag = urldecode($tag);
			$posts = $this->postRepository->findByTagAndBlog($tag, $blog);
			$this->view->assign('tag', $tag);
		}
		$this->view->assign('blog', $blog);
		$this->view->assign('posts', $posts);
	}

	/**
	 * Displays one single post
	 *
	 * @param Tx_BlogExample_Domain_Model_Post $post The post to display
	 * @param Tx_BlogExample_Domain_Model_Comment $newComment A new comment
	 * @return void
	 * @dontvalidate $newComment
	 */
	public function showAction(Tx_BlogExample_Domain_Model_Post $post, Tx_BlogExample_Domain_Model_Comment $newComment = NULL) {
		$this->view->assign('post', $post);
		$this->view->assign('newComment', $newComment);
	}

	/**
	 * Displays a form for creating a new post
	 *
	 * @param Tx_BlogExample_Domain_Model_Blog $blog The blog the post belogs to
	 * @param Tx_BlogExample_Domain_Model_Post $newPost A fresh post object taken as a basis for the rendering
	 * @return void
	 * @dontvalidate $newPost
	 */
	public function newAction(Tx_BlogExample_Domain_Model_Blog $blog, Tx_BlogExample_Domain_Model_Post $newPost = NULL) {
		$this->view->assign('authors', $this->personRepository->findAll());
		$this->view->assign('blog', $blog);
		$this->view->assign('newPost', $newPost);
		$this->view->assign('remainingPosts', $this->postRepository->findByBlog($blog));
	}

	/**
	 * Creates a new post
	 *
	 * @param Tx_BlogExample_Domain_Model_Blog $blog The blog the post belogns to
	 * @param Tx_BlogExample_Domain_Model_Post $newBlog A fresh Blog object which has not yet been added to the repository
	 * @return void
	 */
	public function createAction(Tx_BlogExample_Domain_Model_Blog $blog, Tx_BlogExample_Domain_Model_Post $newPost) {
		// TODO access protection
		$blog->addPost($newPost);
		$newPost->setBlog($blog);
		$this->addFlashMessage('created');
		$this->redirect('index', NULL, NULL, array('blog' => $blog));
	}

	/**
	 * Displays a form to edit an existing post
	 *
	 * @param Tx_BlogExample_Domain_Model_Blog $blog The blog the post belogs to
	 * @param Tx_BlogExample_Domain_Model_Post $post The original post
	 * @return void
	 * @dontvalidate $post
	 */
	public function editAction(Tx_BlogExample_Domain_Model_Blog $blog, Tx_BlogExample_Domain_Model_Post $post) {
		$this->view->assign('authors', $this->personRepository->findAll());
		$this->view->assign('blog', $blog);
		$this->view->assign('post', $post);
		$this->view->assign('remainingPosts', $this->postRepository->findRemaining($post));
	}

	/**
	 * Updates an existing post
	 *
	 * @param Tx_BlogExample_Domain_Model_Blog $blog The blog the post belongs to
	 * @param Tx_BlogExample_Domain_Model_Post $post A clone of the original post with the updated values already applied
	 * @return void
	 */
	public function updateAction(Tx_BlogExample_Domain_Model_Blog $blog, Tx_BlogExample_Domain_Model_Post $post) {
		// TODO access protection
		$this->postRepository->update($post);
		$this->addFlashMessage('updated');
		$this->redirect('show', NULL, NULL, array('post' => $post, 'blog' => $blog));
	}

	/**
	 * Deletes an existing post
	 *
	 * @param Tx_BlogExample_Domain_Model_Blog $blog The blog the post belongs to
	 * @param Tx_BlogExample_Domain_Model_Post $post The post to be deleted
	 * @return void
	 */
	public function deleteAction(Tx_BlogExample_Domain_Model_Blog $blog, Tx_BlogExample_Domain_Model_Post $post) {
		// TODO access protection
		$this->postRepository->remove($post);
		$this->addFlashMessage('deleted', t3lib_FlashMessage::INFO);
		$this->redirect('index', NULL, NULL, array('blog' => $blog));
	}

}

?>