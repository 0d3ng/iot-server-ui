<?php if(count($data_group) || count($data_personal) ){ ?>
<div class="list-group  bg-inherit">
	<?php foreach ($data_personal as $d){ ?>
	<a class="list-group-item" onclick="addGroup('<?= $d->code_name?>',<?= $index?>)" style="cursor: pointer;">
		<i class="icon md-apps" aria-hidden="true"></i>Data <?= $d->name?> [<?= $d->code_name?>]
	</a>
	<input type="hidden" value="<?= $d->name?>" id="name-<?= $d->code_name?>">
    <?php } ?>
    <?php foreach ($data_group as $d) { ?>
	<a class="list-group-item" onclick="addGroup('<?= $d->code_name?>',<?= $index?>)" style="cursor: pointer;">
		<i class="icon md-apps" aria-hidden="true"></i>Data <?= $d->name?> [<?= $d->code_name?>]
	</a>
	<input type="hidden" value="<?= $d->name?>" id="name-<?= $d->code_name?>">
    <?php } ?>
</div>
<?php } ?>

