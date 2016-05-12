<?php

class anonymous_comments_config{
	
	function __construct(){
		add_action("admin_head", array($this, "metabox"));
		add_action("save_post", array($this, "save_post"));
	}
	
	function metabox(){
		add_meta_box("anonymous_comments",__("Anonymous Comments"),array($this,"editor"),null,"side","high");
	}
	
	function editor(){
		global $post;
		$checked = get_post_meta($post->ID, "anonymous_comments", true);
		$author_checked = get_post_meta($post->ID, "show_author_anonymous_comments", true);
		$admin_checked = get_post_meta($post->ID, "admin_bypass_anonymous_comments", true);
		?><p><label><?PHP echo __("Enable anonymous comments"); ?></label>
		<input type="checkbox" name="anonymous_comments" <?PHP if($checked!=""){ echo " checked "; } ?> /></p>
		<p><label><?PHP echo __("Show author name in comments"); ?></label>
		<input type="checkbox" name="show_author_anonymous_comments" <?PHP if($author_checked!=""){ echo " checked "; } ?> /></p>
		<p><label><?PHP echo __("Allow admin to bypass anonymity"); ?></label>
		<input type="checkbox" name="admin_bypass_anonymous_comments" <?PHP if($admin_checked!=""){ echo " checked "; } ?> /></p>
		<?PHP
	}
	
	function save_post($post_id){
		if(isset($_POST['anonymous_comments'])){
			if($_POST['anonymous_comments']=="on"){
				update_post_meta($post_id, "anonymous_comments", "on");
			}
		}else{
			delete_post_meta($post_id, "anonymous_comments");
		}
		if(isset($_POST['show_author_anonymous_comments'])){
			if($_POST['show_author_anonymous_comments']=="on"){
				update_post_meta($post_id, "anonymous_comments", "on");
				update_post_meta($post_id, "show_author_anonymous_comments", "on");
			}
		}else{
			delete_post_meta($post_id, "show_author_anonymous_comments");
		}
		if(isset($_POST['admin_bypass_anonymous_comments'])){
			if($_POST['admin_bypass_anonymous_comments']=="on"){
				update_post_meta($post_id, "admin_bypass_anonymous_comments", "on");
				update_post_meta($post_id, "anonymous_comments", "on");
			}
		}else{
			delete_post_meta($post_id, "admin_bypass_anonymous_comments");
		}
	}
	
} 

$anonymous_comments_config = new anonymous_comments_config();
