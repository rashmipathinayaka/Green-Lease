<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= URLROOT; ?>/assets/css/admin/manage-supervisor.css">
    <title>Manage Supervisors</title>
</head>

<body>
    <?php
    require ROOT . '/views/admin/sidebar.php';
    require ROOT . '/views/components/topbar.php';
    ?>

    <center><h1>Manage Supervisors</h1></center>
    <br><br>

    <div class="filter-section">
    <form method="GET" action="" class="filter-form" style="margin-bottom: 20px; text-align: center;">
    <label for="name">Name:</label>
    <input type="text" name="full_name" id="full_name" value="<?= isset($_GET['full_name']) ? htmlspecialchars($_GET['full_name']) : '' ?>">

    <label for="zone">Zone:</label>
    <select name="zone" id="zone">
        <option value="">All</option>
        <option value="1" <?= (isset($_GET['zone']) && $_GET['zone'] === '1') ? 'selected' : '' ?>>1</option>
        <option value="2" <?= (isset($_GET['zone']) && $_GET['zone'] === '2') ? 'selected' : '' ?>>2</option>
    </select>

    <button type="submit">Filter</button>
</form>
        <a href="<?= URLROOT ?>/Admin/add_supervisor/">
            <button class="Addsupervisor" id="Addsupervisor">Add supervisor</button>
        </a>
    </div>

    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Zone</th>
                <th>Status</th>
                <th>No. of Lands</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="supervisor-list">
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $supervisor): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($supervisor->full_name) ?>
                            <button class="profile-btn" onclick="window.location.href='<?= URLROOT ?>/Admin/Manage_supervisor/getid/<?= $supervisor->id ?>';">
                                <img src="<?= URLROOT ?>/assets/images/user.png" class="menu-icon">view profile
                            </button>
                        </td>
                        <td><?= htmlspecialchars($supervisor->zone) ?></td>
                        <td><?= $supervisor->status == 0 ? "Active" : "Inactive" ?></td>
                        <td><?= htmlspecialchars($supervisor->land_count) ?></td>
                        <td>
                            <button class="green-btn toggle-edit-btn" data-id="<?= $supervisor->id ?>">Edit</button>
                            <?php if ($supervisor->status != 0): ?>
                                <button class="red-btn" onclick="window.location.href='<?= URLROOT ?>/Admin/Manage_supervisor/delete_supervisor/<?= $supervisor->id ?>';">Remove</button>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- Inline Edit Form Row -->
                    <tr id="edit-row-<?= $supervisor->id ?>" class="edit-row" style="display: none;">
                        <td colspan="6">
                            <form class="form-styles inline-edit-form" method="POST" action="<?= URLROOT ?>/Admin/manage_supervisor/update_supervisor">
                                <input type="hidden" name="id" value="<?= $supervisor->id ?>">
                                <label>Zone:
                                    <select name="zone" required>
                                        <?php foreach (["1", "2", "3", "4"] as $zone): ?>
                                            <option value="<?= $zone ?>" <?= $supervisor->zone == $zone ? "selected" : "" ?>><?= $zone ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                                <label>Status:
                                    <select name="status" required>
                                        <option value="0" <?= $supervisor->status == 0 ? "selected" : "" ?>>Active</option>
                                        <option value="1" <?= $supervisor->status == 1 ? "selected" : "" ?>>Inactive</option>
                                    </select>
                                </label>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No supervisors available.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editButtons = document.querySelectorAll(".toggle-edit-btn");

            editButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const id = this.getAttribute("data-id");
                    const row = document.getElementById(`edit-row-${id}`);

                    // Close other open edit rows
                    document.querySelectorAll(".edit-row").forEach(r => {
                        if (r !== row) r.style.display = "none";
                    });

                    // Toggle current row
                    if (row.style.display === "none") {
                        row.style.display = "table-row";
                        row.scrollIntoView({ behavior: "smooth", block: "center" });
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    </script>

</body>
</html>
