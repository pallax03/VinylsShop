<h2 class="admin-vinyls-header">Vinyls</h2>
<table summary="List of vinyls with actions for deleting, editing, and viewing details">
    <thead>
        <tr>
            <th scope="col">Delete</th>
            <th scope="col">Title</th>
            <th scope="col">Info</th>
            <th scope="col">Cost</th>
            <th scope="col">Edit</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="7">
                <a id="add" class="add" href="/dashboard/add/user" aria-label="Add a new vinyl">
                    <span aria-hidden="true">+</span>
                </a>
            </td>
        </tr>
        <?php foreach($data["vinyls"] as $vinyl):
            echo ('<tr">
                <td colspan="0.5">
                    <button class="delete" onclick="deleteUser()" aria-label="Delete vinyl">
                        <span aria-hidden="true">x</span>
                    </button>
                </td>
                <td colspan="2">' . $vinyl["title"] . '</td>
                <td colspan="3"> ' . $vinyl["type"] . ' - ' . $vinyl["inch"] . ' - ' . $vinyl["rpm"] . '</td>
                <td colspan="1">€' . $vinyl["cost"] . '</td>
                <td colspan="0.5">
                    <a class="edit" aria-label="Edit vinyl details">
                        <span aria-hidden="true"><i class="bi bi-pencil"></i></span>
                    </a>
                </td>
            </tr>');
        endforeach;
        ?>
    </tbody>
</table>