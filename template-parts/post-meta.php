<?php
if (is_front_page () && !is_home()) {
    return;
}

$meta = whiteturtle_get_post_meta ();

if (!$meta) {
    return;
}
?>
<div class="post-meta">
    
    <?php foreach ($meta[ 'items' ] as $name => $item): ?>
        <div class="post-meta__row post-meta__row-<?php echo $name ?>"><?php echo $item; ?></div>
    <?php endforeach; ?>
    
    <?php if ($meta[ 'icons' ]): ?>
        <div class="post-meta__icons post-meta__row">
            <?php foreach ($meta[ 'icons' ] as $name => $item): ?>
                <span class="post-meta__icon post-meta__icon-<?php echo $name ?>"><?php echo $item ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($meta[ 'hidden_items' ]): ?>
        <div class="post-meta__hidden">
            <?php foreach ($meta[ 'hidden_items' ] as $name => $item): ?>
                <div class="post-meta__row post-meta__row-<?php echo $name ?>"><?php echo $item ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>