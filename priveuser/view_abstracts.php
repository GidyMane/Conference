<?php
require 'db.php';

$id = intval($_GET['id']);
$q = mysqli_query($conn, "SELECT * FROM newsubmissions WHERE id=$id");
$data = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Abstract</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<a href="abstracts.php" class="btn btn-secondary mb-3">← Back</a>

<h4><?= htmlspecialchars($data['title']) ?></h4>

<p><strong>Author:</strong> <?= $data['name'] ?> (<?= $data['email'] ?>)</p>
<p><strong>Organization:</strong> <?= $data['organization'] ?></p>
<p><strong>Phone:</strong> <?= $data['phone'] ?></p>
<p><strong>Sub-theme:</strong> <?= $data['sub_theme'] ?></p>

<hr>

<h5>Abstract</h5>
<p><?= nl2br(htmlspecialchars($data['abstract'])) ?></p>

<hr>
<p><strong>Status:</strong> <?= $data['status'] ?></p>
<p><strong>Reason:</strong> <?= $data['reason'] ?></p>

</body>
</html>
