<?php require "view_begin.php"; ?>


<h1> No such nobel prizes found! </h1>

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
<?php end if ?>

</ul>
<p>No nobel prize satisfies the given search criteria.</p>
</div>



<?php require "view_end.php"; ?>
