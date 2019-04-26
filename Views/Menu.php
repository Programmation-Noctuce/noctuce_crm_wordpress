<?php 
  global $noctuce_CRM_PersonManager; ?>
            <h1>Noctuce CRM</h1>

            <div class="crm_menu">
                <div class="crm_left_menu">
                    <ul><?php $list = $noctuce_CRM_PersonManager->getList();
                    foreach($list as $person) : ?>
                        <li><?= $person->name ?></li>
                    <?php endforeach; ?></ul>
                </div>
                <div class="crm_right_menu">
                    
                </div>
            </div>
