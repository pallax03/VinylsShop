<section aria-labelledby="user-info">
    <i class="bi bi-person-fill"></i>
    <div class="container center vertical">
        <h4 id="user-mail"><?php echo $user['mail'] ?></h4>
        <?php if($user['notifications']):?>
            <a href="/notifications">
                <p>See Notifications</p>
                <i class="bi bi-bell-fill"></i>
            </a>
        <?php else: ?>
            <span>
                <p>Notifications disabled</p>
                <i class="bi bi-bell-slash-fill"></i>
            </span>
        <?php endif; ?>
    </div>
</section>
<div class="div"></div>
<section>
    <h2>Users</h2>
    <table summary="List of users with actions for deleting, editing, and viewing details">
        <thead>
            <tr>
                <th scope="col">Delete</th>
                <th scope="col">Mail</th>
                <th scope="col">Balance</th>
                <th scope="col">Orders</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4">
                    <a href="/dashboard/register" class="add" id="add" aria-label="Add a new user">
                        <span aria-hidden="true"><i class="bi bi-plus"></i></span>
                    </a>
                </td>
            </tr>
            <?php foreach($data["users"] as $user): ?>
            <tr <?php echo $user['su'] == 1 ? 'class="star"' : ''; ?>>
                <td>
                    <button class="delete" onclick="deleteUser(<?php echo $user['id_user']; ?>)" aria-label="Delete user">
                        <span aria-hidden="true"><i class="bi bi-x"></i></span>
                    </button>
                </td>
                <td>
                    <p><?php echo $user['mail'] . ($user['su'] == 1 ? ' (⭐️)' : ''); ?></p>
                </td>
                <td>
                    <p><?php echo $user['balance']; ?>€</p>
                </td>
                <td>
                    <a href="/user/orders?id_user=<?php echo $user['id_user']; ?>" class="edit" aria-label="See user orders">
                        <span aria-hidden="true">
                            <i class="bi bi-box-seam-fill"></i>
                            <i class="bi bi-caret-right-fill"></i>
                        </span>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="callout">
        <p>Add in this table is to add a new admin.</p>
    </div>
</section>
<script src="/resources/js/user.js"></script>