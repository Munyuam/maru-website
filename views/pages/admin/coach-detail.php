<?php 
$pageTitle = 'Coach Details';
include __DIR__ . '/../../layouts/admin.php'; 
?>

<div class="page-header mb-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="/admin/coaches" class="btn btn-sm btn-light text-muted hover-bg-light rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Back</a>
        </div>
        <div class="actions flex gap-2">
            <button class="btn btn-outline-secondary rounded-pill px-4 bg-white shadow-sm"><i class="fas fa-envelope mr-1"></i> Message</button>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="fas fa-edit mr-1"></i> Edit Profile</button>
        </div>
    </div>
</div>

<div class="grid grid-3 gap-5">
    <div class="col-span-1">
        <div class="card shadow-sm border-0 rounded-lg mb-4 text-center overflow-hidden">
            <div class="bg-primary h-24"></div>
            <div class="card-body pt-0 relative">
                <img src="https://ui-avatars.com/api/?name=Coach+Smith&background=0D8ABC&color=fff&size=128" alt="Coach Avatar" class="rounded-circle border-4 border-white shadow-md mx-auto relative" style="margin-top: -64px; margin-bottom: 1rem;">
                <h2 class="text-2xl font-bold mb-1">Coach Smith</h2>
                <p class="text-primary font-medium mb-3">Head Coach</p>
                <span class="badge badge-success rounded-pill px-3 py-1 shadow-sm mb-4"><i class="fas fa-circle text-xs mr-1" style="font-size: 8px;"></i> Active Member</span>
                
                <div class="info-list text-left border-top pt-4">
                    <div class="flex items-center mb-3">
                        <div class="text-muted w-8 text-center"><i class="fas fa-envelope"></i></div>
                        <div class="flex-1 text-dark font-medium">smith@example.com</div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="text-muted w-8 text-center"><i class="fas fa-phone"></i></div>
                        <div class="flex-1 text-dark font-medium">(555) 987-6543</div>
                    </div>
                    <div class="flex items-center">
                        <div class="text-muted w-8 text-center"><i class="fas fa-calendar-alt"></i></div>
                        <div class="flex-1 text-dark font-medium">Joined Mar 2022</div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-top-0 py-3">
                <button class="btn btn-sm btn-outline-danger w-100 rounded-pill hover-bg-danger hover-text-white transition"><i class="fas fa-ban mr-1"></i> Suspend Account</button>
            </div>
        </div>
    </div>
    
    <div class="col-span-2">
        <div class="card shadow-sm border-0 rounded-lg mb-4">
            <div class="card-header bg-white border-bottom py-3 flex justify-between items-center">
                <h2 class="text-lg font-bold m-0"><i class="fas fa-users text-primary mr-2"></i> Assigned Team</h2>
                <button class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">Change Assignment</button>
            </div>
            <div class="card-body p-4">
                <div class="flex items-center p-4 border border-light rounded-lg bg-light-primary hover-shadow transition relative overflow-hidden">
                    <div class="absolute top-0 bottom-0 left-0 w-1 bg-primary"></div>
                    <div class="team-logo mr-4">
                        <div class="avatar avatar-lg bg-white text-danger rounded shadow-sm flex items-center justify-center text-2xl font-bold border" style="width:72px;height:72px;">DR</div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center mb-1">
                            <h3 class="text-xl font-bold m-0 text-dark">Dragons</h3>
                            <span class="badge badge-info rounded-pill ml-3 px-2 py-1">U-18 Division</span>
                        </div>
                        <p class="text-muted mb-0">Currently managing <strong class="text-dark">18</strong> active players.</p>
                    </div>
                    <div>
                        <a href="/admin/teams/1" class="btn btn-primary rounded-pill px-4 shadow-sm">View Team Dashboard <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white border-bottom py-3">
                <h2 class="text-lg font-bold m-0"><i class="fas fa-certificate text-primary mr-2"></i> Certifications & Background</h2>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-4 flex justify-between items-center border-bottom border-light">
                        <div>
                            <h4 class="m-0 font-bold text-dark mb-1">Coaching License</h4>
                            <p class="text-muted text-sm m-0">A-Level Professional Certification</p>
                        </div>
                        <span class="badge badge-success rounded-pill px-3 py-1"><i class="fas fa-check-circle mr-1"></i> Valid</span>
                    </li>
                    <li class="list-group-item p-4 flex justify-between items-center border-bottom border-light">
                        <div>
                            <h4 class="m-0 font-bold text-dark mb-1">Background Check</h4>
                            <p class="text-muted text-sm m-0">Cleared on Jan 10, 2023</p>
                        </div>
                        <span class="badge badge-success rounded-pill px-3 py-1"><i class="fas fa-check-circle mr-1"></i> Clear</span>
                    </li>
                    <li class="list-group-item p-4 flex justify-between items-center border-bottom border-light bg-warning-light" style="opacity: 0.9;">
                        <div>
                            <h4 class="m-0 font-bold text-dark mb-1">First Aid / CPR</h4>
                            <p class="text-muted text-sm m-0">Expires Dec 2023</p>
                        </div>
                        <span class="badge bg-white text-warning border border-warning rounded-pill px-3 py-1"><i class="fas fa-exclamation-triangle mr-1"></i> Expiring Soon</span>
                    </li>
                    <li class="list-group-item p-4 flex justify-between items-center">
                        <div>
                            <h4 class="m-0 font-bold text-dark mb-1">Safeguarding Course</h4>
                            <p class="text-muted text-sm m-0">Completed Module 1 & 2</p>
                        </div>
                        <span class="badge badge-success rounded-pill px-3 py-1"><i class="fas fa-check-circle mr-1"></i> Valid</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
