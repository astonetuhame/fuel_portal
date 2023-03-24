<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Lpo;
use App\Models\Comment;
use App\Models\Station;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AddLpoForm extends Component
{
    public $lpo_date, $station_id, $quantity, $comment_id;
    public $lpoID;
    public $loading;
    public $stationSearch = '';


    protected $listeners = ['getLpoID', 'forcedClosedModal'];

    public function mount()
    {
        $this->lpo_date = Carbon::now()->format('Y-m-d');
    }

    public function getLpoID($lpoID)
    {
        $this->lpoID = $lpoID;

        $model = Lpo::find($this->lpoID);

        $this->lpo_date = $model->date;
        $this->station = $model->station;
        $this->quantity = $model->quantity;
        $this->station_id = $model->station_id;
        $this->comment_id = $model->comment_id;
    }



    public function selectStation($station_id)
    {

        $this->station_id = $station_id;
        $this->stationSearch = '';
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
        $this->lpoID = null;
        // $this->lpo_date = null;
        $this->station_id = null;
        $this->quantity = null;
        $this->comment_id = null;
    }

    public function addLpo()
    {

        $this->validate([
            'lpo_date' => 'required',
            'station_id' => 'required',
            'quantity' => 'required',
            'comment_id' => 'required',
        ]);


        $validatedData = [
            'date' => $this->lpo_date,
            'station_id' => $this->station_id,
            'loading_id' => $this->loading->id,
            'quantity' => $this->quantity,
            'comment_id' => $this->comment_id,
        ];

        if ($this->lpoID) {
            Lpo::find($this->lpoID)->update($validatedData);
            // if($station->name == "GARAGE NAIROBI" || $station->name == "GARAGE MUKONO"){
            //     $station->update(['quantity' =>  $station->quantity - $this->quantity]);
            // }
            $this->emit('alert', ['type' => 'success', 'message' => 'Updated Successfully']);
        } else {
            try {
                DB::beginTransaction();
                $station = Station::where('id', $this->station_id)->first();
                $lpo = Lpo::create($validatedData + ['rate' => $station->rate]);
                $lpo->loadings()->attach($this->loading->id, ['loading_date' => $this->loading->loading_date]);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                $this->emit('alert', ['type' => 'warning', 'message' => $e->getMessage()]);
            }

            $this->emit('alert', ['type' => 'success', 'message' => 'Added Successfully']);
        }

        $this->emit('refreshParent');
        $this->emit('closeFormModal');



        $this->resetInputFields();
    }

    public function render()
    {
        $searchStations = [];


        if (strlen($this->stationSearch) >= 2) {
            $searchStations = Station::where('name', 'LIKE', '%' . $this->stationSearch . '%')
                ->orderBy('name', 'asc')->get();
        }



        $stations = Station::orderBy('name', 'asc')->get();
        $comments = Comment::whereNotNull('comment')->orderBy('comment', 'asc')->get();

        return view('livewire.add-lpo-form', compact('searchStations', 'stations', 'comments'));
    }
}
