<?php 
$pageTitle = 'Player Details';
include __DIR__ . '/../../layouts/admin.php'; 
?>

<div class="page-header mb-4">
    <div class="flex items-center gap-3">
        <a href="/admin/players" class="btn btn-sm btn-light text-muted hover-bg-light rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left mr-1"></i> Back to Players</a>
    </div>
</div>

<div class="grid grid-3 gap-5">
    <div class="col-span-1">
        <div class="card shadow-sm border-0 rounded-lg mb-4 overflow-hidden">
            <div class="bg-primary text-center pt-5 pb-3 relative">
                <div class="avatar avatar-xl mx-auto bg-white text-primary flex items-center justify-center rounded-circle shadow-md border-4 border-white" style="width: 120px; height: 120px; font-size: 3rem; margin-bottom: -60px; font-weight: bold;">
                    JD
                </div>
            </div>
            <div class="card-body text-center pt-5 mt-4">
                <h2 class="text-2xl font-bold mb-1">John Doe</h2>
                <p class="text-muted mb-2 font-medium">Player ID: #PL-1001</p>
                <div class="mb-4">
                    <span class="badge badge-warning rounded-pill px-3 py-1 shadow-sm">Pending Approval</span>
                </div>
                
                <div class="info-list text-left border-top pt-4">
                    <div class="flex items-center mb-3">
                        <div class="text-muted w-8 text-center"><i class="fas fa-envelope"></i></div>
                        <div class="flex-1 font-medium">john.doe@example.com</div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="text-muted w-8 text-center"><i class="fas fa-phone"></i></div>
                        <div class="flex-1 font-medium">(555) 123-4567</div>
                    </div>
                    <div class="flex items-center mb-3">
                        <div class="text-muted w-8 text-center"><i class="fas fa-calendar"></i></div>
                        <div class="flex-1 font-medium">Jan 15, 2005 <span class="text-muted text-sm">(18 yrs)</span></div>
                    </div>
                    <div class="flex items-center">
                        <div class="text-muted w-8 text-center"><i class="fas fa-clock"></i></div>
                        <div class="flex-1 font-medium">Registered: Oct 15, 2023</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white border-bottom py-3">
                <h3 class="text-lg font-bold m-0"><i class="fas fa-clipboard-check text-primary mr-2"></i> Update Status</h3>
            </div>
            <div class="card-body">
                <form action="/admin/players/1/status" method="POST">
                    <div class="form-group mb-4">
                        <label class="text-sm font-medium text-muted uppercase tracking-wider mb-2 d-block">Admin Notes (Optional)</label>
                        <textarea class="form-control bg-light border-0 rounded" name="notes" rows="3" placeholder="Add a note about this decision..."></textarea>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" name="status" value="approve" class="btn btn-success flex-1 rounded-pill shadow-sm"><i class="fas fa-check mr-1"></i> Approve</button>
                        <button type="submit" name="status" value="reject" class="btn btn-danger flex-1 rounded-pill shadow-sm"><i class="fas fa-times mr-1"></i> Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-span-2">
        <div class="card shadow-sm border-0 rounded-lg mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h2 class="text-lg font-bold m-0"><i class="fas fa-running text-primary mr-2"></i> Athletic Information</h2>
            </div>
            <div class="card-body p-4">
                <div class="grid grid-2 gap-4">
                    <div class="info-group p-3 bg-light rounded">
                        <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Current Team</label>
                        <div class="text-dark font-medium text-lg flex items-center">
                            <span class="text-muted italic">Unassigned</span>
                            <button class="btn btn-sm btn-link text-primary ml-auto p-0">Assign</button>
                        </div>
                    </div>
                    <div class="info-group p-3 bg-light rounded">
                        <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Preferred Position</label>
                        <div class="text-dark font-medium text-lg">Midfielder</div>
                    </div>
                    <div class="info-group p-3 bg-light rounded">
                        <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Experience Level</label>
                        <div class="text-dark font-medium text-lg">Advanced (5+ years)</div>
                    </div>
                    <div class="info-group p-3 bg-light rounded">
                        <label class="text-muted text-xs uppercase font-bold tracking-wider mb-1 d-block">Jersey Number</label>
                        <div class="text-dark font-medium text-lg">10 <span class="badge bg-white text-muted border text-xs ml-2 align-middle">Requested</span></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white border-bottom py-3 flex justify-between items-center">
                <h2 class="text-lg font-bold m-0"><i class="fas fa-file-alt text-primary mr-2"></i> Documents & Requirements</h2>
                <span class="text-sm text-muted">2 of 3 Completed</span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-4 flex justify-between items-center border-bottom border-light">
                        <div class="flex items-center">
                            <div class="bg-success-light text-success rounded-circle p-2 mr-3 flex items-center justify-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-file-medical text-lg"></i>
                            </div>
                            <div>
                                <h4 class="m-0 font-bold text-dark mb-1">Medical Clearance Form</h4>
                                <span class="badge badge-success rounded-pill px-2 py-1 text-xs"><i class="fas fa-check mr-1"></i> Verified</span>
                            </div>
                        </div>
                        <a href="#" class="btn btn-sm btn-light text-primary rounded-pill px-3 shadow-sm">View File</a>
                    </li>
                    <li class="list-group-item p-4 flex justify-between items-center border-bottom border-light bg-warning-light" style="opacity: 0.9;">
                        <div class="flex items-center">
                            <div class="bg-warning text-white rounded-circle p-2 mr-3 flex items-center justify-center shadow-sm" style="width: 40px; height: 40px;">
                                <i class="fas fa-id-card text-lg"></i>
                            </div>
                            <div>
                                <h4 class="m-0 font-bold text-dark mb-1">ID Verification</h4>
                                <span class="badge bg-white text-warning border border-warning rounded-pill px-2 py-1 text-xs"><i class="fas fa-clock mr-1"></i> Pending Review</span>
                            </div>
                        </div>
                        <a href="#" class="btn btn-sm btn-warning text-white rounded-pill px-3 shadow-sm">Review Now</a>
                    </li>
                    <li class="list-group-item p-4 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="bg-success-light text-success rounded-circle p-2 mr-3 flex items-center justify-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-file-contract text-lg"></i>
                            </div>
                            <div>
                                <h4 class="m-0 font-bold text-dark mb-1">Waiver of Liability</h4>
                                <span class="badge badge-success rounded-pill px-2 py-1 text-xs"><i class="fas fa-check mr-1"></i> Signed Electronically</span>
                            </div>
                        </div>
                        <a href="#" class="btn btn-sm btn-light text-primary rounded-pill px-3 shadow-sm">View PDF</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
