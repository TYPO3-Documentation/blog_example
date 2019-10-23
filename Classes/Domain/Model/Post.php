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
 * A blog post
 */
class Tx_BlogExample_Domain_Model_Post extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * @var Tx_BlogExample_Domain_Model_Blog
	 */
	protected $blog;

	/**
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 50)
	 */
	protected $title;

	/**
	 * @var DateTime
	 */
	protected $date;

	/**
	 * @var Tx_BlogExample_Domain_Model_Person
	 */
	protected $author;

	/**
	 * @var string
	 * @validate StringLength(minimum = 3)
	 */
	protected $content;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_BlogExample_Domain_Model_Tag>
	 */
	protected $tags;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_BlogExample_Domain_Model_Comment>
	 * @lazy
	 * @cascade remove
	 */
	protected $comments;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_BlogExample_Domain_Model_Post>
	 * @lazy
	 */
	protected $relatedPosts;

	/**
	 * Constructs this post
	 */
	public function __construct() {
		$this->tags = new Tx_Extbase_Persistence_ObjectStorage();
		$this->comments = new Tx_Extbase_Persistence_ObjectStorage();
		$this->relatedPosts = new Tx_Extbase_Persistence_ObjectStorage();
		$this->date = new DateTime();
	}

	/**
	 * Sets the blog this post is part of
	 *
	 * @param Tx_BlogExample_Domain_Model_Blog $blog The blog
	 * @return void
	 */
	public function setBlog(Tx_BlogExample_Domain_Model_Blog $blog) {
		$this->blog = $blog;
	}

	/**
	 * Returns the blog this post is part of
	 *
	 * @return Tx_BlogExample_Domain_Model_Blog The blog this post is part of
	 */
	public function getBlog() {
		return $this->blog;
	}

	/**
	 * Setter for title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Getter for title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Setter for date
	 *
	 * @param DateTime $date
	 * @return void
	 */
	public function setDate(DateTime $date) {
		$this->date = $date;
	}

	/**
	 * Getter for date
	 *
	 *
	 * @return DateTime
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Setter for tags
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage $tags One or more Tx_BlogExample_Domain_Model_Tag objects
	 * @return void
	 */
	public function setTags(Tx_Extbase_Persistence_ObjectStorage $tags) {
		$this->tags = $tags;
	}

	/**
	 * Adds a tag to this post
	 *
	 * @param Tx_BlogExample_Domain_Model_Tag $tag
	 * @return void
	 */
	public function addTag(Tx_BlogExample_Domain_Model_Tag $tag) {
		$this->tags->attach($tag);
	}

	/**
	 * Removes a tag from this post
	 *
	 * @param Tx_BlogExample_Domain_Model_Tag $tag
	 * @return void
	 */
	public function removeTag(Tx_BlogExample_Domain_Model_Tag $tag) {
		$this->tags->detach($tag);
	}

	/**
	 * Remove all tags from this post
	 *
	 * @return void
	 */
	public function removeAllTags() {
		$this->tags = new Tx_Extbase_Persistence_ObjectStorage();
	}

	/**
	 * Getter for tags
	 * Note: We return a clone of the tags because they must not be modified as they are Value Objects
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage A storage holding Tx_BlogExample_Domain_Model_Tag objects
	 */
	public function getTags() {
		return clone $this->tags;
	}

	/**
	 * Sets the author for this post
	 *
	 * @param Tx_BlogExample_Domain_Model_Person $author
	 * @return void
	 */
	public function setAuthor(Tx_BlogExample_Domain_Model_Person $author) {
		$this->author = $author;
	}

	/**
	 * Getter for author
	 *
	 * @return Tx_BlogExample_Domain_Model_Person
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Sets the content for this post
	 *
	 * @param string $content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Getter for content
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Setter for the comments to this post
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage $comments An Object Storage of related Comment instances
	 * @return void
	 */
	public function setComments(Tx_Extbase_Persistence_ObjectStorage $comments) {
		$this->comments = $comments;
	}

	/**
	 * Adds a comment to this post
	 *
	 * @param Tx_BlogExample_Domain_Model_Comment $comment
	 * @return void
	 */
	public function addComment(Tx_BlogExample_Domain_Model_Comment $comment) {
		$this->comments->attach($comment);
	}

	/**
	 * Removes Comment from this post
	 *
	 * @param Tx_BlogExample_Domain_Model_Comment $commentToDelete
	 * @return void
	 */
	public function removeComment(Tx_BlogExample_Domain_Model_Comment $commentToDelete) {
		$this->comments->detach($commentToDelete);
	}

	/**
	 * Remove all comments from this post
	 *
	 * @return void
	 */
	public function removeAllComments() {
		$comments = clone $this->comments;
		foreach($comments as $comment) {
			$this->comments->detach($comment);
		}
	}

	/**
	 * Returns the comments to this post
	 *
	 * @return An Tx_Extbase_Persistence_ObjectStorage holding instances of Tx_BlogExample_Domain_Model_Comment
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * Setter for the related posts
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage $relatedPosts An Object Storage containing related Posts instances
	 * @return void
	 */
	public function setRelatedPosts(Tx_Extbase_Persistence_ObjectStorage $relatedPosts) {
		$this->relatedPosts = $relatedPosts;
	}

	/**
	 * Adds a related post
	 *
	 * @param Tx_BlogExample_Domain_Model_Post $comment
	 * @return void
	 */
	public function addRelatedPost(Tx_BlogExample_Domain_Model_Post $post) {
		$this->relatedPosts->attach($post);
	}

	/**
	 * Remove all related posts
	 *
	 * @return void
	 */
	public function removeAllRelatedPosts() {
		$relatedPosts = clone $this->relatedPosts;
		foreach($relatedPosts as $relatedPost) {
			$this->relatedPosts->detach($relatedPost);
		}
	}

	/**
	 * Returns the related posts
	 *
	 * @return An Tx_Extbase_Persistence_ObjectStorage holding instances of Tx_BlogExample_Domain_Model_Post
	 */
	public function getRelatedPosts() {
		return $this->relatedPosts;
	}

	/**
	 * Returns this post as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->title . chr(10) .
			' written on ' . $this->date->format('Y-m-d') . chr(10) .
			' by ' . $this->author->getFullName() . chr(10) .
			wordwrap($this->content, 70, chr(10)) . chr(10) .
			implode(', ', $this->tags->toArray());
	}
}
?>