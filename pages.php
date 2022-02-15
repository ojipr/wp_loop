<?php wp_head(); ?>
<div class="pagination">
   <div class="list-box">
       <ul>
       <?php
       $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;  //三項演算子は古ver
        //$paged = get_query_var( 'paged', 1 ); ページ送り番号を取得する関数、パラメータで戻り値を設定できる。

       $the_query = new WP_Query( array(
           'post_status' => 'publish',
           'post_type' => 'post', //ページの種類（例、page、post、カスタム投稿タイプ名）
           'paged' => $paged,
           'posts_per_page' => 2, //表示件数
           'orderby' => 'date', //並び順
           'order' => 'DESC' //昇順 or 降順
       ) );
       if ($the_query->have_posts()) :
           while ($the_query->have_posts()) : $the_query->the_post();
        ?>
               <?php
               /*　ここにループさせるコンテンツを入れます　*/
               the_title();
               echo '<br>';
               ?>
           <?php
           endwhile;
       else:
           echo '<div><p>当てはまるページはありません。</p></div>';
       endif;
       ?>
       </ul>
   </div>
   <!-------------------------ここまで------------------------->
 
   <div class="pnavi">
       <?php //ページリスト表示処理
       global $wp_rewrite; //リライトルールを管理するためのWordPressクラスで、これにより素敵なパーマリンクを実現することができます。
       $paginate_base = get_pagenum_link(1);
       if (strpos($paginate_base, '?') || !$wp_rewrite->using_permalinks()) { //using_permalinks() パーマリンク構造の使用をbool値で返す
           $paginate_format = '';
           $paginate_base = add_query_arg('paged','%#%');
       } else {
           $paginate_format = (substr($paginate_base,-1,1) == '/' ? '' : '/') .
           user_trailingslashit('page/%#%/','paged'); //「/」があるかないかをwpの設定に基づいて追加or削除
           $paginate_base .= '%_%'; //結合代入演算子
       }
       echo paginate_links(array( //アーカイブされた投稿ページのページ番号付きのリンクを取得
           'base' => $paginate_base,
           'format' => $paginate_format,
           'total' => $the_query->max_num_pages,
           'mid_size' => 1,
           'current' => ($paged ? $paged : 1),
           'prev_text' => '<< 前へ',
           'next_text' => '次へ >>',
       ));
       ?>
   </div>
</div>
<?php wp_footer(); ?>