<?php

namespace App\Http\Livewire;

use App\Models\Reason;
use Livewire\Component;

class ReasonForm extends Component
{
    public $reason;
    public $reasonID;

    protected $listeners = ['getReasonID', 'forcedClosedModal'];

    public function getReasonID($reasonID)
    {
        $this->reasonID = $reasonID;

        $model = Reason::find($this->reasonID);

        $this->reason = $model->reason;
    }

    public function forcedClosedModal()
    {
        //reset public variables
        $this->resetInputFields();

        //reset validation errors
        $this->resetErrorBag();
        $this->resetValidation();
    }

    private function resetInputFields()
    {
        $this->reasonID = null;
        $this->reason = null;
    }

    public function addTruck()
    {

        $this->validate([
            'reason' => 'required',
        ]);

        $validatedData = [
            'reason' => $this->reason,
        ];

        if ($this->reasonID) {
            Reason::find($this->reasonID)->update($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Reason Updated Successfully']);
        } else {
            Reason::create($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Reason Added Successfully']);
        }

        $this->emit('refreshParent');
        $this->emit('closeFormModal');



        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.reason-form');
    }
}
