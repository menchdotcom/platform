<?php
$session_en = en_auth();
$en_all_2738 = $this->config->item('en_all_2738'); //MENCH
$en_all_11035 = $this->config->item('en_all_11035'); //MENCH PLAYER NAVIGATION
$en_all_10591 = $this->config->item('en_all_10591'); //PLAYER PLAYS
?>
<div class="container">

    <div class="row">
        <?php
        $en_all_4527 = $this->config->item('en_all_4527'); //Platform Cache
        echo '<h1>'.$en_all_4527[11968]['m_name'].'</h1>';
        echo '<ul class="none-list">';
        foreach($this->config->item('en_all_11968') as $en_id => $m){
            echo '<li class="'.( in_array(11982 , $m['m_parents']) && !$session_en ? '' : ' learn_more hidden ' ).'"><span class="icon-block-sm">'.$m['m_icon'].'</span> <b class="montserrat">'.$m['m_name'].'</b> '.$m['m_desc'].'</li>';
        }
        echo '<li class="learn_more"><span class="icon-block-sm"><i class="fas fa-search-plus"></i></span> <a href="javascript:void(0);" onclick="$(\'.learn_more\').toggleClass(\'hidden\')" style="text-decoration: underline;">LEARN MORE</a></li>';
        echo '</ul>';
        ?>

        <div class="learn_more hidden">
        <h1 style="margin-top:34px;">HOW TO PLAY</h1>
        <ul class="none-list">
            <li><b class="montserrat play"><?= $en_all_2738[4536]['m_icon'] .' '. $en_all_2738[4536]['m_name'] ?></b> coins awarded for <a href="/play/signin" style="text-decoration: underline;">creating your account</a></li>
            <li><b class="montserrat read"><?= $en_all_2738[6205]['m_icon'] .' '. $en_all_2738[6205]['m_name'] ?></b> coins awarded for every word you read</li>
            <li><b class="montserrat blog"><?= $en_all_2738[4535]['m_icon'] .' '. $en_all_2738[4535]['m_name'] ?></b> coins awarded for every word you blog</li>
            <li><b class="montserrat read"><?= $en_all_2738[6205]['m_icon'] .' '.$en_all_2738[6205]['m_name'] ?></b> up to <?= config_var(11061) ?> words/month <b class="montserrat">FREE</b></li>
            <li><b class="montserrat read"><?= $en_all_2738[6205]['m_icon'] .' '.$en_all_2738[6205]['m_name'] ?></b> unlimited words for <b class="montserrat">$<?= config_var(11162) ?>/month</b></li>
            <li><b class="montserrat blog"><?= $en_all_2738[4535]['m_icon'] .' '. $en_all_2738[4535]['m_name'] ?></b> coins earn you monthly cash payouts</li>
        </ul>


        <h1 style="margin-top:34px;">TOP PLAYERS</h1>
        <?php
        echo '<table id="leaderboard" class="table table-sm table-striped">';
        echo '<thead>';
        echo '<tr style="padding:0;">';
        echo '<td style="width: 33%"><span style="padding-right: 2px;">'.$en_all_2738[4536]['m_icon'].'</span><b class="montserrat read" style="font-size: 1.2em;">'.$en_all_2738[4536]['m_name'].'</b></td>';
        echo '<td style="width: 33%"><span style="padding-right: 2px;">'.$en_all_2738[6205]['m_icon'].'</span><b class="montserrat read" style="font-size: 1.2em;">'.$en_all_2738[6205]['m_name'].'</b></td>';
        echo '<td style="width: 33%"><span style="padding-right: 2px;">'.$en_all_2738[4535]['m_icon'].'</span><b class="montserrat blog" style="font-size: 1.2em;">'.$en_all_2738[4535]['m_name'].'</b></td>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody><tr><td colspan="3"><span class="icon-block"><i class="far fa-yin-yang fa-spin"></i></span></td></tr></tbody>';
        echo '</table>';
        ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $.post("/play/leaderboard/", {}, function (data) {
                $('#leaderboard tbody').html(data);
                $('[data-toggle="tooltip"]').tooltip();
            });
        });
    </script>

</div>