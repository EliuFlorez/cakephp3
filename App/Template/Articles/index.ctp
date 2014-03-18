<!-- File: /App/Template/Articles/index.ctp -->

<h1>Blog articles</h1>
<p><?= $this->Html->link('Add Article', ['action' => 'add']) ?></p>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Actions</th>
    </tr>

<!-- Here's where we loop through our $articles query object, printing out article info -->

    <?php foreach ($articles as $article): ?>
    <tr>
        <td><?= $article->id ?></td>
        <td>
            <?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?>
        </td>
        <td>
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $article->id],
                ['confirm' => 'Are you sure?'])
            ?> - 
            <?= $this->Html->link('Edit', ['action' => 'edit', $article->id]) ?> - 
			<a id="<?= $article->id ?>" href="javascript:void(0);" class="article_delete">Ajax Delete</a> - 
			<a id="<?= $article->id ?>" href="javascript:void(0);" class="article_status">Ajax Estatus</a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>