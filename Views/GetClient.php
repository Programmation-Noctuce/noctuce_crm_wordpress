<?php  ?>
                    <input value='<?= $client->getId() ?>' style='width:120px; text-align:right;' disabled />
                    <input value='Name' style='width:125px; text-align:right;' disabled />
                    <input value='<?= $client->getPerson()->getName() ?>' style='width:calc(100% - 292px);' disabled />
                    <input type='button' value='¤' style='width:30px;' />
                    <!-- -->
<?php 
if ($client->getPerson()->getPersonType()->getName() == "Entreprise") : ?>
                    <ul>
<?php
global $noctuce_CRM_EmployeeManager;

$employeeList = $noctuce_CRM_EmployeeManager->getEmployeeList();

foreach($employeeList as $employee) :
    if($employee->getEntreprise()->getId() == $client->getPerson()->getId()) : ?>
                        <li><?= $employee->getIndividual()->getName() ?> - <?= $employee->getRole()->getName() ?></li>
<?php endif; ?>
<?php endforeach; ?>
                    </ul>
<?php endif; ?>
                    <!-- -->
                    <input type='button' value='Update' style='display: none; position:absolute; right:3px; bottom:3px;' />