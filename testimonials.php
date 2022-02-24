<?php

/**

 * Section Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


$id = 'banner-' . $block['id'];


$styles = get_field('styles');
$select_data_provider = get_field('select_data_provider');
$load_more = get_field('load_more');

if ($select_data_provider === 'Comments') {

    $args = [
        'number' => get_field('comments_total')
    ];

    $comments_query = new WP_Comment_Query;
    $comments = $comments_query->query($args);
}

if ($select_data_provider === 'Custom') {
    $comments = get_field('testimonials');
}

$rowClass = 'row';
if ($styles == '3 Rows') {
    $rowClass = 'row-3';
}

if ($styles == '4 Rows') {
    $rowClass = 'row-4';
}

$author = get_field('author_group');
$position = get_field('position_group');
$textg = get_field('text_group');
$load_more_style = get_field('read_more_button');
?>

<style>
    .meta-area h2 {
        color: <?= $author['color']; ?> !important;
        font-size: <?= $author['font_size']; ?> !important;
    }

    div.meta-area>div.titlearea>span {
        color: <?= $position['color']; ?> !important;
        font-size: <?= $position['font_size']; ?> !important;
    }

    .testimonial-card p {
        color: <?= $textg['color']; ?> !important;
        font-size: <?= $textg['font_size']; ?> !important;
    }

    .load-more-btn {
        color: <?= $load_more_style['color_text']; ?> !important;
        font-size: <?= $load_more_style['font_size']; ?> !important;
        border-radius: <?= $load_more_style['border_radius']; ?>px !important;
        border-color: <?= $load_more_style['border_color']; ?> !important;
        background: <?= $load_more_style['background_color']; ?> !important;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">
    <div class="<?php echo $rowClass  ?>">
        <?php if ($select_data_provider === 'Comments') : ?>

            <?php if ($styles == '2 Rows') : ?>
                <?php foreach ($comments as $key => $comment) : ?>
                    <?php
                    $rating = get_field('rating', $comment);
                    ?>
                    <div class="testimonial-card" data-card="card-<?= $key + 1 ?>">
                        <?php if (get_field('avatar')) : ?>
                            <img src="<?= get_field('avatar', $comment) ?>" alt="">
                        <?php endif; ?>
                        <div class="meta-area">
                            <div class="titlearea">

                                <?php if (get_field('author')) : ?>
                                    <h2><?= $comment->comment_author ?></h2>
                                <?php endif; ?>
                                <?php if (get_field('position')) : ?>
                                    <span><?= get_field('position', $comment) ?></span>
                                <?php endif; ?>

                            </div>
                            <?php if (get_field('rating')) : ?>

                                <div class="star-area">
                                    <?php foreach (range(1, $rating) as $key => $rat) : ?>
                                        <?php if ($rating == 5) : ?>
                                            <span class="fa fa-star checked"></span>
                                        <?php endif; ?>

                                        <?php if ($rating == 4) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 3) : ?>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($rating == 3) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 2) : ?>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($rating == 2) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 1) : ?>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($rating == 1) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 0) : ?>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php if (get_field('text')) : ?>

                            <p>
                                <?php echo substr($comment->comment_content, 0, get_field('text_limit')) ?>
                                <?php if (strlen($comment->comment_content) >= get_field('text_limit')) : ?>
                                    <span class="dots">...</span>
                                    <span class="more" id="more"><?php echo substr($comment->comment_content, get_field('text_limit'), 1000) ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (strlen($comment->comment_content) >= get_field('text_limit')) : ?>

                            <div class="read-more" id="myreadMoreBtn" onclick="readMore('card-<?= $key + 1 ?>')">
                                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                </svg>
                                Read More
                            </div>

                            <div class=" read-less" id="myreadMoreBtn" onclick="readMore('card-<?= $key + 1 ?>')" style="display: none">
                                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                </svg>
                                Read less
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    </p>
                    </div>
                <?php endforeach; ?>

                <div class="load-more-area">
                    <a href="<?php echo $load_more['url'] ?>">
                        <div class="load-more-btn"><?php echo $load_more['text'] ?></div>
                    </a>
                </div>

            <?php endif; ?>

            <?php if ($styles == '3 Rows') : ?>
                <?php foreach ($comments as $key => $comment) : ?>
                    <?php
                    $rating = get_field('rating', $comment);
                    ?>
                    <div class="testimonial-card card-3" data-card="card-<?= $key + 1 ?>">
                        <?php if (get_field('avatar')) : ?>
                            <img src="<?= get_field('avatar', $comment) ?>" alt="">
                        <?php endif; ?>
                        <div class="meta-area">
                            <div class="titlearea">

                                <?php if (get_field('author')) : ?>
                                    <h2><?= $comment->comment_author ?></h2>
                                <?php endif; ?>
                                <?php if (get_field('position')) : ?>
                                    <span><?= get_field('position', $comment) ?></span>
                                <?php endif; ?>

                            </div>
                            <?php if (get_field('rating')) : ?>

                                <div class="star-area">
                                    <?php foreach (range(1, $rating) as $key => $rat) : ?>
                                        <?php if ($rating == 5) : ?>
                                            <span class="fa fa-star checked"></span>
                                        <?php endif; ?>

                                        <?php if ($rating == 4) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 3) : ?>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($rating == 3) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 2) : ?>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($rating == 2) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 1) : ?>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($rating == 1) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 0) : ?>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php if (get_field('text')) : ?>

                            <p>
                                <?php echo substr($comment->comment_content, 0, get_field('text_limit')) ?>
                                <?php if (strlen($comment->comment_content) >= get_field('text_limit')) : ?>
                                    <span class="dots">...</span>
                                    <span class="more" id="more"><?php echo substr($comment->comment_content, get_field('text_limit'), 1000) ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (strlen($comment->comment_content) >= get_field('text_limit')) : ?>

                            <div class="read-more" id="myreadMoreBtn" onclick="readMore('card-<?= $key + 1 ?>')">
                                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                </svg>
                                Read More
                            </div>

                            <div class=" read-less" id="myreadMoreBtn" onclick="readMore('card-<?= $key + 1 ?>')" style="display: none">
                                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                </svg>
                                Read less
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    </p>
                    </div>


                <?php endforeach; ?>


                <div class="load-more-area">
                    <a href="<?php echo $load_more['url'] ?>">
                        <div class="load-more-btn"><?php echo $load_more['text'] ?></div>
                    </a>
                </div>

            <?php endif; ?>

            <?php if ($styles == '4 Rows') : ?>
                <?php foreach ($comments as $key => $comment) : ?>
                    <?php
                    $rating = get_field('rating', $comment);
                    ?>
                    <div class="testimonial-card card-4" data-card="card-<?= $key + 1 ?>">
                        <?php if (get_field('avatar')) : ?>
                            <img src="<?= get_field('avatar', $comment) ?>" alt="">
                        <?php endif; ?>
                        <div class="meta-area">
                            <div class="titlearea">

                                <?php if (get_field('author')) : ?>
                                    <h2><?= $comment->comment_author ?></h2>
                                <?php endif; ?>
                                <?php if (get_field('position')) : ?>
                                    <span><?= get_field('position', $comment) ?></span>
                                <?php endif; ?>

                            </div>
                            <?php if (get_field('rating')) : ?>

                                <div class="star-area">
                                    <?php foreach (range(1, $rating) as $key => $rat) : ?>
                                        <?php if ($rating == 5) : ?>
                                            <span class="fa fa-star checked"></span>
                                        <?php endif; ?>

                                        <?php if ($rating == 4) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 3) : ?>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($rating == 3) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 2) : ?>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($rating == 2) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 1) : ?>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($rating == 1) : ?>
                                            <span class="fa fa-star checked"></span>
                                            <?php if ($key === 0) : ?>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                                <span class="fa fa-star "></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php if (get_field('text')) : ?>

                            <p>
                                <?php echo substr($comment->comment_content, 0, get_field('text_limit')) ?>
                                <?php if (strlen($comment->comment_content) >= get_field('text_limit')) : ?>
                                    <span class="dots">...</span>
                                    <span class="more" id="more"><?php echo substr($comment->comment_content, get_field('text_limit'), 1000) ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (strlen($comment->comment_content) >= get_field('text_limit')) : ?>

                            <div class="read-more" id="myreadMoreBtn" onclick="readMore('card-<?= $key + 1 ?>')">
                                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                </svg>
                                Read More
                            </div>

                            <div class=" read-less" id="myreadMoreBtn" onclick="readMore('card-<?= $key + 1 ?>')" style="display: none">
                                <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                </svg>
                                Read less
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    </p>
                    </div>

                <?php endforeach; ?>

                <div class="load-more-area">
                    <a href="<?php echo $load_more['url'] ?>">
                        <div class="load-more-btn"><?php echo $load_more['text'] ?></div>
                    </a>
                </div>

            <?php endif; ?>
        <?php else : ?>
            <?php if ($styles == '2 Rows') : ?>
                <?php $i = 1; ?>
                <?php foreach ($comments as $key => $comment) : ?>
                    <?php if ($key <  get_field('comments_total')) : ?>
                        <div class="testimonial-card" data-card="card-<?= $i + 1 ?>">
                            <?php if (get_field('avatar')) : ?>
                                <img src="<?= $comment['avatar'] ?>" alt="">
                            <?php endif; ?>
                            <div class="meta-area">
                                <div class="titlearea">

                                    <?php if (get_field('author')) : ?>
                                        <h2><?= $comment['name'] ?></h2>
                                    <?php endif; ?>
                                    <?php if (get_field('position')) : ?>
                                        <span><?= $comment['position'] ?></span>
                                    <?php endif; ?>

                                </div>
                                <?php if (get_field('rating')) : ?>

                                    <div class="star-area">
                                        <?php foreach (range(1, $comment['rating']) as $key => $rat) : ?>
                                            <?php if ($comment['rating'] == 5) : ?>
                                                <span class="fa fa-star checked"></span>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 4) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 3) : ?>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 3) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 2) : ?>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 2) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 1) : ?>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 1) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 0) : ?>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif ?>
                            </div>
                            <?php if (get_field('text')) : ?>

                                <p>
                                    <?php echo substr($comment['text'], 0, get_field('text_limit')) ?>
                                    <?php if (strlen($comment['text']) >= get_field('text_limit')) : ?>
                                        <span class="dots">...</span>
                                        <span class="more" id="more"><?php echo substr($comment['text'], get_field('text_limit'), 1000) ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (strlen($comment['text']) >= get_field('text_limit')) : ?>

                                <div class="read-more" id="myreadMoreBtn" onclick="readMore('card-<?= $i + 1 ?>')">
                                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                    </svg>
                                    Read More
                                </div>

                                <div class=" read-less" id="myreadMoreBtn" onclick="readMore('card-<?= $i + 1 ?>')" style="display: none">
                                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                    </svg>
                                    Read less
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        </p>
                        </div>
                    <?php endif; ?>
                    <?php $i++; ?>

                <?php endforeach; ?>

                <div class="load-more-area">
                    <a href="<?php echo $load_more['url'] ?>">
                        <div class="load-more-btn"><?php echo $load_more['text'] ?></div>
                    </a>
                </div>

            <?php endif; ?>

            <?php if ($styles == '3 Rows') : ?>
                <?php $j = 1; ?>
                <?php foreach ($comments as $key => $comment) : ?>
                    <?php if ($key <  get_field('comments_total')) : ?>
                        <div class="testimonial-card card-3" data-card="card-<?= $j + 1 ?>">
                            <?php if (get_field('avatar')) : ?>
                                <img src="<?= $comment['avatar'] ?>" alt="">
                            <?php endif; ?>
                            <div class="meta-area">
                                <div class="titlearea">

                                    <?php if (get_field('author')) : ?>
                                        <h2><?= $comment['name'] ?></h2>
                                    <?php endif; ?>
                                    <?php if (get_field('position')) : ?>
                                        <span><?= $comment['position'] ?></span>
                                    <?php endif; ?>

                                </div>
                                <?php if (get_field('rating')) : ?>

                                    <div class="star-area">
                                        <?php foreach (range(1, $comment['rating']) as $key => $rat) : ?>
                                            <?php if ($comment['rating'] == 5) : ?>
                                                <span class="fa fa-star checked"></span>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 4) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 3) : ?>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 3) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 2) : ?>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 2) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 1) : ?>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 1) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 0) : ?>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif ?>
                            </div>
                            <?php if (get_field('text')) : ?>

                                <p>
                                    <?php echo substr($comment['text'], 0, get_field('text_limit')) ?>
                                    <?php if (strlen($comment['text']) >= get_field('text_limit')) : ?>
                                        <span class="dots">...</span>
                                        <span class="more" id="more"><?php echo substr($comment['text'], get_field('text_limit'), 1000) ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (strlen($comment['text']) >= get_field('text_limit')) : ?>

                                <div class="read-more" id="myreadMoreBtn" onclick="readMore('card-<?= $j + 1 ?>')">
                                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                    </svg>
                                    Read More
                                </div>

                                <div class=" read-less" id="myreadMoreBtn" onclick="readMore('card-<?= $j + 1 ?>')" style="display: none">
                                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                    </svg>
                                    Read less
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        </p>
                        </div>
                    <?php endif; ?>

                    <?php $j++; ?>
                <?php endforeach; ?>


                <div class="load-more-area">
                    <a href="<?php echo $load_more['url'] ?>">
                        <div class="load-more-btn"><?php echo $load_more['text'] ?></div>
                    </a>
                </div>

            <?php endif; ?>

            <?php if ($styles == '4 Rows') : ?>
                <?php $i = 1; ?>
                <?php foreach ($comments as $key => $comment) : ?>
                    <?php if ($key <  get_field('comments_total')) : ?>
                        <div class="testimonial-card card-4" data-card="card-<?= $i + 1 ?>">
                            <?php if (get_field('avatar')) : ?>
                                <img src="<?= $comment['avatar'] ?>" alt="">
                            <?php endif; ?>
                            <div class="meta-area">
                                <div class="titlearea">

                                    <?php if (get_field('author')) : ?>
                                        <h2><?= $comment['name'] ?></h2>
                                    <?php endif; ?>
                                    <?php if (get_field('position')) : ?>
                                        <span><?= $comment['position'] ?></span>
                                    <?php endif; ?>

                                </div>
                                <?php if (get_field('rating')) : ?>

                                    <div class="star-area">
                                        <?php foreach (range(1, $comment['rating']) as $key => $rat) : ?>
                                            <?php if ($comment['rating'] == 5) : ?>
                                                <span class="fa fa-star checked"></span>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 4) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 3) : ?>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 3) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 2) : ?>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 2) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 1) : ?>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($comment['rating'] == 1) : ?>
                                                <span class="fa fa-star checked"></span>
                                                <?php if ($key === 0) : ?>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                    <span class="fa fa-star "></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif ?>
                            </div>
                            <?php if (get_field('text')) : ?>

                                <p>
                                    <?php echo substr($comment['text'], 0, get_field('text_limit')) ?>
                                    <?php if (strlen($comment['text']) >= get_field('text_limit')) : ?>
                                        <span class="dots">...</span>
                                        <span class="more" id="more"><?php echo substr($comment['text'], get_field('text_limit'), 1000) ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (strlen($comment['text']) >= get_field('text_limit')) : ?>

                                <div class="read-more" id="myreadMoreBtn" onclick="readMore('card-<?= $i + 1 ?>')">
                                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                    </svg>
                                    Read More
                                </div>

                                <div class=" read-less" id="myreadMoreBtn" onclick="readMore('card-<?= $i + 1 ?>')" style="display: none">
                                    <svg width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.60156 4.77344C3.8125 4.98438 4.16406 4.98438 4.375 4.77344L7.5625 1.58594C7.79688 1.35156 7.79688 1 7.5625 0.789062L7.04688 0.25C6.8125 0.0390625 6.46094 0.0390625 6.25 0.25L3.97656 2.52344L1.72656 0.25C1.51562 0.0390625 1.16406 0.0390625 0.929688 0.25L0.414062 0.789062C0.179688 1 0.179688 1.35156 0.414062 1.58594L3.60156 4.77344Z" fill="black" />
                                    </svg>
                                    Read less
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        </p>
                        </div>
                    <?php endif; ?>
                    <?php $i++; ?>
                <?php endforeach; ?>

                <div class="load-more-area">
                    <a href="<?php echo $load_more['url'] ?>">
                        <div class="load-more-btn"><?php echo $load_more['text'] ?></div>
                    </a>
                </div>

            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>