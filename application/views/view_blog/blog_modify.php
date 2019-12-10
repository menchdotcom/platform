
<?php
$en_all_6201 = $this->config->item('en_all_6201'); //Intent Table

$can_train = ( in_can_train($in['in_id'], $session_en['en_id']) );
?>

<style>
    .in_child_icon_<?= $in['in_id'] ?> { display:none; }
</style>


<script>
    //Include some cached entities:
    var in_loaded_id = <?= $in['in_id'] ?>;
</script>
<script src="/js/custom/in_notes.js?v=v<?= config_var(11060) ?>" type="text/javascript"></script>
<script src="/js/custom/in_modify.js?v=v<?= config_var(11060) ?>" type="text/javascript"></script>
<script src="/js/custom/in_train.js?v=v<?= config_var(11060) ?>" type="text/javascript"></script>

<?php

$en_all_4485 = $this->config->item('en_all_4485'); //Intent Notes
$play_focus_found = false; //Used to determine the first tab to be opened



echo '<div class="container" style="padding-bottom:54px;">';
echo '<div class="row">';
$col_num = 0;
foreach ($this->config->item('en_all_11021') as $en_id => $m){

    $col_num++;
    $tab_content = '';
    $default_active = false;
    
    echo '<div class="col-lg-12">';

    if($col_num==1){

        echo '<div>';
            echo '<div class="inline-block"><a href="" class="btn btn-blog" data-toggle="tooltip" title="Go Back" data-placement="right"><i class="fas fa-arrow-left"></i></a></div>';
            echo '<div class="inline-block" style="margin-left: 5px;">'.echo_dropdown(4737, $in['in_status_entity_id'], 'btn-blog').'</div>';
            echo '<div class="inline-block" style="margin-left: 5px;"><a href="/'.$in['in_id'].'" class="btn btn-read" data-toggle="tooltip" title="Read interactively" data-placement="right">PREVIEW <i class="fas fa-arrow-right"></i></a></div>';
        echo '</div>';

        echo '<div class="itemblog">';
        echo '<textarea onkeyup="show_save_button()" class="form-control" id="new_blog_title" placeholder="'.$en_all_6201[4736]['m_name'].'">'.$in['in_outcome'].'</textarea>';
        echo '<input type="hidden" id="current_blog_title" value="'.$in['in_outcome'].'" />';

        echo '<div id="blog_title_save" class="hidden">';
        echo '<a href="javascript:in_save_title();" data-toggle="tooltip" title="Shortcut: CTRL+ENTER" data-placement="bottom" class="btn btn-blog">SAVE</a>';
        echo '&nbsp;<span class="title_counter hidden">[<span id="charNameNum">0</span>/'.config_var(11071).']</span>';
        echo '&nbsp;<span class="title_update_status"></span>';
        echo '</div>';

        echo '</div>';

    } else {

        echo '<div class="center-right">';
            echo '<div class="inline-block">'.echo_dropdown(7585, $in['in_completion_method_entity_id'], 'btn-blog').'</div>';
        echo '</div>';

    }

    $show_tab_menu = count($this->config->item('en_ids_'.$en_id)) > 1;

    if($show_tab_menu){
        echo '<ul class="nav nav-tabs nav-tabs-sm '.superpower_active(10984).'">';
    }

    foreach ($this->config->item('en_all_'.$en_id) as $en_id2 => $m2){


        //Is this a caret menu?
        if(in_array(11040 , $m2['m_parents'])){
            echo echo_caret($en_id2, $m2, $in['in_id']);
            continue;
        }


        //Determine counter:
        $show_tab_names = in_array($en_id2, $this->config->item('en_ids_11031'));
        $counter = null; //Assume no counters
        $this_tab = '';


        //BLOG
        if($en_id2==11019){

            //BLOG TREE PREVIOUS
            $fetch_11019 = $this->READ_model->ln_fetch(array(
                'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7360')) . ')' => null, //Link Statuses Active
                'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
                'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4486')) . ')' => null, //Intent-to-Intent Links
                'ln_child_intent_id' => $in['in_id'],
            ), array('in_parent'), 0, 0, array('ln_up_order' => 'ASC'));

            $counter = count($fetch_11019);

            $this_tab .= '<div id="list-in-' . $in['in_id'] . '-1" class="list-group">';

            foreach ($fetch_11019 as $parent_in) {
                $this_tab .= echo_in($parent_in, true);
            }

            $this_tab .= '<div class="list-group-item itemblog '.superpower_active(10939).'">
                            <div class="form-group is-empty" style="margin: 0; padding: 0;">
                                <input type="text"
                                       class="form-control intentadder-level-2-parent form-control-thick algolia_search"
                                       intent-id="' . $in['in_id'] . '"
                                       id="addintent-c-' . $in['in_id'] . '-1"
                                       placeholder="ADD BLOG">
                            </div>
                           <div class="algolia_search_pad in_pad_top hidden"><b class="montserrat"><span class="icon-block"><i class="fas fa-search-plus yellow"></i></span>Search blogs or create a new one...</b></div>
                    </div>';

            $this_tab .= '</div>';


        } elseif($en_id2==11020){

            //BLOG TREE NEXT
            $fetch_11020 = $this->READ_model->ln_fetch(array(
                'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7360')) . ')' => null, //Link Statuses Active
                'in_status_entity_id IN (' . join(',', $this->config->item('en_ids_7356')) . ')' => null, //Intent Statuses Active
                'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_4486')) . ')' => null, //Intent-to-Intent Links
                'ln_parent_intent_id' => $in['in_id'],
            ), array('in_child'), 0, 0, array('ln_order' => 'ASC'));

            $counter = count($fetch_11020);
            $default_active = true;

            //List child intents:
            $this_tab .= '<div id="list-in-' . $in['in_id'] . '-0" class="list-group list-is-children">';
            foreach ($fetch_11020 as $child_in) {
                $this_tab .= echo_in($child_in, $in['in_id']);
            }

            //Add child intent:
            if(in_can_train($in['in_id'])){
                $this_tab .= '<div class="list-group-item itemblog '.superpower_active(10939).'">
                    <div class="form-group is-empty" style="margin: 0; padding: 0;">
                        <input type="text"
                               class="form-control intentadder-level-2-child form-control-thick algolia_search"
                               maxlength="' . config_var(11071) . '"
                               intent-id="' . $in['in_id'] . '"
                               id="addintent-c-' . $in['in_id'] . '-0"
                               placeholder="ADD BLOG">
                    </div>
                   <div class="algolia_search_pad in_pad_bottom hidden"><b class="montserrat"><span class="icon-block"><i class="fas fa-search-plus yellow"></i></span>Search blogs or create a new one...</b></div>
            </div>';
            } else {
                //Give option to request to join as Author:

            }
            $this_tab .= '</div>';


        } elseif(in_array($en_id2, array(7347,6146))){

            //READER READS & BOOKMARKS
            $item_counters = $this->READ_model->ln_fetch(array(
                'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7360')) . ')' => null, //Link Statuses Active
                'ln_type_entity_id IN (' . join(',', $this->config->item('en_ids_'.$en_id2)) . ')' => null,
                'ln_parent_intent_id' => $in['in_id'],
            ), array(), 1, 0, array(), 'COUNT(ln_id) as totals');

            $counter = $item_counters[0]['totals'];

            $this_tab .= '<div>Under development</div>';

        } elseif(in_array($en_id2, $this->config->item('en_ids_4485'))){

            //BLOG NOTE
            $blog_notes = $this->READ_model->ln_fetch(array(
                'ln_status_entity_id IN (' . join(',', $this->config->item('en_ids_7360')) . ')' => null, //Link Statuses Active
                'ln_type_entity_id' => $en_id2,
                'ln_child_intent_id' => $in['in_id'],
            ), array(), 0, 0, array('ln_order' => 'ASC'));

            $counter = count($blog_notes);

            if($en_id2==4231){
                $default_active = true; //BLOG MESSAGES
            }



            //Show no-Message notifications for each message type:
            $this_tab .= '<div id="in_notes_list_'.$en_id2.'" class="list-group">';

            foreach ($blog_notes as $in_note) {
                $this_tab .= echo_in_note($in_note);
            }

            //ADD NEW NOTE:
            $this_tab .= '<div class="list-group-item itemblog add_note_' . $en_id2 . '">';
            $this_tab .= '<form class="box box' . $en_id2 . '" method="post" enctype="multipart/form-data">'; //Used for dropping files



            $this_tab .= '<textarea onkeyup="in_new_note_count('.$en_id2.')" class="form-control msg note-textarea algolia_search new-note" note-type-id="' . $en_id2 . '" id="ln_content' . $en_id2 . '" placeholder=" + MESSAGE"></textarea>';



            $this_tab .= '<table class="table table-condensed hidden" id="notes_control_'.$en_id2.'"><tr>';

            //Save button:
            $this_tab .= '<td style="width:85px; padding: 10px 0 0 0;"><a href="javascript:in_note_add('.$en_id2.');" data-toggle="tooltip" title="Shortcut: CTRL+ENTER" data-placement="right" class="btn btn-blog save_note_'.$en_id2.'">ADD</a></td>';

            //File counter:
            $this_tab .= '<td class="remove_loading" class="remove_loading" style="padding: 10px 0 0 0; font-size: 0.85em;"><span id="blogNoteNewCount' . $en_id2 . '" class="hidden"><span id="charNum' . $en_id2 . '">0</span>/' . config_var(11073).'</span></td>';

            //First Name:
            $this_tab .= '<td class="remove_loading '.superpower_active(10983).'" style="width:42px; padding: 10px 0 0 0;"><a href="javascript:in_note_insert_string('.$en_id2.', \'/firstname \');" data-toggle="tooltip" title="Mention readers first name" data-placement="top"><span class="icon-block en-icon"><i class="far fa-fingerprint"></i></span></a></td>';

            //Reference Player
            $this_tab .= '<td class="remove_loading '.superpower_active(10983).'" style="width:42px; padding: 10px 0 0 0;"><a href="javascript:in_note_insert_string('.$en_id2.', \'@\');" data-toggle="tooltip" title="Reference PLAYER" data-placement="top"><span class="icon-block en-icon"><i class="far fa-at"></i></span></a></td>';

            //Upload File:
            $this_tab .= '<td class="remove_loading" style="width:36px; padding: 10px 0 0 0;">';
            $this_tab .= '<input class="inputfile hidden" type="file" name="file" id="file" />';
            $this_tab .= '<label class="file_label_'.$en_id2.'" for="file" data-toggle="tooltip" title="Upload files up to ' . config_var(11063) . 'MB" data-placement="top"><span class="icon-block en-icon"><i class="far fa-paperclip"></i></span></label>';
            $this_tab .= '</td>';

            //TODO ADD MORE OPTIONS HERE?
            //LIST PLAYERS
            //DRIP PLAYERS

            $this_tab .= '</tr></table>';


            //Response result:
            $this_tab .= '<div class="note_error_'.$en_id2.'"></div>';


            $this_tab .= '</form>';
            $this_tab .= '</div>';

            $this_tab .= '</div>';
        }


        $superpower_actives = array_intersect($this->config->item('en_ids_10957'), $m2['m_parents']);

        if($show_tab_menu){
            echo '<li class="nav-item '.( count($superpower_actives) ? superpower_active(end($superpower_actives)) : '' ).'"><a class="nav-link tab-nav-'.$en_id.' tab-head-'.$en_id2.' '.( $default_active ? ' active ' : '' ).'" href="javascript:void(0);" onclick="loadtab('.$en_id.','.$en_id2.')" data-toggle="tooltip" data-placement="top" title="'.( $show_tab_names ? '' : $m2['m_name'] ).'">'.$m2['m_icon'].( is_null($counter) ? '' : ' <span class="counter-'.$en_id2.'">'.echo_number($counter).'</span>' ).( $show_tab_names ? ' '.$m2['m_name'] : '' ).'</a></li>';
        }

        $tab_content .= '<div class="tab-content tab-group-'.$en_id.' tab-data-'.$en_id2.( $default_active ? '' : ' hidden ' ).'">';
        $tab_content .= $this_tab;
        $tab_content .= '</div>';

        $default_active = false;

    }

    if($show_tab_menu){
        echo '</ul>';
    }

    echo $tab_content;

    echo '</div>';

}

echo '</div>';
echo '</div>';

?>