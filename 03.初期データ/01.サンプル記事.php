<?php
// WP-CLI経由でのみ実行する。
if (!defined("WP_CLI") || !WP_CLI) {
    http_response_code(403);
    exit;
}
$topics = [
'朝の散歩で見つけた小さな発見','自宅で楽しむコーヒー時間','読みかけの本と過ごす休日','机まわりを整理してみた','季節の花を飾る楽しみ',
'近所の公園を歩く午後','手帳に書き留めたいこと','雨の日の過ごし方','簡単な朝ごはんの工夫','週末の小さな買い物',
'お気に入りの音楽を聴く時間','部屋の模様替えの記録','初めてのハーブ栽培','写真で残す日常の風景','夕方の空を眺めて',
'散歩に持っていくもの','使いやすい収納を考える','休日に作るスープ','小さな目標を続けるコツ','旅の計画を立てる楽しみ',
'窓辺で過ごす静かな時間','文房具を選ぶ楽しさ','気分転換のストレッチ','いつもの道を変えてみる','旬の食材を楽しむ食卓',
'日記を振り返って気づくこと','お気に入りのマグカップ','夜の読書時間をつくる','一週間を振り返るメモ','新しいことを始める日'
];
$created = 0;
$skipped = 0;
foreach ($topics as $index => $topic) {
    $number = $index + 1;
    $slug = 'sample-post-' . $number;
    if (get_page_by_path($slug, OBJECT, 'post')) {
        ++$skipped;
        WP_CLI::log('スキップ: ' . $slug);
        continue;
    }
    $content = '<!-- wp:paragraph --><p>' . esc_html($topic) . 'についてのサンプル記事です。記事一覧や詳細ページ、検索機能などの表示を確認するために用意しました。</p><!-- /wp:paragraph -->'
        . '<!-- wp:heading --><h2 class="wp-block-heading">今日の記録</h2><!-- /wp:heading -->'
        . '<!-- wp:paragraph --><p>慌ただしい日々のなかでも、少しだけ立ち止まると普段とは違う発見があります。今回は身近な出来事をきっかけに、自分のペースで楽しめる時間をつくってみました。</p><!-- /wp:paragraph -->'
        . '<!-- wp:paragraph --><p>準備に時間をかけすぎず、まずはできるところから試してみるのが今回のテーマです。実際にやってみると、ちょっとした工夫で過ごしやすさが変わることに気づきました。</p><!-- /wp:paragraph -->'
        . '<!-- wp:heading --><h2 class="wp-block-heading">次に試したいこと</h2><!-- /wp:heading -->'
        . '<!-- wp:paragraph --><p>次回は時間帯や場所を変えて、今回との違いを比べてみたいと思います。この記事はNo.' . $number . 'の検証用データです。</p><!-- /wp:paragraph -->';
    $id = wp_insert_post([
        'post_type' => 'post', 'post_status' => 'publish', 'post_author' => 1,
        'post_title' => 'No.' . $number . ' ' . $topic,
        'post_name' => $slug, 'post_content' => $content,
        'post_excerpt' => $topic . 'をテーマにした、No.' . $number . 'のサンプル記事です。',
    ], true);
    if (is_wp_error($id)) WP_CLI::error($id->get_error_message());
    ++$created;
    WP_CLI::log($number . ': ID=' . $id);
}
WP_CLI::success('作成: ' . $created . '件 / 既存のためスキップ: ' . $skipped . '件');
