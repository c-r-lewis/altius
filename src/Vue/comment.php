<?php
use App\Altius\Modele\DataObject\Comment;
/** @var Comment $comment */
?>
<div>
    <div class="card-text">
        <div class="fs-5">
            <strong><?=$comment->getUserID();?></strong>
            <?=$comment->getComment();?>
        </div>
        <div>
            <!-- Like button -->
        </div>
    </div>
    <div>
        <div class="d-flex fs-6">
            <?=$comment->calculateTime()?>
            <button class="btn p-0">Répondre</button>
        </div>
        <p><!-- Number of likes --></p>
    </div>
</div>