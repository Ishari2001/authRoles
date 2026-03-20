<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Commission Logs</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
/* =========================
   GLOBAL
========================= */
body {
    margin: 0;
    font-family: "Inter", sans-serif;
    background: linear-gradient(135deg, #0b1220, #111827);
    color: #e5e7eb;
}

/* CONTAINER */
.container {
    max-width: 1100px;
    margin: auto;
    padding: 25px;
}

/* TITLE */
h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #ffffff;
}

/* CARD */
.card {
    background: rgba(17, 24, 39, 0.85);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
}

/* =========================
   TABLE STYLE
========================= */
table {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 12px;
}

/* HEADER */
thead {
    background: #1e293b;
}

/* TH TD */
th, td {
    padding: 14px;
    text-align: left;
    font-size: 14px;
}

/* ROW */
tbody tr {
    border-bottom: 1px solid rgba(255,255,255,0.06);
    transition: 0.2s;
}

/* HOVER */
tbody tr:hover {
    background: rgba(59,130,246,0.08);
}

/* AMOUNT STYLE */
.amount {
    font-weight: 700;
    color: #22c55e;
}

/* DATE */
.date {
    color: #94a3b8;
    font-size: 13px;
}

/* BADGE STYLE (optional nice look) */
.badge {
    padding: 4px 10px;
    border-radius: 999px;
    background: rgba(59,130,246,0.15);
    color: #60a5fa;
    font-size: 12px;
}
</style>

</head>

<body>

<div class="container">

    <h3>💰 Commission Logs</h3>

    <div class="card">

        <table>

            <thead>
                <tr>
                    <th>Receiver</th>
                    <th>From User</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>

            <?php if(!empty($commissions)): ?>
                <?php foreach($commissions as $c): ?>
                <tr>

                    <td>
                        <span class="badge">
                            <?= esc($c['sponsor_name'] ?? 'N/A') ?>
                        </span>
                    </td>

                    <td><?= esc($c['from_name'] ?? 'N/A') ?></td>

                    <td class="amount">
                        Rs <?= number_format($c['amount'],2) ?>
                    </td>

                    <td class="date">
                        <?= date('Y-m-d', strtotime($c['created_at'])) ?>
                    </td>

                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align:center; padding:20px; color:#94a3b8;">
                        No commission records found
                    </td>
                </tr>
            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>