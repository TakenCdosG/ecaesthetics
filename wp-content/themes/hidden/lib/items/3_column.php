<div>
    <?php
    __afl_composer_edit_item_custom_style('', $_POST['itemtype'][$index], $data);
    ?>
</div>
<div id="afl-edit-composer-item-tabs" class="items columns">
    <ul>
        <li><a href="#afl-edit-item-tabs-content0">First</a></li>
        <li><a href="#afl-edit-item-tabs-content1">Second</a></li>
        <li><a href="#afl-edit-item-tabs-content2">Third</a></li>
    </ul>
    <div>
        <?php
        __afl_composer_edit_item_tab( 0, $_POST['itemtype'][$index], $data );
        __afl_composer_edit_item_tab( 1, $_POST['itemtype'][$index], $data );
        __afl_composer_edit_item_tab( 2, $_POST['itemtype'][$index], $data );
        ?>
    </div>
</div>
