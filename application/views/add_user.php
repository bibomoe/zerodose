<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Baru</title>
</head>
<body>
    <h1>Tambah User Baru</h1>

    <?php if ($this->session->flashdata('success')): ?>
        <p style="color: green;"><?php echo $this->session->flashdata('success'); ?></p>
    <?php endif; ?>

    <?php echo validation_errors(); // Tampilkan pesan error validasi ?>

    <form action="<?php base_url('user/add_user'); ?>" method="post">
        <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>

        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>

        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>

        <label for="category">Category:</label>
        <input type="text" name="category">
        <br>

        <label for="partner_category">Partner Category:</label>
        <input type="text" name="partner_category">
        <br>

        <button type="submit">Tambah User</button>
    </form>
</body>
</html>
