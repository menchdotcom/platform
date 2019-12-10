
<div class="container">

    <h1 class="play">PLAY. <span class="plat_content inline-block"></span></h1><!-- A Publishing Game/A Crypto Game./With Friends. -->
    <h1 class="read">READ. <span class="read_content inline-block"></span></h1><!-- Bright Ideas/Relevant Ideas/Interactively./On the web/On Messenger -->
    <h1 class="blog">BLOG. <span class="blog_content inline-block"></span></h1><!-- /// -->

    <script>

        $(document).ready(function () {

            var terms = {'Share Ideas.', 'Quote Ideas.', 'Link Ideas.', 'Collaboratively.'};

            new TypeIt('.blog_content', {
                speed: 50,
                startDelay: 900
            })
            .type(terms[0])
            .pause(500)
            .delete(terms[0].length)
            .pause(100)
            .type(terms[1])
            .pause(750)
            .options({speed: 100, deleteSpeed: 75})
            .delete(terms[1].length)
            .pause(750)
            .type(terms[2])
            .pause(1000)
            .delete(terms[2].length)
            .pause(200)
            .type(terms[3])
            .go();

        });

    </script>

    <?php

    //Go through all categories and see which ones have published courses:
    foreach($this->config->item('en_all_10869') /* Course Categories */ as $en_id => $m) {

        //Count total published courses here:
        $published_ins = $this->READ_model->ln_fetch(array(
            'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7359')) . ')' => null, //Link Statuses Public
            'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7355')) . ')' => null, //Intent Statuses Public
            'in_completion_method_entity_id IN (' . join(',', $this->config->item('en_ids_7582')) . ')' => null, //READ LOGIN REQUIRED
            'ln_type_entity_id' => 4601, //BLOG KEYWORDS
            'ln_parent_entity_id' => $en_id,
        ), array('in_child'), 0, 0, array('in_outcome' => 'ASC'));

        if(!count($published_ins)){
            continue;
        }

        //Show featured blogs in this category:
        echo '<div class="read-topic"><span class="icon-block">'.$m['m_icon'].'</span>'.$m['m_name'].'</div>';
        echo '<div class="list-group">';
        foreach($published_ins as $published_in){
            echo echo_in_read($published_in);
        }
        echo '</div>';

    }

    ?>

</div>