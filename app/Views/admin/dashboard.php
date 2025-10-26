<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="main-content">
        <table>
            <thead>
                <tr>
                    <th>USER ID</th>
                    <th>FIRST NAME</th>
                    <th>LAST NAME</th>
                    <th>EMAIL</th>
                    <th>GENDER</th>
                    <th>STREET</th>
                    <th>CITY</th>
                    <th>ROLE</th>
                    <th>CREATED AT</th>
                    <th>UPDATED AT</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($data as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_id']) ?></td>
                        <td><?= htmlspecialchars($user['first_name']) ?></td>
                        <td><?= htmlspecialchars($user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['gender']) ?></td>
                        <td><?= htmlspecialchars($user['street']) ?></td>
                        <td><?= htmlspecialchars($user['city']) ?></td>
                        <td>
                            <?php 
                            switch ($user['role']) {
                                case 0: $roleName = 'Guest'; break;
                                case 1: $roleName = 'Customer'; break;
                                case 2: $roleName = 'Staff'; break;
                                case 3: $roleName = 'Admin'; break;
                                default: $roleName = 'Unknown';
                            }
                            echo htmlspecialchars($roleName); 
                            ?>
                        </td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                        <td><?= htmlspecialchars($user['updated_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>