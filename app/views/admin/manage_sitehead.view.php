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

    <label for="land_id">land:</label>
    <select name="land_id" id="land_id">
        <option value="">All</option>
        <option value="1" <?= (isset($_GET['land_id']) && $_GET['land_id'] == '1') ? 'selected' : '' ?>>1</option>
        <option value="2" <?= (isset($_GET['land_id']) && $_GET['land_id'] == '2') ? 'selected' : '' ?>>2</option>
    </select>

    <button type="submit">Filter</button>
</form>
        <a href="<?= URLROOT ?>/Admin/add_sitehead/">
            <button class="Addsupervisor" id="Addsupervisor">Add sitehead</button>
        </a>
    </div>

    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>land</th>
                                <th> land address</th>

                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="supervisor-list">
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $sitehead): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($sitehead->full_name) ?>
                            <button class="profile-btn" onclick="window.location.href='<?= URLROOT ?>/Admin/Manage_sitehead/getid/<?= $sitehead->id ?>';">
                                <img src="<?= URLROOT ?>/assets/images/user.png" class="menu-icon">view profile
                            </button>
                        </td>
                        <td><?= htmlspecialchars($sitehead->land_id) ?></td>
                        <td><?= htmlspecialchars($sitehead->address) ?></td>
                        <td><?= $sitehead->status == 0 ? "Active" : "Inactive" ?></td>
                        <td>
                            <button class="green-btn toggle-edit-btn" data-id="<?= $sitehead->id ?>">Edit</button>
                            <?php if ($sitehead->status != 0): ?>
                                <button class="red-btn" onclick="window.location.href='<?= URLROOT ?>/Admin/Manage_sitehead/delete_sitehead/<?= $sitehead->id ?>';">Remove</button>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- Inline Edit Form Row -->
                    <tr id="edit-row-<?= $sitehead->id ?>" class="edit-row" style="display: none;">
                        <td colspan="6">
                            <form class="form-styles inline-edit-form" method="POST" action="<?= URLROOT ?>/Admin/manage_sitehead/update_sitehead">
                                <input type="hidden" name="id" value="<?= $sitehead->id ?>">
                                <label>land:
                                    <select name="land_id" required>
                                        <?php foreach (['1', "2", "3", "4"] as $land_id): ?>
                                            <option value="<?= $land_id ?>" <?= $sitehead->land_id == $land_id ? "selected" : "" ?>><?= $land_id ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </label>
                                <label>Status:
                                    <select name="status" required>
                                        <option value="0" <?= $sitehead->status == 0 ? "selected" : "" ?>>Active</option>
                                        <option value="1" <?= $sitehead->status == 1 ? "selected" : "" ?>>Inactive</option>
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
