<?php
    // Backwards compatibility for older Grocery CRUD versions
    $unset_clone = isset($unset_clone) ? $unset_clone : true;

    //Start counting the buttons that we have:
    $buttons_counter = 0;

    if (!$unset_edit) {
        $buttons_counter++;
    }

    if (!$unset_read) {
        $buttons_counter++;
    }

    if (!$unset_delete) {
        $buttons_counter++;
    }

    if (!$unset_clone) {
        $buttons_counter++;
    }

    if (!empty($list[0]) && !empty($list[0]->action_urls)) {
        $buttons_counter = $buttons_counter +  count($list[0]->action_urls);
    }

    $show_more_button  = $buttons_counter > 2 ? true : false;

    //The more lang string exists only in version 1.5.2 or higher
    $more_string =
        preg_match('/1\.(5\.[2-9]|[6-9]\.[0-9])/', Grocery_CRUD::VERSION)
            ? $this->l('list_more') : "More";

    $clone_string = preg_match('/1\.(6\.[1-9]|[7-9]\.[0-9])/', Grocery_CRUD::VERSION)
        ? $this->l('list_clone') : 'Clone';

?>

<?php foreach($list as $num_row => $row){ ?>
    <tr>
        <?php foreach($columns as $column){?>
            <td style="font-size:12px;">
				<?php if( strpos( $column->field_name, 'date' ) !== false || strpos( $column->field_name, 'time' ) !== false)
				{?>
				<center>
				<?php } ?>
                <?php echo $row->{$column->field_name} != '' ? $row->{$column->field_name} : '&nbsp;' ; ?>
				<?php if( strpos( $column->field_name, 'date' ) !== false || strpos( $column->field_name, 'time' ) !== false)
				{?>
				</center>
				<?php } ?>
            </td>
        <?php }?>
        <td style="font-size:12px;" <?php if ($unset_delete) { ?> style="border-right: none;"<?php } ?>
            <?php if ($buttons_counter === 0) {?>class="hidden"<?php }?>>
            <?php if (!$unset_delete) { ?>
                <input type="checkbox" class="select-row" data-id="<?php echo $row->primary_key_value; ?>" />
            <?php } ?>
        </td>
        <td style="font-size:12px;" <?php if ($unset_delete) { ?> style="border-left: 0;"<?php } ?>
            <?php if ($buttons_counter === 0) {?>class="hidden"<?php }?>">
                <div class="only-desktops"  style="white-space: nowrap;float:right">
                    <?php if(!$unset_edit){?>
                        <a class="btn btn-success btn-xs" href="<?php echo $row->edit_url?>"><i class="fa fa-pencil"></i>&nbsp;<?php echo $this->l('list_edit'); ?></a>
                    <?php } ?>
                    <?php if (!empty($row->action_urls) || !$unset_read || !$unset_delete || !$unset_clone) { ?>

                        <?php if ($show_more_button) { ?>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle gc-bootstrap-dropdown">
                                    <?php echo $more_string; ?>
                                    <span class="caret"></span>
                                </button>

                                <ul class="dropdown-menu">
                                    <?php
                                    if(!empty($row->action_urls)){
                                        foreach($row->action_urls as $action_unique_id => $action_url){
                                            $action = $actions[$action_unique_id];
                                            ?>
                                            <li>
                                                <a href="<?php echo $action_url; ?>">
                                                    <i class="fa <?php echo $action->css_class; ?>"></i> <?php echo $action->label?>
                                                </a>
                                            </li>
                                        <?php }
                                    }
                                    ?>
                                    <?php if (!$unset_read) { ?>
                                        <li>
                                            <a href="<?php echo $row->read_url?>">
                                                <i class="fa fa-eye"></i> <?php echo $this->l('list_view')?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (!$unset_clone) { ?>
                                        <li>
                                            <a href="<?php echo $row->clone_url?>">
                                                <i class="fa fa-copy"></i> <?php echo $clone_string; ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if (!$unset_delete) { ?>
                                        <li>
                                            <a data-target="<?php echo $row->delete_url?>" href="javascript:void(0)" title="<?php echo $this->l('list_delete')?>" class="delete-row">
                                                <i class="fa fa-trash-o text-danger"></i>
                                                <span class="text-danger"><?php echo $this->l('list_delete')?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php } else {
                                if(!empty($row->action_urls)){
                                    foreach($row->action_urls as $action_unique_id => $action_url){
                                        $action = $actions[$action_unique_id];
                                        ?>
                                        <a href="<?php echo $action_url; ?>" class="btn btn-default btn-xs">
                                            <i class="fa <?php echo $action->css_class; ?>"></i> <?php echo $action->label?>
                                        </a>
                                    <?php }
                                }

                                if (!$unset_read) { ?>
                                    <a class="btn btn-default btn-xs" href="<?php echo $row->read_url?>">
                                        <i class="fa fa-eye"></i> <?php echo $this->l('list_view')?>
                                    </a>
                                <?php }

                                if (!$unset_clone) { ?>
                                    <a class="btn btn-default btn-xs" href="<?php echo $row->clone_url?>">
                                        <i class="fa fa-copy"></i> Clone
                                    </a>
                                <?php }

                                if (!$unset_delete) { ?>
                                    <a data-target="<?php echo $row->delete_url?>" href="javascript:void(0)" title="<?php echo $this->l('list_delete')?>" class="delete-row btn btn-default btn-xs">
                                        <i class="fa fa-trash-o text-danger"></i>
                                        <span class="text-danger"><?php echo $this->l('list_delete')?></span>
                                    </a>
                                <?php } ?>
                            <?php } ?>

                    <?php } ?>
                </div>
                <div class="only-mobiles">
                    <?php if ($buttons_counter > 0) { ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs gc-bootstrap-dropdown dropdown-toggle">
                            <?php echo $this->l('list_actions'); ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <?php if (!$unset_edit) { ?>
                            <li>
                                <a href="<?php echo $row->edit_url?>">
                                    <i class="fa fa-pencil"></i>&nbsp;<?php echo $this->l('list_edit'); ?>
                                </a>
                            </li>
                            <?php } ?>
                            <?php
                            if(!empty($row->action_urls)){
                                foreach($row->action_urls as $action_unique_id => $action_url){
                                    $action = $actions[$action_unique_id];
                                    ?>
                                    <li>
                                        <a href="<?php echo $action_url; ?>">
                                            <i class="fa <?php echo $action->css_class; ?>"></i> <?php echo $action->label?>
                                        </a>
                                    </li>
                                <?php }
                            }
                            ?>
                            <?php if (!$unset_read) { ?>
                                <li>
                                    <a href="<?php echo $row->read_url?>"><i class="fa fa-eye"></i> <?php echo $this->l('list_view')?></a>
                                </li>
                            <?php }
                                if (!$unset_clone) { ?>
                                    <li>
                                        <a href="<?php echo $row->clone_url?>">
                                            <i class="fa fa-copy"></i> Clone
                                        </a>
                                    </li>
                            <?php }
                             if (!$unset_delete) { ?>
                                <li>
                                    <a data-target="<?php echo $row->delete_url?>" href="javascript:void(0)" title="<?php echo $this->l('list_delete')?>" class="delete-row">
                                        <i class="fa fa-trash-o text-danger"></i> <span class="text-danger"><?php echo $this->l('list_delete')?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
        </td>
    </tr>
<?php } ?>