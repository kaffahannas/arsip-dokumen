<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(1);
?>
<nav aria-label="Navigasi halaman">
    <ul class="pagination pagination-sm flex-wrap justify-content-center mb-0">
        <?php if ($pager->hasPrevious()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= esc($pager->getPrevious(), 'attr') ?>" aria-label="Sebelumnya">
                    <i class="bi bi-chevron-left" aria-hidden="true"></i>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item<?= $link['active'] ? ' active' : '' ?>">
                <a class="page-link" href="<?= esc($link['uri'], 'attr') ?>"
                   <?= $link['active'] ? 'aria-current="page"' : '' ?>>
                    <?= esc($link['title']) ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= esc($pager->getNext(), 'attr') ?>" aria-label="Berikutnya">
                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
