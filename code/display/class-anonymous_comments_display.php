<?php

class anonymous_comments_display{
	
	public function __construct() {			
		add_filter('get_comment_author', array($this, 'author'));
		add_filter('get_avatar', array($this, 'avatar'), 1 , 5);
		add_filter('comment_url', array($this, 'url'));
		add_filter('comment_email', array($this, 'email'));
		add_action('comment_form', array($this, 'additional'));
	}
	
	function additional(){
		echo "<p>" . __("All comments to this site are anonymous") . "</p>";
	}
	
	function email( $email ) {
		if(is_single()){
			global $post,$comment;
			
			if(get_post_meta($post->ID, "anonymous_comments")!==""){
			
				if(get_current_user_id()!=0){
					if(get_post_meta($post->ID, "anonymous_comments")!==""){
						if(get_post_meta($post->ID, "admin_bypass_anonymous_comments")!==""){
							return $email;
						}
					}
				}
				
				if($comment->user_id==$post->post_author){
					if(get_post_meta($post->ID, "show_author_anonymous_comments")!==""){
						return $email;
					}
				}
				
				return "";
				
			}
			
		}
	}
	
	function url( $url ) {
		if(is_single()){
			global $post,$comment;
			
			if(get_post_meta($post->ID, "anonymous_comments")!==""){
			
				if(get_current_user_id()!=0){
					if(get_post_meta($post->ID, "anonymous_comments")!==""){
						if(get_post_meta($post->ID, "admin_bypass_anonymous_comments")!==""){
							return $url;
						}
					}
				}
				
				if($comment->user_id==$post->post_author){
					if(get_post_meta($post->ID, "show_author_anonymous_comments")!==""){
						return $url;
					}
				}
				
				return "";
				
			}
			
		}
	}
	
	function avatar( $avatar, $id_or_email, $size, $default, $alt ) {
	
		if(is_single()){
			global $post,$comment;
			
			if(get_post_meta($post->ID, "anonymous_comments")!==""){
			
				if(get_current_user_id()!=0){
					if(get_post_meta($post->ID, "anonymous_comments")!==""){
						if(get_post_meta($post->ID, "admin_bypass_anonymous_comments")!==""){
							return $avatar;
						}
					}
				}
				
				if($comment->user_id==$post->post_author){
					if(get_post_meta($post->ID, "show_author_anonymous_comments")!==""){
						return $avatar;
					}
				}
				
				return "<img height='" . $size . "' width = '" . $size . "' class='avatar avatar-" . $size . "' src='" . get_avatar_url(0) . "' />";
				
			}
			
		}
	}
	
	function author($author){

		if(is_single()){
	
			global $post, $comment;
		
			if(get_post_meta($post->ID, "anonymous_comments")!==""){
			
				if(get_current_user_id()!=0){
					if(get_post_meta($post->ID, "anonymous_comments")!==""){
						if(get_post_meta($post->ID, "admin_bypass_anonymous_comments")!==""){
							return $author;
						}
					}
				}
				
				if($comment->user_id==$post->post_author){
					if(get_post_meta($post->ID, "show_author_anonymous_comments")!==""){
						return $author;
					}
				}
				
				$authors = get_post_meta($post->ID, "comment_authors", true);
				if(!is_array($authors)){
					$authors = array();
				}
					
				if(!in_array($author, $authors)){
					$authors[] = $author;
					update_post_meta($post->ID, "comment_authors", $authors);
					return __("Anonymous Commenter") . " " . count($authors);
				}else{
					return __("Anonymous Commenter") . " " . (array_search ($author, $authors) + 1);	
				}
				
			}
			
		}
		
	}
	
} 

$anonymous_comments_display = new anonymous_comments_display();
