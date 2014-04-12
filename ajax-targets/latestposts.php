<?php 
include_once '../lib/appconfig.php';

// Fetch all Blog Posts
$postsResult = CBlog::getAllPosts();
while ($post = $postsResult->fetch_object()) {
    echo "<h2><a href=\"post.php?id={$post->id}\">{$post->postTitle}</a></h2>";
    echo "<p>" . html_entity_decode(CUtils::truncateText($post->postText)) . "</p>";
    echo "By <a href=\"mailto:{$post->authorEmail}\">{$post->authorName}</a> on " . CUtils::formatTS($post->ts);
    echo "<hr />";
}

