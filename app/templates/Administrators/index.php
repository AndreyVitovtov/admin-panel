<a href="/administrators/add" class="btn">Add</a>

<table class="table table-bordered table-striped table-hover mt-3 rounded">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col"><?= __('name') ?></th>
        <th scope="col"><?= __('login') ?></th>
        <th scope="col"><?= __('role') ?></th>
        <th scope="col" class="table-actions"><?= __('actions') ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($administrators ?? [] as $adm): ?>
        <tr class="align-middle">
            <td><?= $adm['id'] ?></td>
            <td><?= $adm['name'] ?></td>
            <td><?= $adm['login'] ?></td>
            <td><?= $adm['title'] ?></td>
            <td class="table-actions">
                <a href="/administrators/edit/<?= $adm['id'] ?>" class="btn">
                    <i class="icon-edit"></i>
                    <span class="desk"><?= __('edit') ?></span>
                </a>
                <button form="delete-adm-<?= $adm['id'] ?>" class="btn">
                    <i class="icon-trash"></i>
                    <span class="desk"><?= __('delete') ?></span>
                </button>
                <form action="/administrators/delete" method="POST"
                      class="form-confirm"
                      id="delete-adm-<?= $adm['id'] ?>"
                      data-title="<?= __('deletion confirmation') ?>"
                      data-body="<?= __('are you sure you want to remove the administrator') ?>"
                      data-id="delete-adm-<?= $adm['id'] ?>"
                >
                    <input type="hidden" name="id" value="<?= $adm['id'] ?>">
                </form>
            </td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>