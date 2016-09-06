<?php

class anonymous_comments_display{
	
	public function __construct() {			
		add_filter('get_comment_author', array($this, 'author'), 10, 3);
		add_filter('get_avatar', array($this, 'avatar'), 10 , 5);
		add_filter('get_comment_author_url', array($this, 'url'),10,3);
		add_filter('comment_email', array($this, 'email'), 10, 3);
		add_action('comment_form', array($this, 'additional'));
	}
	
	function additional(){
		global $post;
		if(get_post_meta($post->ID, "anonymous_comments",true)!==""){
			echo "<p>" . __("All comments to this post are anonymous") . "</p>";
		}
	}
	
	function email( $email, $comment_ID, $comment ) {
		
		if(is_admin()){
			if (defined('DOING_AJAX')){
				if(!DOING_AJAX) {
					return $author;
				}
			}
		}

		global $post,$comment;
		
		if(get_post_meta($post->ID, "anonymous_comments",true)!==""){
		
			if(get_current_user_id()!=0){
				if(get_post_meta($post->ID, "anonymous_comments",true)!==""){
					if(get_post_meta($post->ID, "admin_bypass_anonymous_comments",true)!==""){
						return $email;
					}
				}
			}
			
			if($comment->user_id==$post->post_author){
				if(get_post_meta($post->ID, "show_author_anonymous_comments",true)!==""){
					return $email;
				}
			}
			
			return "";
			
		}

	}
	
	function url( $url, $comment_ID, $comment) {
	
		if(is_admin()){
			if (defined('DOING_AJAX')){
				if(!DOING_AJAX) {
					return $author;
				}
			}
		}
		
		global $post,$comment;
			
		if(get_post_meta($post->ID, "anonymous_comments",true)!==""){
		
			if(get_current_user_id()!=0){
				if(get_post_meta($post->ID, "anonymous_comments",true)!==""){
					if(get_post_meta($post->ID, "admin_bypass_anonymous_comments",true)!==""){
						return $url;
					}
				}
			}
			
			if($comment->user_id==$post->post_author){
				if(get_post_meta($post->ID, "show_author_anonymous_comments",true)!==""){
					return $url;
				}
			}
			
			return "";
			
		}

	}
	
	function avatar( $avatar, $id_or_email, $size, $default, $alt ) {
	
		if(is_admin()){
			if (defined('DOING_AJAX')){
				if(!DOING_AJAX) {
					return $author;
				}
			}
		}
		
		global $post,$comment;
			
		if(isset($post->ID)){	
			
			if(get_post_meta($post->ID, "anonymous_comments",true)!==""){
			
				if(get_current_user_id()!=0){
					if(get_post_meta($post->ID, "anonymous_comments",true)!==""){
						if(get_post_meta($post->ID, "admin_bypass_anonymous_comments",true)!==""){
							return $avatar;
						}
					}
				}
				
				if(isset($comment->user_id)){
					if($comment->user_id==$post->post_author){
						if(get_post_meta($post->ID, "show_author_anonymous_comments",true)!==""){
							return $avatar;
						}
					}
				}
				
				return "<img height='" . $size . "' width = '" . $size . "' class='avatar avatar-" . $size . "' src='" . get_avatar_url(0) . "' />";
				
			}
			
		}

	}
	
	function author($author, $comment_ID, $comment){
	
		if(is_admin()){
			if (defined('DOING_AJAX')){
				if(!DOING_AJAX) {
					return $author;
				}
			}
		}
		
		if(get_post_meta($comment->comment_post_ID, "anonymous_comments",true)!==""){
		
			if(get_current_user_id()!=0){
				if(get_post_meta($comment->comment_post_ID, "anonymous_comments",true)!==""){
					if(get_post_meta($comment->comment_post_ID, "admin_bypass_anonymous_comments",true)!==""){
						return $author;
					}
				}
			}
			
			$post = get_post($comment->comment_post_ID);
			
			if($comment->user_id==$post->post_author){
				if(get_post_meta($post->ID, "show_author_anonymous_comments", true)!==""){
					return $author;
				}
			}
			
			$authors = get_post_meta($comment->comment_post_ID, "comment_authors", true);
			if(!is_array($authors)){
				$authors = array();
			}
			
			if(!in_array($author, $authors)){
				$authors[] = $author;
				update_post_meta($comment->comment_post_ID, "comment_authors", $authors);
				return __("Anonymous Commenter") . " " . count($authors);
			}else{
				return __("Anonymous Commenter") . " " . (array_search ($author, $authors) + 1);	
			}
			
		}
		
		return $author;
			
	}
	
} 

$anonymous_comments_display = new anonymous_comments_display();
