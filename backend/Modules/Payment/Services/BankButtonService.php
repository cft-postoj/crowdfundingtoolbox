<?php

namespace Modules\Payment\Services;


use Modules\Payment\Entities\BankButton;
use Modules\Payment\Repositories\BankButtonRepository;

class BankButtonService
{

    private $bankButtonRepository;

    public function __construct(BankButtonRepository $bankButtonRepository)
    {
        $this->bankButtonRepository = $bankButtonRepository;
    }

    public function getBankButtons()
    {
        return $this->bankButtonRepository->getBankButtons();
    }

    public function updateBankButtons($newBankButtons)
    {
        $oldBankButtons = $this->getBankButtons();
        // delete missing bankButtons
        foreach ($oldBankButtons as $oldButton) {
            $oldButtonIsRemoved = true;
            foreach ($newBankButtons as $newBankButton) {
                if ($newBankButton['id'] == $oldButton['id'] && $newBankButton['id'] != 0) {
                    $oldButtonIsRemoved = false;
                    //update previuosly created bank buttons
                    $newBankButtonInstance = new BankButton(
                        ['order' => $newBankButton['order'],
                            'redirect_link' => $newBankButton['redirect_link']]);
                    $newBankButtonInstance['id'] = $newBankButton['id'];
                    if ($newBankButton['image']) {
                        $newBankButtonInstance['image_id'] = $newBankButton['image']['id'];
                    }
                    $this->updateBankButton($newBankButtonInstance);
                }
            }
            if ($oldButtonIsRemoved) {
                $this->deleteBankButton($oldButton['id']);
            }
        }

        foreach ($newBankButtons as $newBankButton) {
            if ($newBankButton['id'] == 0) {
                $newBankButtonInstance = new BankButton(
                    ['order' => $newBankButton['order'],
                        'redirect_link' => $newBankButton['redirect_link']]);
                if ($newBankButton['image']) {
                    $newBankButtonInstance['image_id'] = $newBankButton['image']['id'];
                }
                $this->bankButtonRepository->create($newBankButtonInstance);
            }
        }

        return $this->bankButtonRepository->getBankButtons();
    }


    private function deleteBankButton($id)
    {
        return $this->bankButtonRepository->delete($id);
    }

    private function updateBankButton($newButton)
    {
        return $this->bankButtonRepository->update($newButton);
    }
}