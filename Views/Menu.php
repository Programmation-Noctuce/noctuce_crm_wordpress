
            <h1>Noctuce CRM</h1>

            <div class="crm_menu">
                <div class="crm_left_menu">
                    <h3>Clients</h3>
                    <ul class="client-list">
<?php 
global $noctuce_CRM_ClientManager;
$list = $noctuce_CRM_ClientManager->getClientList();

foreach($list as $client) : ?>
                        <li id="client-id-<?= $client->getId() ?>"><?= $client->getPerson()->getName() ?></li>
<?php endforeach; ?>
                        <li id="new-client">+</li>
                    </ul>
                </div>

                <div class="crm_right_menu">
                </div>
            </div>
