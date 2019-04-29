
            <h1>Noctuce CRM</h1>

            <div class="crm_menu">
                <div class="crm_left_menu">
                    <h3>Clients</h3>
                    <ul class="contact-list">
<?php 
//global $noctuce_CRM_PersonManager;
global $noctuce_CRM_ContactManager;
$list = $noctuce_CRM_ContactManager->getContactList();

foreach($list as $contact) : ?>
                        <li id="contact-id-<?= $contact->getEmployee()->getPerson()->getId() ?>"><?= $contact->getEmployee()->getPerson()->getName() ?> - <?= $contact->getEmployee()->getRole()->getName() ?> - <?= $contact->getEmployee()->getEntreprise()->getPerson()->getName() ?></li>
<?php endforeach; ?>
                    </ul>
                </div>

                <div class="crm_right_menu" style='position:relative; padding: 5px;'>
                </div>
            </div>
