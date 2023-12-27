<table>
    <tr> <th>Name</th> <th>Category</th> <th>Year</th> <th class="sansBordure"></th> <th class="sansBordure"></th></tr>

    <?php foreach ($liste as $pn) : ?>
    <tr>
        <td>  <a href="?controller=list&action=informations&id=<?= e($pn['id']) ?>">  <?= e($pn['name']) ?> </a></td>
        <td> <?= e(ucfirst($pn['category'])) ?> </td>
        <td> <?= e($pn['year']) ?> </td>
        <td class="sansBordure">
            <a href="?controller=set&action=form_update&id=<?= e($pn['id']) ?>">
                <img class="icone" src="Content/img/edit-icon.png" alt="modifier"/>
            </a>
        </td>
        <td class="sansBordure">
            <a href="?controller=set&action=remove&id=<?= e($pn['id']) ?>">
                <img class="icone" src="Content/img/remove-icon.png" alt="supprimer"/>
            </a>
        </td>
    </tr>
    <?php endforeach ?> 
</table>

