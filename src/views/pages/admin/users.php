<section>
    <h2>Users</h2>
    <table summary="List of users with actions for deleting, editing, and viewing details">
        <thead>
            <tr>
                <th scope="col">Delete</th>
                <th scope="col">Mail</th>
                <th scope="col">Balance</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4">
                    <a id="add" href="/dashboard/add/user" aria-label="Add a new user">
                        <span aria-hidden="true">+</span>
                    </a>
                </td>
            </tr>
            <?php foreach($data["users"] as $user): ?>
            <tr>
                <td>
                    <button class="delete" onclick="deleteUser(<?php echo $user['id_user']; ?>)" aria-label="Delete user">
                        <span aria-hidden="true">
                            <i class="bi bi-close"></i>
                        </span>
                    </button>
                </td>
                <td><?php echo $user['mail']; ?></td>
                <td><?php echo $user['balance']; ?></td>
                <td>
                    <button class="edit" aria-label="Edit user details">
                        <span aria-hidden="true">
                            <i class="bi bi-pencil"></i>
                        </span>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<div class="div"></div>
<form action="">
    <h2>Update User Balance</h2>
    <ul>
        <li>
            <label for="mail">Mail</label>
            <input type="email" id="input-user_mail" name="mail" autocomplete="email" required />
        </li>
        <li>
            <label for="input-user_balance">Balance</label>
            <input type="number" name="user_balance" id="input-user_balance" placeholder="€" aria-required="true" />
        </li>
        <li id="li-form_reset" class="split">
            <div class="button">
                <i class="bi bi-x"></i>
                <button class="close" type="button" id="btn-user_reset" aria-label="Reset Form">Reset</button>
            </div>
        </li>
        <li class="split">
            <div class="button">
                <i class="bi bi-cash"></i>
                <button type="button" id="btn-user_submit" aria-label="Update Balance">Update</button>
            </div>
        </li>
    </ul>
</form>