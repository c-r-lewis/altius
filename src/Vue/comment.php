<?php
use App\Altius\Modele\DataObject\Comment;
/** @var Comment $comment */
?>
<div>
    <div class="card-text">
        <div class="d-flex flex-row">
            <span class="moderately-bold"><?=$comment->getUserID();?></span>
            <div class="ms-1"><?=$comment->getComment();?></div>
        </div>
        <div>
            <!-- Like button -->
        </div>
    </div>
    <div>
        <div class="d-flex">
            <div class="fs-small"><?=$comment->calculateTime()?></div>
            <button class="btn p-0 ms-2 fs-small moderately-bold no-outline-focus" onclick="replyToComment('<?= $comment->getUserID() ?>')">Répondre</button>
        </div>
        <p><!-- Number of likes --></p>
    </div>
</div>