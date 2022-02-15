<?php
    $args = array(
        'posts_per_page' => 9 //取得する記事の数
    );
    $posts = get_posts($args);
    foreach ($posts as $post):
    setup_postdata($post);
?>

<div class="archive_container">
    
</div>

<?php
    endforeach; // ループの終了
    wp_reset_postdata(); // 直前のクエリを復元する
?>