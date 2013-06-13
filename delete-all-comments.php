<?php
    /*
    Plugin Name: Delete All Comments
    Plugin URI: http://www.oviamsolutions.com/plugins/delete-all-comments
    Description: Plugin to delete all comments (Approved, Pending, Spam)
    Author: Ganesh Chandra
    Version: 1.0
    Author URI: http://www.oviamsolutions.com
    */
?>
<?php
    add_action('admin_menu', 'oviam_dac_admin_actions');

    function oviam_dac_admin_actions()
    {
		    add_management_page("Delete All Comments", "Delete All Comments", 1, "oviam_delete_all_comments", "oviam_dac_main");
    } // End of function oviam_dac_admin_actions

    function oviam_dac_main() 
    {
        global $wpdb;
	    $comments_count = $wpdb->get_var("SELECT count(comment_id) from $wpdb->comments");
?>

    <div class="wrap">
	    <h2>Delete All Comments</h2>
        <?php if($_POST['oviamdac_hidden'] == 'Y' && $_POST['chkdelete'] == 'Y')
        {
            if($wpdb->query("DELETE FROM $wpdb->comments") != FALSE)
	            {
                    $wpdb->query("Update $wpdb->posts set comment_count = 0 where post_author != 0");
                    echo "<p style='color:green'><strong>All comments have been deleted.</strong></p>";
                }
            else 
                {echo "<p style='color:red'><strong>Internal error occured. Please try again later.</strong></p>";}
        } // End of if post remove ='Y'
        else {
        ?>
        <?php echo "<h4>Total Comments : " . $comments_count . " </h4>" ; ?>
        
        <?php if($comments_count > 0) { ?>
        <p><strong>Note: Please check the box and click Delete All.</strong></p>
            <form name="frmOviamdac" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                <input type="hidden" name="oviamdac_hidden" value="Y">
                <input type="checkbox" name="chkdelete" value="Y" /> Delete all comments
                <p class="submit">
		            <input type="submit" name="Submit" value="Delete All" />
                </p>
            </form>
        <?php 
        } // End of if comments_count > 0
        else 
        {
            echo "<p><strong>All comments have been deleted.</strong></p>" ;
        } // End of else comments_count > 0  ?>
    </div>
<?php
        } // else of if post remove == 'Y'
    } // End of function oviam_dac_main
?>