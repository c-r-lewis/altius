<?php
use App\Altius\Modele\DataObject\Comment;
/** @var Comment $comment */
?>
<div>
    <div class="card-text">
        <p>
            <?=$comment->getComment();?>
        </p>
        <div>
            <!-- Like button -->
        </div>
    </div>
    <div>
        <p>
            <?=$comment->getDatePosted();?>
        </p>
        <p><!-- Number of likes --></p>
    </div>
</div>