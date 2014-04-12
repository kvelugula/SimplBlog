<?php 
include_once './lib/appconfig.php';
include_once './lib/recaptchalib.php';

// Load Blog Post
$postId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!empty($postId)) {
    $post = CBlog::getPostById($postId);
    if (empty($post)) {
        CUtils::redirectUser();
    }
} else {
    CUtils::redirectUser();
}

//Handle Comment Post
$commentText = '';
$authorName = '';
$authorEmail = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isValid = TRUE;
    $errors = array();
    // Validate CAPTCHA 
    $resp = recaptcha_check_answer ($config['captcha_privatekey'], 
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid) {
        $errors[] = "Invalid CAPTCHA Text.";
        $isValid = FALSE;
    }
    // Validate CSRF
    if (!CUtils::checkCsrfTokenPost()) {
        $errors[] = "Invalid CSRF Token.";
        $isValid = FALSE;
    }
    
    // Validate and Sanitize form elements
    
    $commentText = filter_input(INPUT_POST, 'commentText', FILTER_UNSAFE_RAW);
    // Strip all tags except hyper-links
    $commentText = strip_tags($commentText, "<a>");
    $commentText = filter_var($commentText, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $commentText = trim($commentText);
    if (empty($commentText)) {
        $errors[] = "Invalid Comment Text.";
        $isValid = FALSE;        
    }
    
    $authorName = filter_input(INPUT_POST, 'authorName', FILTER_SANITIZE_SPECIAL_CHARS);
    $authorName = trim($authorName);
    if (empty($authorName)) {
        $errors[] = "Invalid Author Name.";
        $isValid = FALSE;        
    }
    
    $authorEmail = filter_input(INPUT_POST, 'authorEmail', FILTER_VALIDATE_EMAIL);
    $authorEmail = filter_var($authorEmail, FILTER_SANITIZE_EMAIL);
    $authorEmail = trim($authorEmail);
    if (empty($authorEmail)) {
        $errors[] = "Invalid Author Email.";
        $isValid = FALSE;        
    }
    
    // Save Form 
    if ($isValid) {
        $newComment = new CComment();
        $newComment->setData($postId, $commentText, $authorName, $authorEmail);
        $newComment->create();
        
        if (empty($newComment->id)) {
            $errors[] = "Error creating new post. Please try again.";
        }
    }
}
?>

<?php include_once("./html/page-header.php");?>
    <div id="content-main">
    <?php
        echo "<h2>";
        echo "<a href=\"post.php?id={$post->id}\">{$post->postTitle}</a>";
        echo "</h2>";
        echo "<p>" . html_entity_decode($post->postText) . "</p>";
        echo "By <a href=\"mailto:{$post->authorEmail}\">"
        . "{$post->authorName}</a> on " . CUtils::formatTS($post->ts) 
        . "<hr />";
    ?>
        <div id="comments"> 
            <h3> Comments </h3>
            <?php               
            $commentResult = $post->getComments();
            while ($comment = $commentResult->fetch_object()) {
                echo "<div class=\"comment-block\">";
                echo "On " . CUtils::formatTS($comment->ts) . " by ";
                echo "<a href=\"mailto:{$comment->authorEmail}\">{$comment->authorName}</a>";
                echo "<p class=\"comment-text\">" . html_entity_decode($comment->commentText)."</p>";
                echo "</div>";
            }
            ?>
            <h3> Add Comment </h3>
                <?php 
                    if (!empty($errors)) {
                        echo "<ul class=\"error\">";
                        foreach($errors as $error) {
                            echo "<li>$error</li>";
                        }
                        echo "</ul>";
                    }
                ?>
                <form method="post">
                    <label for="commentText"> Comment: </label>
                    <textarea name="commentText" id="postText" 
                              rows="5" cols="60"><?php 
                              echo $commentText; 
                              ?></textarea>         
                    <br />
                    <label for="authorName"> Author: </label>
                    <input type="text" name="authorName" id="authorName" 
                           value="<?php echo $authorName; ?>" size="75" />                    
                    <br />
                    <label for="authorEmail"> Email: </label>
                    <input type="text" name="authorEmail" id="authorEmail" 
                           value="<?php echo $authorEmail; ?>" size="75" />       
                    <?php
                        $csrf = CUtils::generateCsrfToken();
                    ?>    
                    <input type="hidden" name="<?php echo $csrf['csrfKey']; ?>" 
                           value="<?php echo $csrf['csrfValue']; ?>" 
                           size="75" />                          
                    <br />
                    <?php
                        echo recaptcha_get_html($config['captcha_publickey']);
                    ?>
                    <input type="submit" value="Submit">
                </form>            
        </div>
    </div>
<?php include_once("./html/page-footer.php");?>