<?php 
include_once './lib/appconfig.php';
include_once './lib/recaptchalib.php';

// Handle Actions
$postTitle = '';
$postText = '';
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
    $postTitle = filter_input(INPUT_POST, 'postTitle', 
            FILTER_SANITIZE_SPECIAL_CHARS);
    $postTitle = trim($postTitle);
    if (empty($postTitle)) {
        $errors[] = "Invalid Title.";
        $isValid = FALSE;        
    }
    
    $postText = filter_input(INPUT_POST, 'postText', FILTER_UNSAFE_RAW);
    // Strip all tags except hyper-links
    $postText = strip_tags($postText, "<a>");
    $postText = filter_var($postText, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $postText = trim($postText);
    if (empty($postText)) {
        $errors[] = "Invalid Post Text.";
        $isValid = FALSE;        
    }
    
    $authorName = filter_input(INPUT_POST, 'authorName', 
            FILTER_SANITIZE_SPECIAL_CHARS);
    $authorName = trim($authorName);
    if (empty($authorName)) {
        $errors[] = "Invalid Author Name.";
        $isValid = FALSE;        
    }
    
    $authorEmail = filter_input(INPUT_POST, 'authorEmail', 
            FILTER_VALIDATE_EMAIL);
    $authorEmail = filter_var($authorEmail, 
            FILTER_SANITIZE_EMAIL);
    $authorEmail = trim($authorEmail);
    if (empty($authorEmail)) {
        $errors[] = "Invalid Author Email.";
        $isValid = FALSE;        
    }
    
    // Save Form 
    if ($isValid) {
        $newPost = new CPost();
        $newPost->setData($postTitle, $postText, $authorName, $authorEmail);
        $newPost->create();
        
        if (!empty($newPost->id)) {
            $successMessage = "New post has been created. "
                    . "<a href=\"post.php?id={$newPost->id}\">"
                    . "Click here to view</a>";
        } else {
            $errors[] = "Error creating new post. Please try again.";
        }
    }
}
?>
<?php include_once("./html/page-header.php");?>
    <div id="content-main"> <h2>Create New Post &raquo;</h2>
        <?php 
            if (!empty($errors)) {
                echo "<ul class=\"error\">";
                foreach($errors as $error) {
                    echo "<li>$error</li>";
                }
                echo "</ul>";
            } else if(!empty($successMessage)) {
                echo "<br /> <span class=\"success\"> $successMessage "
                        . "</span> <br /> ";
            }
        ?>
        <form method="post">
            <label for="postTitle"> Title: </label>
            <input type="text" name="postTitle" id="postTitle" 
                   value="<?php echo $postTitle; ?>" size="75" />
            <br />
            <label for="postText"> Content: </label>
            <textarea name="postText" id="postText" 
                      rows="5" cols="60"><?php echo $postText; ?></textarea>         
            <br />
            <label for="authorName"> Author: </label>
            <input type="text" name="authorName" id="authorName" 
                   value="<?php echo $authorName; ?>" size="75" />                    
            <br />
            <label for="authorEmail"> Email: </label>
            <input type="email" name="authorEmail" id="authorEmail" 
                   value="<?php echo $authorEmail; ?>" size="75" />       
            <?php
                $csrf = CUtils::generateCsrfToken();
            ?>    
            <input type="hidden" name="<?php echo $csrf['csrfKey']; ?>" 
                   value="<?php echo $csrf['csrfValue']; ?>" size="75" />                          
            <br />
            <?php
                echo recaptcha_get_html($config['captcha_publickey']);
            ?>
            <input type="submit" value="Submit">
        </form>
    </div>
<?php include_once("./html/page-footer.php");?>