<?php

$user = $this->vars->user;
$teachers = $this->vars->teachers;

?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Список учителей
        </h1>

        <table class="table table-bordered table-hover table-striped">
        	<thead>
        		<th>#</th>
        		<th>ФИО</th>
        		<th>Предмет</th>
        		<th></th>
        	</thead>
        	<tbody>
        		<?php foreach($teachers as $teacher): ?>
        		<tr>
        			<td><?= $teacher->id ?></td>
        			<td><?= $teacher->full_name ?></td>
        			<td><?= $teacher->subject_title ?></td>
        			<td><a href="/teacher/<?= $teacher->id ?>/">Редактировать</a></td>
        		</tr>
        		<?php endforeach; ?>
        	</tbody>
        </table>
    </div>
</div>
<!-- /.row -->