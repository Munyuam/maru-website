<div class="page-header mb-4">
    <div class="flex items-center gap-3">
        <a href="/admin/announcements" class="btn btn-sm btn-light text-muted hover-bg-light rounded-pill px-3 shadow-sm">
            <i class="ph ph-arrow-left mr-1"></i> Back to Announcements
        </a>
    </div>
</div>

<div class="card max-w-2xl mx-auto shadow-sm border-0 rounded-lg">
    <div class="card-header bg-white border-bottom py-3 px-4">
        <h2 class="text-lg font-bold m-0"><i class="ph ph-megaphone text-primary mr-2"></i> New Announcement</h2>
    </div>
    <div class="card-body p-4">
        <form action="/admin/announcements/create" method="POST">
            <div class="form-group mb-4">
                <label for="title" class="form-label font-bold text-sm uppercase tracking-wider">Title</label>
                <input type="text" id="title" name="title" class="form-input" required placeholder="e.g. Upcoming Tournament Registration">
            </div>

            <div class="form-group mb-4">
                <label for="type" class="form-label font-bold text-sm uppercase tracking-wider">Type</label>
                <select id="type" name="type" class="form-input">
                    <option value="info">Information</option>
                    <option value="warning">Warning</option>
                    <option value="success">Success</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="message" class="form-label font-bold text-sm uppercase tracking-wider">Message</label>
                <textarea id="message" name="message" class="form-input" rows="6" required placeholder="Write your announcement here..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-3 border-top">
                <a href="/admin/announcements" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Publish Announcement</button>
            </div>
        </form>
    </div>
</div>
