<?php require "view_begin.php"; ?>


<h1> Results of the search </h1>

<div>
The criteria are the following:
<ul>
<?php if (isset($filters['name'])) : ?>
    <li> The name must contain the string "<?= e($filters['name']) ?>" </li>
<?php endif ?>

<?php if (isset($filters['year'])) : ?>
    <li> The Nobel Prize has been given <?= $filters['sign'] == '=' ? "in" : ($filters['sign'] == '<=' ? "before" : "after") ?> 
        <?= e($filters['year']) ?> </li>
<?php endif ?>


<?php if (isset($filters['categories'])) : ?>
    <li> The Category is among the following: <?= e(join(', ', $filters['categories'])) ?>. </li>
<?php endif ?>

</ul>
<p>There are <?= e($nb_np) ?> nobel prizes satisfying the search criteria.</p>
</div>



<?php require 'view_list_nobel.php'; ?>    

<?php if (count($links) > 1) : ?>
    <div class="listePages">

        <p> Pages: </p>
        <?php if ($active > 1) : ?>
            <a class="lienStart prev" href="?controller=search&action=results&start=<?= e($active) - 1 ?>"> <img class="icone" src="Content/img/previous-icon.png" alt="Previous" /> </a>
        <?php endif ?>
        <?php foreach ($links as $page) : ?>
            <a class="<?= $page == $active ? "lienStart active" : "lienStart" ?>" href="?controller=search&action=results&start=<?= e($page) ?>"> <?= e($page) ?> </a>
        <?php endforeach ?> 

        <?php if ($active < $nb_total_pages) : ?>
            <a class="lienStart next" href="?controller=search&action=results&start=<?= e($active) + 1 ?>"> <img class="icone" src="Content/img/next-icon.png" alt="Next" /> </a>
        <?php endif ?>

    </div>
<?php endif ?>




<?php require "view_end.php"; ?>
