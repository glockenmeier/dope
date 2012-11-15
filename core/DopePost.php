<?php

/*
 * Copyright 2012, Darius Glockenmeier.
 */

/**
 * A wrapper around the post object.
 *
 * @author Darius Glockenmeier <darius@glockenmeier.com>
 * @package core
 */
final class DopePost {

    private $id;
    private $post_author;
    private $post_date;
    private $post_date_gmt;
    private $post_content;
    private $post_title;
    private $post_category;
    private $post_excerpt;
    private $post_status;
    private $comment_status;
    private $ping_status;
    private $post_password;
    private $post_name;
    private $to_ping;
    private $pinged;
    private $post_modified;
    private $post_modified_gmt;
    private $post_content_filtered;
    private $post_parent;
    private $guid;
    private $menu_order;
    private $post_type;
    private $post_mime_type;
    private $comment_count;
    private $post_object;

    private function __construct($post) {
        $this->id = $post->ID;
        $this->post_author = $post->post_author;
        $this->post_date = $post->post_date;
        $this->post_date_gmt = $post->post_date_gmt;
        $this->post_content = $post->post_content;
        $this->post_title = $post->post_title;
        $this->post_category = isset($post->post_category) ? $post->post_category : null;
        $this->post_excerpt = $post->post_excerpt;
        $this->post_status = $post->post_status;
        $this->comment_status = $post->comment_status;
        $this->ping_status = $post->ping_status;
        $this->post_password = $post->post_password;
        $this->post_name = $post->post_name;
        $this->to_ping = $post->to_ping;
        $this->pinged = $post->pinged;
        $this->post_modified = $post->post_modified;
        $this->post_modified_gmt = $post->post_modified_gmt;
        $this->post_content_filtered = $post->post_content_filtered;
        $this->post_parent = $post->post_parent;
        $this->guid = $post->guid;
        $this->menu_order = $post->menu_order;
        $this->post_type = $post->post_type;
        $this->post_mime_type = $post->post_mime_type;
        $this->comment_count = $post->comment_count;
        $this->post_object = $post;
    }

    /**
     * Creates a new instance of DopePost
     * @param int $post_id The post id
     * @return DopePost|null new instance of DopePost or null if not found
     * @throws InvalidArgumentException 
     */
    public static function byPostId($post_id) {
        if (!is_int($post_id)) {
            throw new InvalidArgumentException('Expected $post_id to be an integer');
        }
        $post = get_post($post_id, OBJECT);
        return $post !== null ? new self($post) : null;
    }

    /**
     * Creates a new instance of DopePost
     * @param object $post The post object
     * @return DopePost|null new instance of DopePost or null if not found
     * @throws InvalidArgumentException 
     */
    public static function byPostObject($post) {
        if (!is_object($post)) {
            throw new InvalidArgumentException('Expected $post to be an object');
        }
        return $post !== null ? new self($post) : null;
    }

    /**
     * Gets an instance DopePost by post id or post object.
     * @param mixed $post post id or post object.
     * @return DopePost|null new instance of DopePost or null if not found
     * @throws InvalidArgumentException 
     */
    public static function get($post) {
        if (is_object($post)) {
            return self::byPostObject($post);
        } else if (is_int($post)) {
            return self::byPostId($post);
        } else {
            throw new InvalidArgumentException('$post is expected to be of type integer or object.');
        }
    }

    /**
     * Returns the underlying WP post object
     * @return object|null wp post object or null if not found
     */
    public function toPostObject() {
        return get_post($this->post_object, OBJECT);;
    }
    
    /**
     * The post ID
     * @return int 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * The post author's ID
     * @return int 
     */
    public function getAuthor() {
        return $this->post_author;
    }

    /**
     * The datetime of the post (YYYY-MM-DD HH:MM:SS)
     * @return string 
     */
    public function getDate() {
        return $this->post_date;
    }

    /**
     * The GMT datetime of the post (YYYY-MM-DD HH:MM:SS)
     * @return string 
     */
    public function getDateGmt() {
        return $this->post_date_gmt;
    }

    /**
     * The post's contents
     * @return string 
     */
    public function getContent() {
        return $this->post_content;
    }

    /**
     * Number of comments
     * @return int 
     */
    public function getComment_count() {
        return $this->comment_count;
    }

    /**
     * The comment status (open|closed|registered_only)
     * @return string 
     */
    public function getComment_status() {
        return $this->comment_status;
    }

    /**
     * A link to the post. Note: One cannot rely upon the GUID to be the permalink (as it previously was in pre-2.5), Nor can you expect it to be a valid link to the post. It's merely a unique identifier, which so happens to be a link to the post at present.
     * @return string 
     */
    public function getGuid() {
        return $this->guid;
    }

    /**
     * 
     * @return int
     */
    public function getMenuOrder() {
        return $this->menu_order;
    }

    /**
     * The pingback/trackback status (open|closed)
     * @return string 
     */
    public function getPingStatus() {
        return $this->ping_status;
    }

    /**
     * URLs already pinged
     * @return string 
     */
    public function getPinged() {
        return $this->pinged;
    }

    /**
     * The post category's ID. Note that this will always be 0 (zero) from wordpress 2.1 onwards. To determine a post's category or categories, use get_the_category()
     * @see get_the_category()
     * @return int 
     * @deprecated since WordPress version 2.1 onwards
     */
    public function getPostCategory() {
        return $this->post_category;
    }

    public function getContentFiltered() {
        return $this->post_content_filtered;
    }

    /**
     * The post excerpt
     * @return string 
     */
    public function getExcerpt() {
        return $this->post_excerpt;
    }

    /**
     * Mime Type (for attachments, etc)
     * @return string 
     */
    public function getMimeType() {
        return $this->post_mime_type;
    }

    /**
     * The last modified datetime of the post (YYYY-MM-DD HH:MM:SS)
     * @return string 
     */
    public function getModified() {
        return $this->post_modified;
    }

    /**
     * The last modified GMT datetime of the post (YYYY-MM-DD HH:MM:SS)
     * @return string 
     */
    public function getModifiedGmt() {
        return $this->post_modified_gmt;
    }

    /**
     * The post's URL slug
     * @return string 
     */
    public function getName() {
        return $this->post_name;
    }

    /**
     * The parent post's ID (for attachments, etc)
     * @return int 
     */
    public function getParent() {
        return $this->post_parent;
    }

    /**
     * The post password
     * @return string 
     */
    public function getPassword() {
        return $this->post_password;
    }

    /**
     * The post status (publish|pending|draft|private|static|object|attachment|inherit|future|trash)
     * @return string 
     */
    public function getStatus() {
        return $this->post_status;
    }

    /**
     * The post's title
     * @return string 
     */
    public function getTitle() {
        return $this->post_title;
    }

    /**
     * The post type (post|page|attachment)
     * @return string 
     */
    public function getType() {
        return $this->post_type;
    }

    /**
     * URLs to be pinged
     * @return string 
     */
    public function getToPing() {
        return $this->to_ping;
    }

}
