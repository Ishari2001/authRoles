<style>

/* ===== CARD CONTAINER ===== */
.dashboard-card{
    background:#1e293b;
    padding:25px;
    border-radius:16px;
    border:1px solid #334155;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
    margin-bottom:25px;
}

/* ===== TITLE ===== */
.dashboard-title{
    font-size:20px;
    font-weight:600;
    margin-bottom:20px;
    color:#94a3b8;
}


/* ===== STATS GRID ===== */
.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}

/* ===== STAT CARD ===== */
.stat-box{
    background:#0f172a;
    padding:20px;
    border-radius:14px;
    border:1px solid #334155;
    transition:0.3s;
}

.stat-box:hover{
    transform:translateY(-5px);
    border-color:#38bdf8;
}

.stat-label{
    font-size:13px;
    color:#94a3b8;
    margin-bottom:8px;
}

.stat-value{
    font-size:26px;
    font-weight:700;
    color:#94a3b8;
}

/* ===== TABLE ===== */
.table-modern{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

.table-modern th{
    background:#0f172a;
    color:#94a3b8;
    font-weight:500;
    text-align:left;
    padding:12px;
}

.table-modern td{
    padding:14px 12px;
    border-bottom:1px solid #334155;
}

.table-modern tr:hover{
    background:#020617;
}

/* ===== BADGES ===== */
.badge{
    padding:5px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.badge-super{
    background:#7c3aed;
    color:#fff;
}

.badge-admin{
    background:#2563eb;
    color:#fff;
}

.badge-user{
    background:#64748b;
    color:#fff;
}

/* ===== DELETE BUTTON ===== */
.btn-delete{
    padding:6px 10px;
    background:#ef4444;
    color:#fff;
    border:none;
    border-radius:6px;
    text-decoration:none;
    font-size:13px;
}

.btn-delete:hover{
    background:#dc2626;
}

/* SUCCESS ALERT */
.alert-success{
    background:#064e3b;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    color:#34d399;
}

</style>


<!-- ========================= -->
<!-- SYSTEM OVERVIEW -->
<!-- ========================= -->
<div class="dashboard-card">

    <div class="dashboard-title">📊 System Overview</div>

    <div class="stats-grid">

        <div class="stat-box">
            <div class="stat-label">Total Users</div>
            <div class="stat-value"><?= $totalUsers ?></div>
        </div>

        <div class="stat-box">
            <div class="stat-label">Total Tickets</div>
            <div class="stat-value"><?= $totalTickets ?></div>
        </div>

        <div class="stat-box">
            <div class="stat-label">Total Sales</div>
            <div class="stat-value">Rs <?= number_format($totalSales,2) ?></div>
        </div>

        <div class="stat-box">
            <div class="stat-label">Total Commission</div>
            <div class="stat-value">Rs <?= number_format($totalCommission,2) ?></div>
        </div>

    </div>

</div>


<!-- ========================= -->
<!-- USERS TABLE -->
<!-- ========================= -->
<div class="dashboard-card">

    <div class="dashboard-title">👥 All Users</div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <table class="table-modern">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Wallet</th>
            <th>Role</th>
            <th>Action</th>
        </tr>

        <?php foreach($users as $u): ?>

        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= esc($u['name']) ?></td>
            <td><?= esc($u['email']) ?></td>
            <td>Rs <?= number_format($u['wallet'],2) ?></td>

            <td>
                <?php if($u['role'] == 1): ?>
                    <span class="badge badge-super">Super Admin</span>
                <?php elseif($u['role'] == 2): ?>
                    <span class="badge badge-admin">Admin</span>
                <?php else: ?>
                    <span class="badge badge-user">User</span>
                <?php endif; ?>
            </td>

            <td>
                <a href="<?= base_url('superadmin/users/delete/'.$u['id']) ?>"
                   onclick="return confirm('Delete this user?')"
                   class="btn-delete">
                   Delete
                </a>
            </td>
        </tr>

        <?php endforeach; ?>

    </table>

</div>