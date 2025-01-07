<h2 class="admin-vinyls-header">Vinyls</h2>
<table summary="List of vinyls with actions for deleting, editing, and viewing details">
    <thead>
        <tr>
            <th scope="col">Delete</th>
            <th scope="col">Album Title</th>
            <th scope="col">Type</th>
            <th scope="col">Inch</th>
            <th scope="col">Rpm</th>
            <th scope="col">Cost</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6">
                <a id="add" href="/dashboard/add/user" aria-label="Add a new vinyl">
                    <span aria-hidden="true">+</span>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <button class="delete" onclick="deleteUser()" aria-label="Delete vinyl">
                    <span aria-hidden="true">x</span>
                </button>
            </td>
            <td>mail@example.com</td>
            <td>$100.00</td>
            <td>Card ending in 1234</td>
            <td>123 Main St</td>
            <td>
                <a class="edit" aria-label="Edit vinyl details">
                    <span aria-hidden="true"><i class="bi bi-pencil"></i></span>
                </a>
            </td>
        </tr>
    </tbody>
</table>