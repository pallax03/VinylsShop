<h2>Users</h2>
<table summary="List of users with actions for deleting, editing, and viewing details">
    <thead>
        <tr>
            <th scope="col">Delete</th>
            <th scope="col">Mail</th>
            <th scope="col">Balance</th>
            <th scope="col">Default Card</th>
            <th scope="col">Default Address</th>
            <th scope="col">Edit</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6">
                <a id="add" href="/dashboard/add/user" aria-label="Add a new user">
                    <span aria-hidden="true">+</span>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <button class="delete" onclick="deleteUser()" aria-label="Delete user">
                    <span aria-hidden="true">x</span>
                </button>
            </td>
            <td>mail@example.com</td>
            <td>$100.00</td>
            <td>Card ending in 1234</td>
            <td>123 Main St</td>
            <td>
                <button class="edit" onclick="showModal()" aria-label="Edit user details">
                    <span aria-hidden="true"><i class="bi bi-pencil"></i></span>
                </button>
            </td>
        </tr>
    </tbody>
</table>