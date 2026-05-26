<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Session;
use App\Models\Post;

class PageController
{
    /**
     * Render the landing page.
     */
    public function welcome(): void
    {
        $pageTitle = 'MARU - Online Player Registration System';
        $posts = Post::findPublished();
        $hideHeader = true;
        $hideFooter = true;
        ob_start();
        require __DIR__ . '/../../views/pages/welcome.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/main.php';
    }

    public function showPost(int $id): void
    {
        $post = Post::findById($id);
        if (!$post || !$post['is_published']) {
            header("HTTP/1.0 404 Not Found");
            $pageTitle = 'Post Not Found - MARU';
            ob_start();
            require __DIR__ . '/../../views/pages/404.php';
            $content = ob_get_clean();
            require __DIR__ . '/../../views/layouts/main.php';
            return;
        }
        $otherPosts = Post::findPublishedExcept($id);
        $pageTitle = htmlspecialchars($post['title']) . ' - MARU';
        ob_start();
        require __DIR__ . '/../../views/pages/post.php';
        $content = ob_get_clean();
        require __DIR__ . '/../../views/layouts/main.php';
    }
}
