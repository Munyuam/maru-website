<div class="page-header flex justify-between items-center mb-4">
    <div class="header-content">
        <h1 class="text-2xl font-bold m-0">Posts</h1>
        <p class="text-muted m-0 mt-1">Manage landing page news and articles</p>
    </div>
    <div class="header-actions">
        <a  href="<?= url('/admin/posts/create') ?>"  class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="ph ph-plus mr-2"></i> New Post
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-lg overflow-hidden">
    <div class="card-body p-0">
        <?php if (!empty($posts)): ?>
            <table class="table w-full">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider text-muted border-bottom">
                        <th class="p-3 pl-4">Title</th>
                        <th class="p-3">Author</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Date</th>
                        <th class="p-3 text-right pr-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $p): ?>
                    <tr class="border-bottom hover-bg-light">
                        <td class="p-3 pl-4">
                            <div class="flex items-center gap-3">
                                <?php if (!empty($p['image'])): ?>
                                <img  src="<?= url('/public/uploads/posts/' . htmlspecialchars($p['image'])) ?>"  alt="" style="width: 48px; height: 36px; object-fit: cover; border-radius: 4px;">
                                <?php endif; ?>
                                <span class="font-medium"><?= htmlspecialchars($p['title']) ?></span>
                            </div>
                        </td>
                        <td class="p-3 text-sm"><?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?></td>
                        <td class="p-3">
                            <?php if ($p['is_published']): ?>
                                <span class="badge badge-success">Published</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-3 text-sm text-muted"><?= htmlspecialchars(date('M j, Y', strtotime($p['published_at'] ?? $p['created_at']))) ?></td>
                        <td class="p-3 pr-4 text-right">
                            <form  action="<?= url('/admin/posts/toggle/' . $p['id']) ?>"  method="POST" style="display: inline;">
                                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
                                <button type="submit" class="btn btn-sm btn-ghost" title="<?= $p['is_published'] ? 'Unpublish' : 'Publish' ?>">
                                    <?php if ($p['is_published']): ?>
                                        <i class="ph ph-eye-slash"></i>
                                    <?php else: ?>
                                        <i class="ph ph-eye text-success"></i>
                                    <?php endif; ?>
                                </button>
                            </form>
                            <a  href="<?= url('/admin/posts/edit/' . $p['id']) ?>"  class="btn btn-sm btn-ghost">
                                <i class="ph ph-pencil-simple"></i>
                            </a>
                            <form  action="<?= url('/admin/posts/delete/' . $p['id']) ?>"  method="POST" style="display: inline;" onsubmit="return confirm('Delete this post?')">
                                <input type="hidden" name="csrf_token" value="<?= \App\Helpers\Session::generateCsrfToken() ?>">
                                <button type="submit" class="btn btn-sm btn-ghost text-error">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center py-5 text-muted">
                <i class="ph ph-newspaper text-4xl mb-3 d-block"></i>
                <p class="m-0">No posts yet.</p>
                <a  href="<?= url('/admin/posts/create') ?>"  class="btn btn-primary btn-sm mt-3 rounded-pill">Create First Post</a>
            </div>
        <?php endif; ?>
    </div>
</div>
