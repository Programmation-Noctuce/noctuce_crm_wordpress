<?php
global $noctuce_CRM_ContactManager;
$contact = $noctuce_CRM_ContactManager->getFromId($_GET["contact_id"]); ?>
                    <input value='<?= $contact->getId() ?>' style='width:250px; text-align:right;' disabled />
                    <input value='<?= $contact->getEmployee()->getPerson()->getName() ?>' style='width:calc(100% - 257px);' />
                    <!-- -->
                    <input value='Role' style='width:250px; text-align:right;' disabled />
                    <input value='<?= $contact->getEmployee()->getRole()->getName() ?>' style='width:calc(100% - 292px);' />
                    <input type='button' value='+' style='width:30px;' />
                    <!-- -->
                    <input value='Entreprise' style='width:250px; text-align:right;' disabled />
                    <input value='<?= $contact->getEmployee()->getEntreprise()->getPerson()->getName() ?>' style='width:calc(100% - 292px);' />
                    <input type='button' value='+' style='width:30px;' />
                    <!-- -->
                    <input type='button' value='Update' style='position:absolute; right:3px; bottom:3px;' />