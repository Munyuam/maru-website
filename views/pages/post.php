<div class="container py-8 post-container">
    <a href="<?= url('/') ?>" class="btn btn-ghost btn-sm mb-4">
        <i class="ph ph-arrow-left mr-1"></i> Back to Home
    </a>

    <article class="card p-6">
        <?php if (!empty($post['image'])): ?>
        <div class="mb-6 post-image-wrapper">
            <img src="<?= url('/public/uploads/posts/' . htmlspecialchars($post['image'])) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="post-image">
        </div>
        <?php endif; ?>

        <div class="mb-4">
            <div class="flex items-center gap-3 text-sm text-muted mb-2">
                <span><i class="ph ph-user mr-1"></i> <?= htmlspecialchars($post['first_name'] . ' ' . $post['last_name']) ?></span>
                <span><i class="ph ph-calendar mr-1"></i> <?= htmlspecialchars(date('F j, Y', strtotime($post['published_at'] ?? $post['created_at']))) ?></span>
            </div>
            <h1 class="heading-2 m-0"><?= htmlspecialchars($post['title']) ?></h1>
        </div>

        <?php if (!empty($post['excerpt'])): ?>
        <p class="text-lg text-muted mb-6 post-excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
        <?php endif; ?>

        <div class="post-body">
            <?= nl2br(htmlspecialchars($post['body'])) ?>
        </div>
    </article>

    <?php if (!empty($otherPosts)): ?>
    <section class="mt-8">
        <h2 class="heading-4 mb-4">More News</h2>
        <div class="grid grid-3 gap-6">
            <?php foreach ($otherPosts as $op): ?>
            <a href="<?= url('/post/' . $op['id']) ?>" class="card overflow-hidden post-other-link">
                <?php if (!empty($op['image'])): ?>
                <img src="<?= url('/public/uploads/posts/' . htmlspecialchars($op['image'])) ?>" alt="<?= htmlspecialchars($op['title']) ?>" class="post-other-image">
                <?php endif; ?>
                <div class="p-4">
                    <small class="text-xs text-muted"><?= htmlspecialchars(date('M j, Y', strtotime($op['published_at'] ?? $op['created_at']))) ?></small>
                    <h3 class="text-sm font-bold mt-1 mb-1"><?= htmlspecialchars($op['title']) ?></h3>
                    <p class="text-xs text-muted m-0"><?= htmlspecialchars($op['excerpt'] ?? substr(strip_tags($op['body']), 0, 100)) ?>...</p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>
