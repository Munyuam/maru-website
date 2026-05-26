<div class="page-header mb-4">
    <div class="flex items-center gap-3">
        <a  href="<?= url('/admin/posts') ?>"  class="btn btn-sm btn-light text-muted hover-bg-light rounded-pill px-3 shadow-sm">
            <i class="ph ph-arrow-left mr-1"></i> Back to Posts
        </a>
    </div>
</div>

<div class="card max-w-3xl mx-auto shadow-sm border-0 rounded-lg">
    <div class="card-header bg-white border-bottom py-3 px-4">
        <h2 class="text-lg font-bold m-0">
            <i class="ph ph-newspaper text-primary mr-2"></i>
            <?= $post ? 'Edit Post' : 'New Post' ?>
        </h2>
    </div>
    <div class="card-body p-4">
        <form action="<?= $post ? '/admin/posts/edit/' . $post['id'] : '/admin/posts/create' ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">

            <div class="form-group mb-4">
                <label for="title" class="form-label font-bold text-sm uppercase tracking-wider">Title</label>
                <input type="text" id="title" name="title" class="form-input" required value="<?= htmlspecialchars($post['title'] ?? '') ?>" placeholder="Post title">
            </div>

            <div class="form-group mb-4">
                <label for="excerpt" class="form-label font-bold text-sm uppercase tracking-wider">Excerpt</label>
                <textarea id="excerpt" name="excerpt" class="form-input" rows="2" placeholder="Short summary (optional)"><?= htmlspecialchars($post['excerpt'] ?? '') ?></textarea>
            </div>

            <div class="form-group mb-4">
                <label for="body" class="form-label font-bold text-sm uppercase tracking-wider">Body</label>
                <textarea id="body" name="body" class="form-input" rows="10" required placeholder="Post content..."><?= htmlspecialchars($post['body'] ?? '') ?></textarea>
            </div>

            <div class="form-group mb-4">
                <label class="form-label font-bold text-sm uppercase tracking-wider">Featured Image</label>
                <?php if (!empty($post['image'])): ?>
                <div class="mb-2">
                    <img  src="<?= url('/public/uploads/posts/' . htmlspecialchars($post['image'])) ?>"  alt="" style="max-width: 200px; max-height: 120px; border-radius: 4px;">
                </div>
                <?php endif; ?>
                <input type="file" id="image" name="image" class="form-input" accept="image/jpeg,image/png">
                <small class="text-muted text-xs">JPG or PNG, max 5MB</small>
            </div>

            <div class="form-group mb-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" <?= (isset($post) && $post['is_published']) ? 'checked' : '' ?>>
                    <span class="font-medium">Publish immediately</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-top">
                <a  href="<?= url('/admin/posts') ?>"  class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <?= $post ? 'Update Post' : 'Create Post' ?>
                </button>
            </div>
        </form>
    </div>
</div>
